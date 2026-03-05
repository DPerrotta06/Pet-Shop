<?php

// ============================================================
//  FOREVER HOME — Database Connection (Singleton)
//
//  THEORY QUESTION: This function uses a static variable to
//  ensure only one PDO instance is ever created. What design
//  pattern is this called, and what problem does it solve?
//
//  YOUR ANSWER: _______________________________________________
// ============================================================

function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $host   = 'localhost';
    $dbname = 'forever_home';
    $user   = 'root';
    $pass   = '';

    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION]
    );

    return $pdo;
}
