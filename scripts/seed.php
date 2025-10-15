<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

$pdo = Database::getInstance();

echo "Dropping and creating table 'items'..." . PHP_EOL;
$pdo->exec("DROP TABLE IF EXISTS items;");
$pdo->exec("
    CREATE TABLE items (
        id SERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
");
echo "Table 'items' created." . PHP_EOL;

$recordCount = 100000;
echo "Inserting " . $recordCount . " records..." . PHP_EOL;

// Use a transaction for better performance
$pdo->beginTransaction();

$stmt = $pdo->prepare("INSERT INTO items (name, description) VALUES (?, ?)");

for ($i = 1; $i <= $recordCount; $i++) {
    $name = "Item " . $i;
    $description = "This is the description for item " . $i . ". " . bin2hex(random_bytes(16));
    $stmt->execute([$name, $description]);

    if ($i % 10000 === 0) {
        echo "Inserted " . $i . " records..." . PHP_EOL;
    }
}

$pdo->commit();

echo "Done. " . $recordCount . " records inserted." . PHP_EOL;
