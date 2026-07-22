<?php
$resData = json_decode('{
    "success": true,
    "data": [
        {
            "allocation_id": 23902,
            "allocation_date": "2026-06-26",
            "symbol_code": "TUBU"
        }
    ]
}', true);

$items = [];
if (isset($resData['data']['data'])) {
    $items = $resData['data']['data'];
    echo "Branch 1\n";
} elseif (isset($resData['data'])) {
    $items = $resData['data'];
    echo "Branch 2\n";
}
echo "Items: " . count($items) . "\n";

$regional = 'semua';
$allData = [];
foreach ($items as $item) {
    if ($regional != 'semua') {
        $itemReg = $item['symbol_code'] ?? ($item['regional'] ?? '');
        if (strtoupper($itemReg) != strtoupper($regional)) {
            continue;
        }
    }
    $allData[] = $item;
}
echo "AllData: " . count($allData) . "\n";
