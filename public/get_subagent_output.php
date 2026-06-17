<?php
$file = 'C:/Users/ptpn1/.gemini/antigravity-ide/brain/19290fee-58c2-465f-a6a7-07fcfe142735/.system_generated/logs/transcript.jsonl';
if (!file_exists($file)) {
    die("File not found\n");
}

$lines = file($file);
foreach ($lines as $idx => $line) {
    if (strpos($line, '"type":"BROWSER_SUBAGENT"') !== false) {
        $data = json_decode($line, true);
        echo "Step $idx: BROWSER_SUBAGENT status: " . $data['status'] . "\n";
        echo "Content preview: " . substr($data['content'] ?? '', 0, 1500) . "\n\n";
    }
}
