<?php require __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>My Profile</h1>
    </div>

    <div class="card mb-2">
        <h3 style="margin-bottom: 0.5rem">Account</h3>
        <p class="text-muted"><?= htmlspecialchars($user->email) ?></p>
    </div>

    <h2 style="margin: 2rem 0 1rem">My Adoption Requests</h2>

    <?php if (empty($requests)): ?>
        <p class="text-muted">You haven't submitted any adoption requests yet.
            <a href="index.php">Browse animals →</a>
        </p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Species</th>
                    <th>Status</th>
                    <th>Your Message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $req): ?>
                    <tr>
                        <td><?= htmlspecialchars($req['animal_name']) ?></td>
                        <td><?= htmlspecialchars($req['species']) ?></td>
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
                        <td class="text-muted"><?= htmlspecialchars($req['message'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/footer.php'; ?>
