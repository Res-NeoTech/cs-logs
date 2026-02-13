<?php 


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