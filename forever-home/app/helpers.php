<?php

// ============================================================
//  FOREVER HOME — Helpers (STARTER / BROKEN VERSION)
// ============================================================

// ---------------------------------------------------------------
// TODO #5 — FLASH MESSAGES
//
// The flash() function below stores a message in the session.
// BUT get_flash() is missing entirely!
//
// YOUR TASK: Implement get_flash() below.
// It must:
//   1. Return null if there is no flash in $_SESSION
//   2. Save the flash data to a local variable
//   3. DELETE it from $_SESSION (so it only shows once!)
//   4. Return the saved data
//
// THEORY QUESTION: Why must get_flash() delete the message
// from the session immediately after reading it? What would
// happen if it didn't?
//
// YOUR ANSWER: _______________________________________________
// ---------------------------------------------------------------

function flash(string $message, string $type = 'success'): void {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash() : ?array {
    if(!isset($_SESSION['flash'])){
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}