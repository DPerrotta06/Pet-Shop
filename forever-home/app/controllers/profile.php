<?php

// ============================================================
//  FOREVER HOME — Profile Controller
//  STATUS: Broken in two places.
// ============================================================

function user_profile(): void {

    // TODO #11 — Same problem as request_adoption().
    // Add a login check at the top. Redirect with an error flash
    // if the user is not logged in.
    if(!User::isLoggedIn()){
        flash('Please login with your account to proceed.', 'error');
        header("Location: index.php?action=login");
        exit;
    }
    $userId = $_SESSION['user_id'];
    // TODO #12 — findById() is a read method on User.
    // It calls db() internally. Is that correct or does it need DI?
    // Write a comment justifying your answer, then make sure
    // the call below is correct.
    $user     = User::findById($userId);
    $requests = AdoptionRequest::findByUser($userId);

    require __DIR__ . '/../views/profile.php';
}

function search_animals(): void {
    // TODO #13 — This controller function reads $_GET parameters
    // for 'species' and 'status' and should pass them into
    // Animal::search(). Right now it ignores them entirely.
    // Fix it so the search actually works.
    $species = $_GET['species'] ?? '';
    $status  = $_GET['status'] ?? '';
    $animals = Animal::search($species, $status);
    require __DIR__ . '/../views/search.php';
}
