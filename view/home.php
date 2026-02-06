<?php 

use CsLogs\Models\Item;

$items = Item::selectAll("AK-47");

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
          <td><?= number_format($item->price, 2) ?></td>
          <td><?= $item->volume ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>