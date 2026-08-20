<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$reg = Illuminate\Support\Facades\DB::connection('looker')->select('DESCRIBE regional');
echo "REGIONAL: " . json_encode(array_map(function($i){ return $i->Field; }, $reg)) . "\n";

$regData = Illuminate\Support\Facades\DB::connection('looker')->select('SELECT * FROM regional LIMIT 5');
echo "REGIONAL DATA:\n";
print_r($regData);
