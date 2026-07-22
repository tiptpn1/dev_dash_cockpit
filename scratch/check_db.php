<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$columns = DB::connection('hris')->select('SHOW COLUMNS FROM pegawai');
echo "Pegawai Columns: \n";
print_r(array_column($columns, 'Field'));

$tables = DB::connection('hris')->select('SHOW TABLES');
echo "\nTables: \n";
$tableNames = array_map(function($table) {
    return array_values((array)$table)[0];
}, $tables);
print_r(array_filter($tableNames, function($name) {
    return stripos($name, 'divisi') !== false || stripos($name, 'master') !== false || stripos($name, 'unit') !== false;
}));
