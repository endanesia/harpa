<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;

class Iccn extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('iccn_sso');
        $this->load->helper('iccn_sso');
        $this->load->library('access');
        $this->load->model('access_model');
    }

    /**
     * Entry point: /iccn/login
     * Initiates OAuth 2.0 PKCE flow - generates PKCE parameters and redirects to SSO
     */
    public function login()
    {
        // Generate PKCE parameters
        $code_verifier = generate_code_verifier();
        $code_challenge = generate_code_challenge($code_verifier);
        $state = generate_state();

        // Store code_verifier and state in session for callback verification
        $this->session->set_userdata(array(
            'sso_code_verifier' => $code_verifier,
            'sso_state' => $state,
        ));

        // Build authorization URL
        $auth_url = $this->config->item('sso_auth_endpoint');
        $params = array(
            'client_id' => $this->config->item('sso_client_id'),
            'redirect_uri' => $this->config->item('sso_redirect_uri'),
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'state' => $state,
            'code_challenge' => $code_challenge,
            'code_challenge_method' => 'S256',
        );

        $redirect_url = $auth_url . '?' . http_build_query($params);

        // Redirect user to SSO login page
        redirect($redirect_url);
    }

    /**
     * Callback endpoint: /iccn/callback
     * Handles redirect from SSO after user authentication
     * Exchanges authorization code for tokens
     */
    public function callback()
    {
        // Get authorization code and state from query params
        $code = $this->input->get('code');
        $state = $this->input->get('state');
        $error = $this->input->get('error');

        // Check for errors from SSO
        if ($error) {
            $error_description = $this->input->get('error_description');
            log_message('error', 'ICCN SSO error: ' . $error . ' - ' . $error_description);
            $this->_redirect_with_error('SSO authentication failed: ' . $error);
            return;
        }

        // Validate required parameters
        if (!$code || !$state) {
            $this->_redirect_with_error('Missing authorization code or state');
            return;
        }

        // Verify state to prevent CSRF
        $stored_state = $this->session->userdata('sso_state');
        if (!$stored_state || $state !== $stored_state) {
            $this->_redirect_with_error('Invalid state parameter');
            return;
        }

        // Get stored code_verifier
        $code_verifier = $this->session->userdata('sso_code_verifier');
        if (!$code_verifier) {
            $this->_redirect_with_error('Missing code verifier');
            return;
        }

        // Exchange authorization code for tokens
        try {
            $tokens = $this->_exchange_code($code, $code_verifier);

            if (!$tokens) {
                $this->_redirect_with_error('Failed to exchange authorization code');
                return;
            }

            // Verify access token signature
            $claims = $this->_verify_jwt($tokens['access_token']);

            if (!$claims) {
                $this->_redirect_with_error('Token verification failed');
                return;
            }

            // Extract user info from JWT claims
            $email = isset($claims->email) ? $claims->email : null;
            $name = isset($claims->name) ? $claims->name :
                (isset($claims->preferred_username) ? $claims->preferred_username : null);
            $sub = isset($claims->sub) ? $claims->sub : null;

            if (!$email && !$sub) {
                $this->_redirect_with_error('No identity in token');
                return;
            }

            // Find or create local user dengan role admin
            $user = $this->_find_or_create_user($email, $name, $sub);

            if (!$user) {
                $this->_redirect_with_error('User provisioning failed');
                return;
            }

            // Store tokens in session for refresh
            $this->session->set_userdata(array(
                'sso_access_token' => $tokens['access_token'],
                'sso_refresh_token' => isset($tokens['refresh_token']) ? $tokens['refresh_token'] : null,
                'sso_id_token' => isset($tokens['id_token']) ? $tokens['id_token'] : null,
                'sso_token_expires_at' => time() + (isset($tokens['expires_in']) ? $tokens['expires_in'] : 300),
            ));

            // Clean up PKCE session data
            $this->session->unset_userdata(array('sso_code_verifier', 'sso_state'));

            // Create CI session (same as Access::login)
            $this->session->set_userdata('userid', $user->idtbUser);
            $this->session->set_userdata('nama', stripslashes($user->userName));
            $this->session->set_userdata('akses', stripslashes($user->userLevel));
            $this->session->set_userdata('unit', stripslashes($user->skpd));

            // Load access list
            $akses = json_encode($this->access->get_akses_list($user->userLevel));
            $this->session->set_userdata('akses_list', $akses);

            // Redirect to dashboard
            redirect('dashboard');

        } catch (\Exception $e) {
            log_message('error', 'ICCN SSO callback error: ' . $e->getMessage());
            $this->_redirect_with_error('Authentication error: ' . $e->getMessage());
        }
    }

    /**
     * Exchange authorization code for tokens
     * 
     * @param string $code Authorization code from SSO
     * @param string $code_verifier PKCE code verifier
     * @return array|null Token response or null on failure
     */
    private function _exchange_code($code, $code_verifier)
    {
        $token_endpoint = $this->config->item('sso_token_endpoint');

        $post_data = array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->config->item('sso_client_id'),
            'redirect_uri' => $this->config->item('sso_redirect_uri'),
            'code' => $code,
            'code_verifier' => $code_verifier,
        );

        $ch = curl_init($token_endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200 || !$response) {
            log_message('error', 'Token exchange failed. HTTP ' . $http_code . ': ' . $response);
            return null;
        }

        $data = json_decode($response, true);

        if (!$data || !isset($data['access_token'])) {
            log_message('error', 'Invalid token response: ' . $response);
            return null;
        }

        return $data;
    }

    /**
     * Refresh access token using refresh token
     * 
     * @return array|null New token response or null on failure
     */
    public function refresh_token()
    {
        $refresh_token = $this->session->userdata('sso_refresh_token');

        if (!$refresh_token) {
            $this->_json_response(array('success' => false, 'message' => 'No refresh token available'), 401);
            return null;
        }

        $token_endpoint = $this->config->item('sso_token_endpoint');

        $post_data = array(
            'grant_type' => 'refresh_token',
            'client_id' => $this->config->item('sso_client_id'),
            'refresh_token' => $refresh_token,
        );

        $ch = curl_init($token_endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200 || !$response) {
            log_message('error', 'Token refresh failed. HTTP ' . $http_code);
            $this->_json_response(array('success' => false, 'message' => 'Token refresh failed, please login again'), 401);
            return null;
        }

        $data = json_decode($response, true);

        if (!$data || !isset($data['access_token'])) {
            $this->_json_response(array('success' => false, 'message' => 'Invalid refresh response'), 401);
            return null;
        }

        // Update session with new tokens
        $this->session->set_userdata(array(
            'sso_access_token' => $data['access_token'],
            'sso_refresh_token' => isset($data['refresh_token']) ? $data['refresh_token'] : $refresh_token,
            'sso_id_token' => isset($data['id_token']) ? $data['id_token'] : $this->session->userdata('sso_id_token'),
            'sso_token_expires_at' => time() + (isset($data['expires_in']) ? $data['expires_in'] : 300),
        ));

        $this->_json_response(array('success' => true, 'message' => 'Token refreshed'));
        return $data;
    }

    /**
     * Logout from SSO and local application
     */
    public function logout()
    {
        $id_token = $this->session->userdata('sso_id_token');
        
        // Destroy local session
        $this->session->sess_destroy();

        // Build SSO logout URL with id_token_hint
        $logout_url = $this->config->item('sso_logout_endpoint');
        $params = array(
            'client_id' => $this->config->item('sso_client_id'),
            'post_logout_redirect_uri' => $this->config->item('sso_post_logout_redirect_uri'),
        );

        if ($id_token) {
            $params['id_token_hint'] = $id_token;
        }

        $redirect_url = $logout_url . '?' . http_build_query($params);

        // Redirect to SSO logout
        redirect($redirect_url);
    }

    /**
     * Entry point: /iccn/iframe
     * This page is loaded inside ICCN Super App iframe.
     * For ICCN Super App integration - receives token via query parameter
     */
    public function iframe()
    {
        // Log for debugging
        log_message('info', 'ICCN iframe accessed from: ' . $this->input->server('HTTP_REFERER'));
        log_message('info', 'ICCN iframe URL: ' . current_url());
        
        // Check if token is passed via query parameter (from ICCN Super App)
        $token = $this->input->get('t');
        
        if ($token) {
            log_message('info', 'ICCN token received, length: ' . strlen($token));
            
            // Token passed from ICCN, verify and login
            try {
                // Verify JWT signature via JWKS
                $claims = $this->_verify_jwt($token);

                if (!$claims) {
                    log_message('error', 'ICCN token verification failed');
                    redirect('https://pilarsejahtera.com/harpa');
                    return;
                }

                log_message('info', 'ICCN token verified successfully');

                // Extract user info from JWT claims
                $email = isset($claims->email) ? $claims->email : null;
                $name = isset($claims->name) ? $claims->name :
                    (isset($claims->preferred_username) ? $claims->preferred_username : null);
                $sub = isset($claims->sub) ? $claims->sub : null;

                log_message('info', 'ICCN user info - Email: ' . $email . ', Name: ' . $name . ', Sub: ' . $sub);

                if (!$email && !$sub) {
                    log_message('error', 'ICCN no identity in token');
                    redirect('https://pilarsejahtera.com/harpa');
                    return;
                }

                // Find or create local user dengan role admin
                $user = $this->_find_or_create_user($email, $name, $sub);

                if (!$user) {
                    log_message('error', 'ICCN user provisioning failed');
                    redirect('https://pilarsejahtera.com/harpa');
                    return;
                }

                log_message('info', 'ICCN user provisioned/found: ' . $user->userName . ' (ID: ' . $user->idtbUser . ')');

                // Store token in session
                $this->session->set_userdata(array(
                    'sso_access_token' => $token,
                    'sso_token_expires_at' => time() + 300, // 5 minutes default
                ));

                // Create CI session (same as Access::login)
                $this->session->set_userdata('userid', $user->idtbUser);
                $this->session->set_userdata('nama', stripslashes($user->userName));
                $this->session->set_userdata('akses', stripslashes($user->userLevel));
                $this->session->set_userdata('unit', stripslashes($user->skpd));

                // Load access list
                $akses = json_encode($this->access->get_akses_list($user->userLevel));
                $this->session->set_userdata('akses_list', $akses);

                log_message('info', 'ICCN user logged in successfully, redirecting to dashboard');

                // Redirect to dashboard
                redirect('dashboard');

            } catch (\Exception $e) {
                log_message('error', 'ICCN iframe token verification error: ' . $e->getMessage());
                log_message('error', 'ICCN error trace: ' . $e->getTraceAsString());
                redirect('https://pilarsejahtera.com/harpa');
            }
        } else {
            log_message('info', 'ICCN iframe accessed without token parameter');
            
            // If already logged in, redirect to dashboard
            if ($this->access->is_login()) {
                log_message('info', 'ICCN user already logged in, redirecting to dashboard');
                redirect('dashboard');
                return;
            }
            
            // No token and not logged in - redirect to pilarsejahtera.com/harpa
            log_message('warning', 'ICCN no token provided and user not logged in, redirecting to pilarsejahtera.com/harpa');
            redirect('https://pilarsejahtera.com/harpa');
        }
    }

    /**
     * AJAX endpoint: /iccn/sso_verify
     * Receives JWT access token from frontend (postMessage), verifies via JWKS,
     * creates internal CI session, returns status.
     */
    public function sso_verify()
    {
        // Only accept POST
        if ($this->input->method() !== 'post') {
            $this->_json_response(array('success' => false, 'message' => 'Method not allowed'), 405);
            return;
        }

        // Get JSON body
        $raw = $this->input->raw_input_stream;
        $body = json_decode($raw, true);

        if (!$body || empty($body['token'])) {
            $this->_json_response(array('success' => false, 'message' => 'Token is required'), 400);
            return;
        }

        $token = $body['token'];

        try {
            // Verify JWT signature via JWKS
            $claims = $this->_verify_jwt($token);

            if (!$claims) {
                $this->_json_response(array('success' => false, 'message' => 'Token verification failed'), 401);
                return;
            }

            // Extract user info from JWT claims
            $email = isset($claims->email) ? $claims->email : null;
            $name  = isset($claims->name) ? $claims->name :
                     (isset($claims->preferred_username) ? $claims->preferred_username : null);
            $sub   = isset($claims->sub) ? $claims->sub : null;

            if (!$email && !$sub) {
                $this->_json_response(array('success' => false, 'message' => 'No identity in token'), 401);
                return;
            }

            // Find or create local user with admin role
            $user = $this->_find_or_create_user($email, $name, $sub);

            if (!$user) {
                $this->_json_response(array('success' => false, 'message' => 'User provisioning failed'), 500);
                return;
            }

            // Store token in session
            $this->session->set_userdata(array(
                'sso_access_token' => $token,
                'sso_token_expires_at' => time() + 300,
            ));

            // Create CI session (same as Access::login)
            $this->session->set_userdata('userid', $user->idtbUser);
            $this->session->set_userdata('nama', stripslashes($user->userName));
            $this->session->set_userdata('akses', stripslashes($user->userLevel));
            $this->session->set_userdata('unit', stripslashes($user->skpd));

            // Load access list
            $akses = json_encode($this->access->get_akses_list($user->userLevel));
            $this->session->set_userdata('akses_list', $akses);

            $this->_json_response(array(
                'success'  => true,
                'message'  => 'SSO login successful',
                'redirect' => site_url('dashboard'),
            ));

        } catch (\Exception $e) {
            log_message('error', 'ICCN SSO verify error: ' . $e->getMessage());
            $this->_json_response(array('success' => false, 'message' => 'Token invalid: ' . $e->getMessage()), 401);
        }
    }

    /**
     * Verify JWT token using Keycloak JWKS endpoint.
     * 
     * @param string $token JWT access token
     * @return object|null Decoded JWT claims or null on failure
     */
    private function _verify_jwt($token)
    {
        $jwks_url = $this->config->item('sso_jwks_url');
        $issuer   = $this->config->item('sso_issuer');

        // Fetch JWKS from Keycloak
        $ch = curl_init($jwks_url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ));
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200 || !$response) {
            throw new \Exception('Failed to fetch JWKS from SSO server');
        }

        $jwks = json_decode($response, true);
        if (!$jwks || !isset($jwks['keys'])) {
            throw new \Exception('Invalid JWKS response');
        }

        // Keycloak JWKS keys may not have 'alg' field — set default
        foreach ($jwks['keys'] as &$key) {
            if (!isset($key['alg'])) {
                $key['alg'] = 'RS256';
            }
        }
        unset($key);

        // Parse JWKS keys
        $keySet = JWK::parseKeySet($jwks, 'RS256');

        // Decode and verify JWT
        $decoded = JWT::decode($token, $keySet);

        // Validate issuer
        if (isset($decoded->iss) && $decoded->iss !== $issuer) {
            throw new \Exception('Invalid token issuer');
        }

        return $decoded;
    }

    /**
     * Find existing user by email, or create a new one with admin role.
     * 
     * @param string $email User email from SSO
     * @param string $name User name from SSO
     * @param string $sso_sub SSO subject identifier
     * @return object|null User object or null on failure
     */
    private function _find_or_create_user($email, $name, $sso_sub)
    {
        // Try to find by email first
        if ($email) {
            $this->db->where('email', $email);
            $result = $this->db->get('tbUser');
            if ($result->num_rows() > 0) {
                return $result->row();
            }
        }

        // Try to find by userName matching SSO name
        if ($name) {
            $this->db->where('userName', $name);
            $result = $this->db->get('tbUser');
            if ($result->num_rows() > 0) {
                return $result->row();
            }
        }

        // Auto-provision: create new user from SSO data with admin role
        $username = $name ? $name : ($email ? explode('@', $email)[0] : 'sso_' . substr($sso_sub, 0, 8));
        
        $data = array(
            'userName'     => $username,
            'userPassword' => md5(bin2hex(random_bytes(16))), // random password — SSO users don't use password login
            'email'        => $email,
            'userLevel'    => $this->config->item('sso_default_user_level'), // Admin role
            'skpd'         => $this->config->item('sso_default_skpd'),
            'status'       => 1,
        );

        $this->db->insert('tbUser', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->db->where('idtbUser', $insert_id);
            return $this->db->get('tbUser')->row();
        }

        return null;
    }

    /**
     * Redirect to fallback URL with error message
     * 
     * @param string $message Error message to log
     */
    private function _redirect_with_error($message)
    {
        log_message('error', 'ICCN SSO Error: ' . $message);
        
        // Clear any SSO session data
        $this->session->unset_userdata(array(
            'sso_code_verifier',
            'sso_state',
            'sso_access_token',
            'sso_refresh_token',
            'sso_id_token',
            'sso_token_expires_at',
        ));

        // Redirect to fallback URL
        $fallback_url = $this->config->item('sso_post_logout_redirect_uri');
        redirect($fallback_url);
    }

    /**
     * Show error page (untuk iframe context)
     * 
     * @param string $message Error message
     */
    private function _show_error_page($message)
    {
        log_message('error', 'ICCN SSO Error: ' . $message);
        
        // Show simple error page
        $data = array(
            'error_message' => $message,
            'fallback_url' => 'https://pilarsejahtera.com/harpa',
        );
        
        $this->load->view('iccn/error', $data);
    }

    /**
     * Send JSON response.
     * 
     * @param array $data Response data
     * @param int $status HTTP status code
     */
    private function _json_response($data, $status = 200)
    {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
