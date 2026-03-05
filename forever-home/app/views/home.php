<?php require __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="hero">
        <h1>Find Your Forever Friend 🐾</h1>
        <p>Every animal here is looking for a loving home. Could yours be the one?</p>
        <?php if (!User::isLoggedIn()): ?>
            <a href="index.php?action=register" class="btn btn-primary">Get Started</a>
        <?php endif; ?>
    </div>

    <?php if (empty($animals)): ?>
        <p class="text-center text-muted">No animals available right now. Check back soon!</p>
    <?php else: ?>
        <div class="animal-grid">
            <?php foreach ($animals as $animal): ?>
                <div class="animal-card">
                    <div class="species"><?= htmlspecialchars($animal['species']) ?></div>
                    <h3><?= htmlspecialchars($animal['name']) ?></h3>
                    <span class="badge"><?= $animal['age'] ?> yr<?= $animal['age'] !== 1 ? 's' : '' ?> old</span>
                    <?php if ($animal['description']): ?>
                        <p style="margin-top: 0.75rem"><?= htmlspecialchars($animal['description']) ?></p>
                    <?php endif; ?>
                    <?php if (User::isLoggedIn()): ?>
                        <a href="index.php?action=adopt&id=<?= $animal['id'] ?>"
                           class="btn btn-primary btn-sm mt-2">Request Adoption</a>
                    <?php else: ?>
                        <a href="index.php?action=login"
                           class="btn btn-secondary btn-sm mt-2">Login to Adopt</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/footer.php'; ?>