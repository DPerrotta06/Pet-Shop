<?php

// ============================================================
//  FOREVER HOME — User Model (STARTER / BROKEN VERSION)
// ============================================================

class User {

    public function __construct(
        public readonly ?int   $id,
        public readonly string $email,
        public readonly string $passwordHash,
    ) {}

    // Read — OK as-is
    public static function findByEmail(string $email): ?User {
        $db   = db();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row  = $stmt->fetch();
        if (!$row) return null;
        return new User($row['id'], $row['email'], $row['password_hash']);
    }

    // Read — OK as-is
    public static function findById(int $id): ?User {
        $db   = db();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        if (!$row) return null;
        return new User($row['id'], $row['email'], $row['password_hash']);
    }

    // ----------------------------------------------------------
    // TODO #3 — DEPENDENCY INJECTION
    // Fix this write method to accept $db as its first parameter.
    // ----------------------------------------------------------
    public static function create(PDO $db, string $email, string $password): ?User {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO users (email, password_hash) VALUES (?, ?)');
        $stmt->execute([$email, $hash]);
        $id   = (int) $db->lastInsertId();
        return new User($id, $email, $hash);
    }

    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->passwordHash);
    }

    public static function login(User $user): void {
        $_SESSION['user_id'] = $user->id;
    }

    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function logout(): void {
        unset($_SESSION['user_id']);
        session_destroy();
    }
}
