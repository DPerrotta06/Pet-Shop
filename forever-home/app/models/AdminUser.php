<?php

// ============================================================
//  FOREVER HOME — AdminUser Model (STARTER / BROKEN VERSION)
//
//  TODO #4 — INHERITANCE
//
//  Right now AdminUser is a completely separate class that
//  duplicates all of User's logic. This is bad.
//
//  YOUR TASKS:
//  a) Make AdminUser EXTEND User instead of duplicating code.
//  b) Remove all the duplicated methods — AdminUser should
//     inherit them from User for free.
//  c) Add the $isAdminFlag property and isAdmin() method.
//  d) Call parent::__construct() inside AdminUser's constructor.
//
//  THEORY QUESTION: What does parent::__construct() do and
//  why is it needed here?
//
//  YOUR ANSWER: _______________________________________________
// ============================================================

class AdminUser extends User{

    public function __construct(
        ?int $id,
        string $email,
        string $passwordHash,
        public bool $isAdminFlag   // ← keep this
    ) {
        parent::__construct($id, $email, $passwordHash);
    }
    
    public function isAdmin() : bool {
        return $this->isAdminFlag;
    }
}
