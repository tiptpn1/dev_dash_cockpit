<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SONIA (Sistem Online Niaga) — SSO via static token
    |--------------------------------------------------------------------------
    |
    | Menu SONIA membuka tab baru ke endpoint SSO SONIA.
    | Token harus identik dengan AGRINAV_SSO_TOKEN di aplikasi SONIA.
    |
    */
    'sonia' => [
        'url' => rtrim(env('SONIA_URL', 'https://sonia.ptpn1.co.id'), '/'),
        'sso_token' => env('SONIA_SSO_TOKEN', ''),
    ],

];
