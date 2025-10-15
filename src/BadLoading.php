<?php
namespace App;

use PDO;

class BadLoading
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function run(): void
    {
        echo "Running BadLoading (fetchAll)..." . PHP_EOL;
        $initialMemory = memory_get_usage();
        echo "Initial memory usage: " . $this->formatBytes($initialMemory) . PHP_EOL;

        // Fetch all records at once
        $stmt = $this->pdo->query("SELECT * FROM items");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $memoryAfterFetch = memory_get_usage();
        echo "Memory after fetchAll: " . $this->formatBytes($memoryAfterFetch) . PHP_EOL;
        echo "Memory used by fetchAll: " . $this->formatBytes($memoryAfterFetch - $initialMemory) . PHP_EOL;

        // Simulate processing
        $processedCount = 0;
        foreach ($items as $item) {
            // Simulate some light processing
            $processedCount++;
        }

        echo "Processed " . $processedCount . " items." . PHP_EOL;
        $peakMemory = memory_get_peak_usage();
        echo "Peak memory usage: " . $this->formatBytes($peakMemory) . PHP_EOL;
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
