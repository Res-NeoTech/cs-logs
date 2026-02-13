<?php

namespace CsLogs\Models;

class Item {
    public ?int $id = null;
    public ?string $name = null;
    public ?float $price = null;
    public ?int $volume = null;
    public ?array $history = [];
    public static array $items = []; 

    public static function selectAll(?string $nameFilter = null): array
    {
        $dir = __DIR__ . '/../logs/prices/';
        
        if (!is_dir($dir)) {
            return [];
        }

        $files = glob($dir . '*.json');

        if (!$files) {
            return [];
        }

        // Sort files by date (oldest first)
        usort($files, function($a, $b) {
            preg_match('/prices_(\d{8}_\d{6})\.json$/', $a, $matchA);
            preg_match('/prices_(\d{8}_\d{6})\.json$/', $b, $matchB);
            return strcmp($matchA[1] ?? '', $matchB[1] ?? '');
        });

        $itemsHistory = [];

        // Load all items first (no filtering yet)
        foreach ($files as $file) {
            $json = file_get_contents($file);
            $data = json_decode($json, true);

            if (!isset($data['items'])) continue;

            foreach ($data['items'] as $row) {
                $name = $row['market_hash_name'] ?? null;
                if (!$name) continue;

                $snapshot = [
                    'price' => isset($row['price']) ? (float)$row['price'] : null,
                    'volume' => isset($row['volume']) ? (int)$row['volume'] : null,
                    'timestamp' => self::extractTimestamp($file)
                ];

                $itemsHistory[$name][] = $snapshot;
            }
        }

        // Build Item objects and assign IDs BEFORE filtering
        self::$items = [];
        $id = 1;
        foreach ($itemsHistory as $name => $history) {
            $item = new Item();
            $item->id = $id++;
            $item->name = $name;
            $item->price = $history[count($history)-1]['price'];
            $item->volume = $history[count($history)-1]['volume'];
            $item->history = $history;

            self::$items[] = $item;
        }

        if ($nameFilter !== null) {
             self::$items = array_values(array_filter(self::$items, fn($item) =>
                stripos($item->name, $nameFilter) !== false
            ));
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

    private static function extractTimestamp(string $file): ?string
    {
        if (preg_match('/prices_(\d{8}_\d{6})\.json$/', $file, $match)) {
            return $match[1]; // e.g., 20260206_151000
        }
        return null;
    }


}
