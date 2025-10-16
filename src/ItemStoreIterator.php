<?php

namespace App;

use Iterator;
use PDO;
use PDOStatement;

class ItemStoreIterator implements Iterator
{
    private PDOStatement $stmt;
    private mixed $current;
    private int $key;

    public function __construct(PDOStatement $stmt)
    {
        $this->stmt = $stmt;
    }

    public function current(): mixed
    {
        return new Item($this->current['name'], $this->current['description']);
    }

    public function next(): void
    {
        $this->current = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $this->key++;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function valid(): bool
    {
        return $this->current !== false;
    }

    public function rewind(): void
    {
        $this->stmt->execute();
        $this->current = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $this->key = 0;
    }
}