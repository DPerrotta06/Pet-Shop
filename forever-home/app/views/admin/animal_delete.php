<?php require __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Delete Animal</h1>
        <a href="index.php?action=admin_animals" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card" style="max-width: 480px;">
        <div class="confirm-box">
            <p>Are you sure you want to delete <strong><?= htmlspecialchars($animal['name']) ?></strong>?</p>
            <p class="mt-1" style="font-size: 0.875rem;">This action cannot be undone.</p>
        </div>

        <form method="POST" action="index.php?action=delete_animal&id=<?= $animal['id'] ?>">
            <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <a href="index.php?action=admin_animals" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
