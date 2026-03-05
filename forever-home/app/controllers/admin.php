<?php

// ============================================================
//  FOREVER HOME — Admin Controller (STARTER / BROKEN VERSION)
// ============================================================

// ---------------------------------------------------------------
// TODO #6 — ADMIN GUARD (Inheritance + DI combined)
//
// get_admin_user() should re-query the DB and return an AdminUser.
// require_admin() should use it and block non-admins.
//
// THEORY QUESTION: Why does require_admin() re-query the database
// every time instead of just reading is_admin from $_SESSION?
//
// YOUR ANSWER: _______________________________________________
// ---------------------------------------------------------------

function get_admin_user(): ?AdminUser {
    if (!isset($_SESSION['user_id'])) return null;
    $db = db();
    $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $row  = $stmt->fetch();
    if (!$row) return null;
    return new AdminUser($row['id'], $row['email'], $row['password_hash'], (bool)$row['is_admin']);
}

function require_admin(): AdminUser {
    $admin = get_admin_user();
    if (!$admin || !$admin->isAdmin()) {
        // TODO #6a: add a flash error message here before redirecting
        flash('You need to be an admin to carry through with this action!', 'error');
        header('Location: index.php?action=login');
        exit;
    }
    return $admin;
}

// ---------------------------------------------------------------
//  List all animals
// ---------------------------------------------------------------
function admin_animals(): void {
    require_admin();
    $animals = Animal::all();
    require __DIR__ . '/../views/admin/animals.php';
}

// ---------------------------------------------------------------
//  Create animal
// ---------------------------------------------------------------
function admin_create_animal(): void {
    require_admin();
    $error  = null;
    $animal = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name        = trim($_POST['name']        ?? '');
        $species     = trim($_POST['species']     ?? '');
        $age         = (int) ($_POST['age']       ?? 0);
        $description = trim($_POST['description'] ?? '');

        if ($name === '' || $species === '') {
            $error = 'Name and species are required.';
        } else {
            // TODO #7 — DI: fix this call to inject db()
            Animal::create(db(), $name, $species, $age, $description);

            // TODO #8 — FLASH: add a success flash message here
            //           then redirect to index.php?action=admin_animals
            flash('Animal added!', 'success');

            header('Location: index.php?action=admin_animals');
            exit;
        }
    }

    require __DIR__ . '/../views/admin/animal_form.php';
}

// ---------------------------------------------------------------
//  Edit animal
// ---------------------------------------------------------------
function admin_edit_animal(): void {
    require_admin();
    $error  = null;
    $id     = (int) ($_GET['id'] ?? 0);
    $animal = Animal::findById($id);

    if (!$animal) {
        // TODO #9 — FLASH: add an error flash here before redirecting
        flash('Animal not found!', 'error');
        header('Location: index.php?action=admin_animals');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name        = trim($_POST['name']        ?? '');
        $species     = trim($_POST['species']     ?? '');
        $age         = (int) ($_POST['age']       ?? 0);
        $description = trim($_POST['description'] ?? '');

        if ($name === '' || $species === '') {
            $error = 'Name and species are required.';
        } else {
            // TODO #10 — DI: fix this call to inject db()
            Animal::update(db(), $id, $name, $species, $age, $description);

            // TODO #11 — FLASH: add a success flash + redirect
            flash('Animal crendentials have been updated!', 'success');
            header('Location: index.php?action=admin_animals');
            exit;
        }
    }

    require __DIR__ . '/../views/admin/animal_form.php';
}

// ---------------------------------------------------------------
//  Delete animal
// ---------------------------------------------------------------
function admin_delete_animal(): void {
    require_admin();
    $id     = (int) ($_GET['id'] ?? 0);
    $animal = Animal::findById($id);

    if (!$animal) {
        // TODO #12 — FLASH: error + redirect
        flash('Animal not found!', 'error');
        header('Location: index.php?action=admin_animals');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // TODO #13 — DI: fix this call to inject db()
        Animal::delete(db(), $id);

        // TODO #14 — FLASH: success + redirect
        flash('Animal has been deleted!', 'success');
        header('Location: index.php?action=admin_animals');
        exit;
    }

    require __DIR__ . '/../views/admin/animal_delete.php';
}
