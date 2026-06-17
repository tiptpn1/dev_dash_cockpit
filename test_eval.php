<?php
$base = 'http://dashboard_cockpit.test:8080';
$token = 'ptpn1-hris-eval-2024-xK9mPqRs';

echo "=== 1. TEST MAIN PAGE ===\n";
$ch = curl_init("$base/evaluasi-aplikasi?token=$token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$r = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP:$code\n";
echo substr($r, 0, 3000);
echo "\n\n";
curl_close($ch);

echo "=== 2. TEST API: hris-data ===\n";
$ch = curl_init("$base/evaluasi-aplikasi/hris-data?token