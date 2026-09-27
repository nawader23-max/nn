<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin IP Whitelist
    |--------------------------------------------------------------------------
    | Comma-separated list of IP addresses allowed to access admin routes.
    | Leave empty to disable IP-based restrictions (useful for development).
    | Example: "203.0.113.10, 198.51.100.22"
    */
    'admin_allowed_ips' => env('ADMIN_ALLOWED_IPS', ''),

    /*
    |--------------------------------------------------------------------------
    | Honeypot Anti-Bot Protection
    |--------------------------------------------------------------------------
    | When enabled, forms include an invisible field that bots auto-fill.
    | Filled honeypot = bot detected → silent rejection.
    */
    'honeypot_enabled'    => env('HONEYPOT_ENABLED', true),
    'honeypot_field_name' => env('HONEYPOT_FIELD_NAME', 'sovereign_token_verify'),

    /*
    |--------------------------------------------------------------------------
    | Login Attempt Throttling
    |--------------------------------------------------------------------------
    | Maximum failed login attempts before temporary lockout.
    */
    'max_login_attempts'   => (int) env('MAX_LOGIN_ATTEMPTS', 5),
    'login_lockout_minutes' => (int) env('LOGIN_LOCKOUT_MINUTES', 15),

    /*
    |--------------------------------------------------------------------------
    | Audit Trail
    |--------------------------------------------------------------------------
    | Enable comprehensive audit logging for sensitive operations.
    */
    'audit_enabled' => env('AUDIT_TRAIL_ENABLED', true),

];
