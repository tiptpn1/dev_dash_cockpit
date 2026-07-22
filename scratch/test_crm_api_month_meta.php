<?php
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = 'c34ad1cf6f6282c153ecf9bb7c9da40bac27fb92d11de5f8';

$response = \Illuminate\Support\Facades\Http::withoutVerifying()
    ->withHeaders(['x-api-key' => $apiKey])
    ->get('https://crm2025.holding-perkebunan.com/api/allocation/approved-prices', [
        'date_from' => '2026-06-01',
        'date_to' => '2026-06-30',
        'per_page' => 100
    ]);
    
$data = $response->json();
echo "Total in month: " . ($data['meta']['total'] ?? 'unknown') . "\n";
echo "Total pages: " . ($data['meta']['last_page'] ?? 'unknown') . "\n";
