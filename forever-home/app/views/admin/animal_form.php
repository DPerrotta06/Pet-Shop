<?php require __DIR__ . '/../header.php'; ?>

<?php $isEdit = isset($animal) && $animal !== null; ?>

<div class="container">
    <div class="page-header">
        <h1><?= $isEdit ? 'Edit Animal' : 'Add New Animal' ?></h1>
        <a href="index.php?action=admin_animals" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card" style="max-width: 560px;">

        <?php if (isset($error)): ?>
            <p class="error-text mb-2"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=<?= $isEdit ? 'edit_animal&id=' . $animal['id'] : 'create_animal' ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required
                       value="<?= htmlspecialchars($animal['name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="species">Species</label>
                <input type="text" id="species" name="species" required
                       value="<?= htmlspecialchars($animal['species'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="age">Age (years)</label>
                <input type="number" id="age" name="age" min="0" max="30"
                       value="<?= htmlspecialchars($animal['age'] ?? '0') ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"><?= htmlspecialchars($animal['description'] ?? '') ?></textarea>
            </div>
            <div style="display:flex; gap: 0.75rem; margin-top: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? 'Save Changes' : 'Add Animal' ?>
                </button>
                <a href="index.php?action=admin_animals" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
