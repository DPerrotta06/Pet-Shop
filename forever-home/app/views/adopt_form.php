<?php require __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Adopt <?= htmlspecialchars($animal['name']) ?></h1>
        <a href="index.php" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card" style="max-width: 520px;">
        <p class="text-muted mb-2">
            Tell us a little about yourself and why you'd be a great match
            for <strong><?= htmlspecialchars($animal['name']) ?></strong>.
        </p>
        <form method="POST" action="index.php?action=adopt&id=<?= $animal['id'] ?>">
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Why do you want to adopt this animal?"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
