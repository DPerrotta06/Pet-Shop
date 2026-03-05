<?php require __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="card" style="max-width: 420px; margin: 0 auto;">
        <h2 style="margin-bottom: 1.5rem">Create an Account</h2>

        <?php if (isset($error)): ?>
            <p class="error-text mb-2"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=register">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p class="text-muted mt-2">
            Already have an account? <a href="index.php?action=login">Log in</a>
        </p>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
