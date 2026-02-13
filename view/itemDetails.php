<?php 

use CsLogs\Models\Item;

var_dump($item);

?>

<div style="max-width: 600px; margin: 20px auto; font-family: sans-serif;">
    <?php if ($item): ?>
        <h2>Item Details</h2>
        <ul style="list-style: none; padding: 0;">
            <li><strong>ID:</strong> <?= htmlspecialchars($item->id) ?></li>
            <li><strong>Name:</strong> <?= htmlspecialchars($item->name) ?></li>
            <li><strong>Price:</strong> <?= $item->price !== null ? '$' . number_format($item->price, 2) : 'N/A' ?></li>
            <li><strong>Volume:</strong> <?= $item->volume ?? 'N/A' ?></li>
        </ul>
    <?php else: ?>
        <p>Item not found.</p>
    <?php endif; ?>
</div>