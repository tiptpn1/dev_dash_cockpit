<?php
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = 'c34ad1cf6f6282c153ecf9bb7c9da40bac27fb92d11de5f8';
$date = '2026-06-26';

$response = \Illuminate\Support\Facades\Http::withoutVerifying()
    ->withHeaders(['x-api-key' => $apiKey])
    ->get('https://crm2025.holding-perkebunan.com/api/allocation/approved-prices', [
        'date' => $date,
        'per_page' => 1000
    ]);

echo "Status: " . $response->status() . "\n";
echo "Body:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT);
