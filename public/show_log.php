<?php
/**
 * ⚠️ DELETE THIS FILE AFTER USE! ⚠️
 * URL: https://baancream.after-spa.com/show_log.php
 */

$logFile = __DIR__ . '/../storage/logs/laravel.log';

echo '<pre style="font-family:monospace;font-size:12px;background:#1e1e1e;color:#d4d4d4;padding:20px;white-space:pre-wrap;word-break:break-all;">';
echo "=== Laravel Error Log (Last 200 lines) ===\n\n";

if (!file_exists($logFile)) {
    echo "❌ Log file not found: {$logFile}\n";
} else {
    $lines = file($logFile);
    $total = count($lines);
    $last = array_slice($lines, max(0, $total - 200));
    echo implode('', $last);
}

echo '</pre>';
