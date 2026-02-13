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
