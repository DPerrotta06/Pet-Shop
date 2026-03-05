<?php require __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Review Request</h1>
        <a href="index.php?action=admin_requests" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card" style="max-width: 480px;">
        <p><strong>Request ID:</strong> #<?= $request['id'] ?></p>
        <p class="mt-1"><strong>Message:</strong> <?= htmlspecialchars($request['message'] ?? 'None provided') ?></p>

        <form method="POST" action="index.php?action=review_request&id=<?= $request['id'] ?>" style="margin-top: 1.5rem;">
            <div class="form-group">
                <label for="status">Decision</label>
                <select id="status" name="status">
                    <option value="approved">Approve</option>
                    <option value="rejected">Reject</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Decision</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
