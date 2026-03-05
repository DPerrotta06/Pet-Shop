<?php require __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Manage Animals</h1>
        <a href="index.php?action=create_animal" class="btn btn-primary">+ Add Animal</a>
    </div>

    <?php if (empty($animals)): ?>
        <p class="text-muted">No animals in the system yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Species</th>
                    <th>Age</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animals as $animal): ?>
                    <tr>
                        <td><?= htmlspecialchars($animal['name']) ?></td>
                        <td><?= htmlspecialchars($animal['species']) ?></td>
                        <td><?= $animal['age'] ?> yr<?= $animal['age'] !== 1 ? 's' : '' ?></td>
                        <td class="text-muted"><?= htmlspecialchars($animal['description'] ?? '') ?></td>
                        <td>
                            <div class="actions">
                                <a href="index.php?action=edit_animal&id=<?= $animal['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="index.php?action=delete_animal&id=<?= $animal['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
