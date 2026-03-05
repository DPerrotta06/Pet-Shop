<?php

session_start();

require __DIR__ . '/app/db.php';
require __DIR__ . '/app/helpers.php';
require __DIR__ . '/app/models/User.php';
require __DIR__ . '/app/models/AdminUser.php';
require __DIR__ . '/app/models/Animal.php';
require __DIR__ . '/app/models/AdoptionRequest.php';
require __DIR__ . '/app/controllers/auth.php';
require __DIR__ . '/app/controllers/admin.php';
require __DIR__ . '/app/controllers/requests.php';
require __DIR__ . '/app/controllers/profile.php';

$action = $_GET['action'] ?? 'home';

match($action) {
    'home' => home(),
    'register' => auth_register(),
    'login' => auth_login(),
    'logout' => auth_logout(),
    'admin_animals' => admin_animals(),
    'create_animal' => admin_create_animal(),
    'edit_animal' => admin_edit_animal(),
    'delete_animal' => admin_delete_animal(),
    'search' => search_animals(),
    'admin_requests' => admin_requests(),
    'review_request' => admin_review_request(),
    'adopt' => request_adoption(),
    default => home(),
};

function home(): void {
    $animals = Animal::all();
    require __DIR__ . '/app/views/home.php';
}
