<?php require __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Adoption Requests</h1>
    </div>

    <?php if (empty($requests)): ?>
        <p class="text-muted">No adoption requests yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Animal</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $req): ?>
                    <tr>
                        <td><?= htmlspecialchars($req['email']) ?></td>
                        <td><?= htmlspecialchars($req['animal_name']) ?></td>
                        <td>
                            <span class="badge" style="
                                background: <?= match($req['status']) {
                                    'approved' => 'var(--sage-pale)',
                                    'rejected' => 'var(--terra-pale)',
                                    default    => 'var(--amber-pale)'
                                } ?>;
                                color: <?= match($req['status']) {
                                    'approved' => '#3a6b40',
                                    'rejected' => '#8b2c14',
                                    default    => 'var(--bark-light)'
                                } ?>">
                                <?= htmlspecialchars($req['status']) ?>
                            </span>
                        </td>
                        <td class="text-muted" style="max-width: 200px;">
                            <?= htmlspecialchars($req['message'] ?? '—') ?>
                        </td>
                        <td>
                            <?php if ($req['status'] === 'pending'): ?>
                                <a href="index.php?action=review_request&id=<?= $req['id'] ?>"
                                   class="btn btn-secondary btn-sm">Review</a>
                            <?php else: ?>
                                <span class="text-muted" style="font-size:0.85rem">Reviewed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
