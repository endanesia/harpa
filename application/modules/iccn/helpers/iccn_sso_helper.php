<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ICCN SSO Helper
 * Helper functions for OAuth 2.0 PKCE flow
 */

if (!function_exists('generate_code_verifier')) {
    /**
     * Generate PKCE code_verifier
     * Random 32 bytes encoded as base64url
     * 
     * @return string
     */
    function generate_code_verifier() {
        $bytes = random_bytes(32);
        return rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
    }
}

if (!function_exists('generate_code_challenge')) {
    /**
     * Generate PKCE code_challenge from code_verifier
     * SHA256 hash of verifier, encoded as base64url
     * 
     * @param string $verifier
     * @return string
     */
    function generate_code_challenge($verifier) {
        $hash = hash('sha256', $verifier, true);
        return rtrim(strtr(base64_encode($hash), '+/', '-_'), '=');
    }
}

if (!function_exists('generate_state')) {
    /**
     * Generate random state parameter
     * 
     * @return string
     */
    function generate_state() {
        return bin2hex(random_bytes(16));
    }
}
