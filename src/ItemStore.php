<?php

namespace App;

use IteratorAggregate;
use Traversable;

class ItemStore implements IteratorAggregate
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function getIterator(): Traversable
    {
        $stmt = $this->pdo->prepare("SELECT * FROM items");
        return new ItemStoreIterator($stmt);
    }
}