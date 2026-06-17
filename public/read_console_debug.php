<?php
$file = 'C:/Users/ptpn1/.gemini/antigravity-ide/brain/19290fee-58c2-465f-a6a7-07fcfe142735/.system_generated/logs/transcript.jsonl';
if (!file_exists($file)) {
    die("File not found\n");
}

$lines = file($file);
foreach ($lines as $line) {
    if (stripos($line, 'capture_browser_console_logs') !== false) {
        $data = json_decode($line, true);
        echo "Index: " . $data['step_index'] . " | Type: " . $data['type'] . "\n";
    }
}
