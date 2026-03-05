<?php

// ============================================================
//  FOREVER HOME — Adoption Request Controller
//  STATUS: Several things broken or missing throughout.
// ============================================================

// ---------------------------------------------------------------
//  User submits an adoption request
// ---------------------------------------------------------------
function request_adoption(): void {
    // TODO #7 — This entire function is missing a login check.
    // A user who is not logged in should be redirected to the
    // login page with an error flash before anything else runs.
    // Add it as the very first thing in this function.
    if(!User::isLoggedIn()){
        flash('Please login with your account to proceed.', 'error');
        header("Location: index.php?action=login");
        exit;
    }
    $animalId = (int) ($_GET['id'] ?? 0);
    $animal = Animal::findById($animalId);
    if (!$animal) {
        flash('Animal not found.', 'error');
        header('Location: index.php');
        exit;
    }
    if ($animal['status'] !== 'available') {
        flash('This animal is no longer available for adoption.', 'error');
        header('Location: index.php');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = trim($_POST['message'] ?? '');
        $userId  = $_SESSION['user_id'];
        if (AdoptionRequest::existsForUser($userId, $animalId)) {
            flash('You have already submitted a request for this animal.', 'error');
            header('Location: index.php');
            exit;
        }
        AdoptionRequest::create(db(), $userId, $animalId, $message);
        flash('Request has been submitted!', 'success');
        header('Location: index.php?action=profile');
        exit;
    }
    require __DIR__ . '/../views/adopt_form.php';
}

// ---------------------------------------------------------------
//  Admin: view all pending requests
// ---------------------------------------------------------------
function admin_requests(): void {
    require_admin();
    $requests = AdoptionRequest::allWithDetails();
    require __DIR__ . '/../views/admin/requests.php';
}

// ---------------------------------------------------------------
//  Admin: approve or reject a request
// ---------------------------------------------------------------
function admin_review_request(): void {
    require_admin();
    $id = (int) ($_GET['id'] ?? 0);
    $request = AdoptionRequest::findById($id);

    if (!$request) {
        flash('Request not found.', 'error');
        header('Location: index.php?action=admin_requests');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'] ?? '';

        if (!in_array($status, ['approved', 'rejected'])) {
            flash('Invalid status.', 'error');
            header('Location: index.php?action=admin_requests');
            exit;
        }

        // TODO #9 — This call is broken in two ways:
        //   1. The method signature now requires DI — fix the call
        //   2. When approved, the animal status must also update
        //      atomically. The method uses a transaction internally
        //      but only if you pass the connection in.
        //      Make sure db() is passed here.
        AdoptionRequest::updateStatus(db(), $id, $status);

        // TODO #10 — Add an appropriate flash message here
        // that tells the admin what just happened (approved or rejected).
        // Hint: use the $status variable in your message.
        header('Location: index.php?action=admin_requests');
        exit;
    }

    require __DIR__ . '/../views/admin/review_request.php';
}
