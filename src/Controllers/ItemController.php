<?php

namespace CsLogs\Controllers;

use Nicolas\EmptySlim\Model\Database;
use Nicolas\EmptySlim\Model\Category;

$path = __DIR__ . '/../src/logs/prices_20260206_151000.json';

$json = file_get_contents($path);

$data = json_decode($json, true);

// Access items
$items = $data['items'];

// Loop through items
foreach ($items as $item) {
    echo "Name: " . $item['market_hash_name'] . "<br>";
    echo "Volume: " . $item['volume'] . "<br>";
    echo "Price: " . $item['price'] . "<br><br>";
}

