<?php

namespace CsLogs\Models;

class Item {
    public ?int $id = null;
    public ?string $name = null;
    public ?float $price = null;
    public ?int $volume = null;
    public static array $items = []; 

    public static function selectAll(?string $nameFilter = null): array
    {
        $path = __DIR__ . '/../logs/prices/prices_20260206_151000.json';

        if (!file_exists($path)) {
            return [];
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!isset($data['items'])) {
            return [];
        }

        self::$items = [];

        foreach ($data['items'] as $index => $row) {

            $name = $row['market_hash_name'] ?? null;

            // Filter by name if filter provided
            if ($nameFilter !== null && stripos($name, $nameFilter) === false) {
                continue;
            }

            $item = new Item();
            $item->id = $index + 1;
            $item->name = $name;
            $item->price = isset($row['price']) ? (float)$row['price'] : null;
            $item->volume = isset($row['volume']) ? (int)$row['volume'] : null;

            self::$items[] = $item;
        }

        return self::$items;
    }

    public static function getById(int $id): ?Item
    {
        if (empty(self::$items)) {
            self::selectAll();
        }

        foreach (self::$items as $item) {
            if ($item->id === $id) {
                return $item;
            }
        }

        return null;
    }
}