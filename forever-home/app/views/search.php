<?php require __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Search Animals</h1>
    </div>

    <div class="card mb-2" style="max-width: 520px;">
        <form method="GET" action="index.php">
            <input type="hidden" name="action" value="search">
            <div class="form-group">
                <label for="species">Species</label>
                <input type="text" id="species" name="species"
                       placeholder="e.g. Dog, Cat, Rabbit"
                       value="<?= htmlspecialchars($species) ?>">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">Any</option>
                    <option value="available"  <?= $status === 'available'  ? 'selected' : '' ?>>Available</option>
                    <option value="pending"    <?= $status === 'pending'    ? 'selected' : '' ?>>Pending</option>
                    <option value="adopted"    <?= $status === 'adopted'    ? 'selected' : '' ?>>Adopted</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <?php if (empty($animals)): ?>
        <p class="text-muted">No animals matched your search.</p>
    <?php else: ?>
        <div class="animal-grid">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <div class="species"><?= htmlspecialchars($animal['species']) ?></div>
                    <h3><?= htmlspecialchars($animal['name']) ?></h3>
                    <span class="badge"><?= htmlspecialchars($animal['status']) ?></span>
                    <p style="margin-top: 0.5rem"><?= htmlspecialchars($animal['description'] ?? '') ?></p>
                    <?php if ($animal['status'] === 'available'): ?>
                        <a href="index.php?action=adopt&id=<?= $animal['id'] ?>"
                           class="btn btn-primary btn-sm mt-2">Request Adoption</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/footer.php'; ?>
