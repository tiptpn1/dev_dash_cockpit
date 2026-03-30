<?php

return [
    /*
    |--------------------------------------------------------------------------
    | BigQuery Key File Path
    |--------------------------------------------------------------------------
    | storage_path() resolves to the correct absolute path on any OS
    | (Windows local, Linux server, Docker, etc.)
    |
    | Place your Service Account JSON file at:
    |   storage/app/google/bigquery-key.json
    |
    | On local  : C:\laragon\www\...\storage\app\google\bigquery-key.json
    | On server : /var/www/html/.../storage/app/google/bigquery-key.json
    */
    'keyFilePath' => env('GOOGLE_APPLICATION_CREDENTIALS', storage_path('app/google/bigquery-key.json')),

    /*
    |--------------------------------------------------------------------------
    | Google Cloud Project ID
    |--------------------------------------------------------------------------
    | Set GOOGLE_CLOUD_PROJECT_ID in your .env file
    */
    'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
];
