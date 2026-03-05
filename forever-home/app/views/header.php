<?php
// ============================================================
//  FOREVER HOME — Header View (STARTER / BROKEN VERSION)
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forever Home 🐾</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav>
    <a href="index.php"><strong>🐾 Forever Home</strong></a>
    <a href="index.php?action=search">Search Animals</a>
    <?php if (User::isLoggedIn()): ?>
        <?php
            $adminUser = get_admin_user();
            if ($adminUser && $adminUser->isAdmin()): ?>
                <a href="index.php?action=admin_animals">Admin Panel</a>
                <a href="index.php?action=admin_requests">Requests</a>
            <?php endif; ?>
        <a href="index.php?action=profile">My Profile</a>
        <a href="index.php?action=logout">Log out</a>
    <?php else: ?>
        <a href="index.php?action=login">Login</a>
        <a href="index.php?action=register">Register</a>
    <?php endif; ?>
</nav>

<?php
// TODO #16 — Flash messages are not being displayed.
// Write the code to retrieve and render them correctly.
// Remember: type goes in the CSS class, message goes inside the div.
// Use htmlspecialchars() on both.
$flash = get_flash();
if($flash):
?>
<div class="alert <?= htmlspecialchars($flash['type']) ?>">
    <?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>
