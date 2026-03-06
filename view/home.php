<?php

use CsLogs\Models\Item;
use CsLogs\Utils\Redis;

$redis = Redis::get();

$items = $redis->get("item:AK-47");

if (is_string($items)) {
  $decoded = json_decode($items);
  $items = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
}

if (empty($items)) {
  $items = Item::selectAll("AK-47");
  Item::saveMarketSnapshot(json_encode(Item::fetchMarketData()));

  $redis->set("item:AK-47", json_encode($items), 'EX', 60 * 5);
}

?>

<div class="overflow-x-auto max-h-[500px]">
  <table class="table ">
    <!-- head -->
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Volume</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $index => $item): ?>
        <?php
          $name = is_array($item) ? ($item['name'] ?? '') : ($item->name ?? '');
          $price = is_array($item) ? ($item['price'] ?? 0) : ($item->price ?? 0);
          $volume = is_array($item) ? ($item['volume'] ?? 0) : ($item->volume ?? 0);
          $id = is_array($item) ? ($item['id'] ?? 0) : ($item->id ?? 0);
        ?>
        <tr class="hover:bg-base-300">
          <th><?= $index + 1 ?></th>
          <td><?= htmlspecialchars((string) $name) ?></td>
          <td><?= number_format((float) $price, 2) ?></td>
          <td><?= (int) $volume ?></td>
          <td><a href="/item/<?= (int) $id ?>" class="btn btn-primary">Details</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
