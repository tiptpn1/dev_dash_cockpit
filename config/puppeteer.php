<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Puppeteer Authentication Token
    |--------------------------------------------------------------------------
    |
    | Static token used for Puppeteer automation authentication
    | Generate a strong random token and store it in .env
    |
    | Example: PUPPETEER_AUTH_TOKEN=ptpn1-puppeteer-automation-2024-xK9mPqRs
    |
    */
    'auth_token' => env('PUPPETEER_AUTH_TOKEN', null),

    /*
    |--------------------------------------------------------------------------
    | Allowed IP Addresses
    |--------------------------------------------------------------------------
    |
    | Comma-separated list of IP addresses allowed to use Puppeteer auth
    | Leave empty to allow all IPs
    |
    | Examples:
    | - Single IP: 127.0.0.1
    | - Multiple IPs: 127.0.0.1,192.168.1.100
    | - CIDR notation: 192.168.1.0/24
    | - Wildcard: 192.168.1.*
    |
    */
    'allowed_ips' => env('PUPPETEER_ALLOWED_IPS', '127.0.0.1,::1,localhost'),

    /*
    |--------------------------------------------------------------------------
    | Default User for Puppeteer Sessions
    |--------------------------------------------------------------------------
    |
    | Default username to use for Puppeteer authentication
    | Can be overridden per request with ?username=xxx
    |
    */
    'default_user' => env('PUPPETEER_DEFAULT_USER', 'superadmin'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime of Puppeteer sessions in minutes
    | Default: 120 minutes (2 hours)
    |
    */
    'session_lifetime' => env('PUPPETEER_SESSION_LIFETIME', 120),

    /*
    |--------------------------------------------------------------------------
    | Enable Logging
    |--------------------------------------------------------------------------
    |
    | Log all Puppeteer authentication attempts
    |
    */
    'enable_logging' => env('PUPPETEER_ENABLE_LOGGING', true),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Maximum authentication attempts per IP per hour
    | Set to 0 to disable rate limiting
    |
    */
    'rate_limit_per_hour' => env('PUPPETEER_RATE_LIMIT', 100),
];
