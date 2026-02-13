<?php if (!isset($item) || $item === null): ?>
    <div class="rounded-lg border border-amber-500/40 bg-amber-500/10 p-4 text-amber-200">
        Item not found.
    </div>
<?php else: ?>
    <div class="card bg-slate-900 border border-slate-800">
        <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars((string) ($item->name ?? 'Unknown item')) ?></h2>
            <p><strong>ID:</strong> <?= (int) ($item->id ?? 0) ?></p>
            <p><strong>Price:</strong> <?= number_format((float) ($item->price ?? 0), 2) ?></p>
            <p><strong>Volume:</strong> <?= (int) ($item->volume ?? 0) ?></p>
            <div class="card-actions justify-end">
                <a href="/" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
<?php endif; ?>
