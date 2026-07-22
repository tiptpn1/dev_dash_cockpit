<?php
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = 'c34ad1cf6f6282c153ecf9bb7c9da40bac27fb92d11de5f8';

function checkApi($params) {
    global $apiKey;
    echo "Testing: " . json_encode($params) . "\n";
    $response = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->withHeaders(['x-api-key' => $apiKey])
        ->get('https://crm2025.holding-perkebunan.com/api/allocation/approved-prices', $params);
        
    echo "Status: " . $response->status() . "\n";
    $data = $response->json();
    if (isset($data['data'])) {
        echo "Items: " . count($data['data']) . "\n";
    } else {
        echo "No data field. Response: " . substr(json_encode($data), 0, 100) . "...\n";
    }
    echo "---------------------------\n";
}

// 1. Try start_date and end_date
checkApi([
    'start_date' => '2026-06-01',
    'end_date' => '2026-06-30',
    'per_page' => 100
]);

// 2. Try date_from and date_to
checkApi([
    'date_from' => '2026-06-01',
    'date_to' => '2026-06-30',
    'per_page' => 100
]);

// 3. Try month and year
checkApi([
    'month' => 6,
    'year' => 2026,
    'per_page' => 100
]);

// 4. Try just missing the date (to see if it returns all)
checkApi([
    'per_page' => 10
]);
