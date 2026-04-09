<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = DB::getSchemaBuilder()->getColumnListing('users');

echo "=== Users Table Columns ===\n";
foreach ($columns as $col) {
    echo "- $col\n";
}

echo "\n=== Full Table Info ===\n";
$tableInfo = DB::select("SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'users' AND TABLE_SCHEMA = DATABASE()");
foreach ($tableInfo as $col) {
    echo "{$col->COLUMN_NAME} ({$col->DATA_TYPE}) - Nullable: {$col->IS_NULLABLE}\n";
}

echo "\n=== Sample User Data ===\n";
$sample = DB::table('users')->first();
if ($sample) {
    echo json_encode($sample, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo "No users found\n";
}
