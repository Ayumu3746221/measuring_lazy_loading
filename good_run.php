<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\ItemStore;

function formatBytes(int $bytes, int $precision = 2): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . ' ' . $units[$pow];
}

echo "Running GoodLoading (Iterator)..." . PHP_EOL;
$initialMemory = memory_get_usage();
echo "Initial memory usage: " . formatBytes($initialMemory) . PHP_EOL;

$itemStore = new ItemStore();

// Simulate processing
$processedCount = 0;
foreach ($itemStore as $item) {
    // Simulate some light processing
    $processedCount++;
}

$memoryAfterLoop = memory_get_usage();
echo "Memory after loop: " . formatBytes($memoryAfterLoop) . PHP_EOL;

echo "Processed " . $processedCount . " items." . PHP_EOL;
$peakMemory = memory_get_peak_usage();
echo "Peak memory usage: " . formatBytes($peakMemory) . PHP_EOL;
echo "Memory used by Iterator: " . formatBytes($peakMemory - $initialMemory) . PHP_EOL;
