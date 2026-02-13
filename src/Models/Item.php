<?php

namespace CsLogs\Models;

class Item {
    public ?int $id = null;
    public ?string $name = null;
    public ?float $price = null;
    public ?int $volume = null;

    public static function selectAll(?string $nameFilter = null): array
    {
        // Path to JSON file
        $path = __DIR__ . '/../logs/prices/prices_20260206_151000.json';

        // Check if file exists
        if (!file_exists($path)) {
            return [];
        }

        // Read file
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        $items = [];

        if (!isset($data['items'])) {
            return [];
        }

        foreach ($data['items'] as $index => $row) {

            $name = $row['market_hash_name'] ?? null;

            if ($nameFilter !== null && stripos($name, $nameFilter) === false) {
                continue;
            }

            $item = new Item();
            $item->id = $index + 1;
            $item->name = $name;
            $item->price = isset($row['price']) ? (float)$row['price'] : null;
            $item->volume = isset($row['volume']) ? (int)$row['volume'] : null;

            $items[] = $item;
        }

        return $items;
    }
}