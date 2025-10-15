<?php
require_once __DIR__ . '/../vendor/autoload.php';

namespace App;

use App\Item;
use IteratorAggregate;
use Traversable;

class ItemStore implements IteratorAggregate
{
        public function getIterator(): Traversable
        {

        }
}
