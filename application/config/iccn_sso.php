<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| ICCN SSO Configuration
| -------------------------------------------------------------------
| Keycloak SSO settings for ICCN OAuth 2.0 + PKCE integration.
*/

// Keycloak SSO base URL
$config['sso_base_url'] = 'https://sso.iccn.or.id';

// Keycloak realm
$config['sso_realm'] = 'PORTALICCN';

// Client ID assigned by ICCN
$config['sso_client_id'] = 'harpa';

// Redirect URI untuk callback setelah login SSO
$config['sso_redirect_uri'] = 'https://harpa.pilarsejahtera.com/iccn/callback';

// Post logout redirect URI
$config['sso_post_logout_redirect_uri'] = 'https://pilarsejahtera.com/harpa';

// OpenID Connect endpoints
$config['sso_auth_endpoint'] = $config['sso_base_url'] . '/realms/' . $config['sso_realm'] . '/protocol/openid-connect/auth';
$config['sso_token_endpoint'] = $config['sso_base_url'] . '/realms/' . $config['sso_realm'] . '/protocol/openid-connect/token';
$config['sso_logout_endpoint'] = $config['sso_base_url'] . '/realms/' . $config['sso_realm'] . '/protocol/openid-connect/logout';

// JWKS endpoint (auto-built from base_url + realm)
$config['sso_jwks_url'] = $config['sso_base_url'] . '/realms/' . $config['sso_realm'] . '/protocol/openid-connect/certs';

// Expected issuer for JWT validation
$config['sso_issuer'] = $config['sso_base_url'] . '/realms/' . $config['sso_realm'];

// Trusted origins that may send postMessage (ICCN app domains)
$config['sso_trusted_origins'] = array(
    'https://next.iccn.or.id',
    'https://iccn.or.id',
    // 'http://localhost:3000', // uncomment for development
);

// Default user level for SSO-provisioned users (Admin)
$config['sso_default_user_level'] = '1'; // 1 = Admin

// Default unit/skpd for SSO-provisioned users
$config['sso_default_skpd'] = 1;
