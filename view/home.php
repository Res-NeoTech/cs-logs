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
        <tr class="hover:bg-base-300">
          <th><?= $index + 1 ?></th>
          <td><?= htmlspecialchars($item->name) ?></td>
          <td><?= htmlspecialchars($item->id) ?></td>
          <td><?= number_format($item->price, 2) ?></td>
          <td><?= $item->volume ?></td>
          <td><a href="/item/<?= $item->id ?>" class="btn btn-primary">Details</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>