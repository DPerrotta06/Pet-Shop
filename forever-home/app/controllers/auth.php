<?php

// ============================================================
//  FOREVER HOME — Auth Controller (STARTER / BROKEN VERSION)
// ============================================================

function auth_register(): void {
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $error = 'Email and password are required.';
        } elseif (User::findByEmail($email)) {
            $error = 'An account with that email already exists.';
        } else {
            // TODO #15 — DI: fix this call to inject db()
            $user = User::create(db(), $email, $password);

            // TODO #16 — FLASH: 'Account created! Please log in.' then redirect to index.php?action=login
            flash('Account created!', 'success');
            header('Location: index.php?action=login');
            exit;
        }
    }

    require __DIR__ . '/../views/register.php';
}

function auth_login(): void {
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $user     = User::findByEmail($email);

        if (!$user || !$user->verifyPassword($password)) {
            $error = 'Invalid email or password.';
        } else {
            User::login($user);
            header('Location: index.php');
            exit;
        }
    }

    require __DIR__ . '/../views/login.php';
}

function auth_logout(): void {
    User::logout();
    header('Location: index.php');
    exit;
}
