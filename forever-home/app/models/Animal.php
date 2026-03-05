<?php

// ============================================================
//  FOREVER HOME — Animal Model (UPDATED)
//  STATUS: Two new methods added below. Both are broken.
// ============================================================

class Animal {

    public static function all(): array {
        $db = db();
        return $db->query('SELECT * FROM animals ORDER BY id DESC')->fetchAll();
    }

    public static function findById(int $id): ?array {
        $db   = db();
        $stmt = $db->prepare('SELECT * FROM animals WHERE id = ?');
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(PDO $db, string $name, string $species, int $age, string $description = ''): void {
        $stmt = $db->prepare(
            'INSERT INTO animals (name, species, age, description, status) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$name, $species, $age, $description ?: null, 'available']);
    }

    public static function update(PDO $db, int $id, string $name, string $species, int $age, string $description = ''): void {
        $stmt = $db->prepare(
            'UPDATE animals SET name=?, species=?, age=?, description=? WHERE id=?'
        );
        $stmt->execute([$name, $species, $age, $description ?: null, $id]);
    }

    public static function delete(PDO $db, int $id): void {
        $stmt = $db->prepare('DELETE FROM animals WHERE id = ?');
        $stmt->execute([$id]);
    }

    // ----------------------------------------------------------
    // TODO #5 — search() is a read method but it is broken.
    // It needs to filter by species and/or status when provided,
    // but right now it ignores both parameters entirely.
    // Fix the SQL so it actually filters.
    //
    // IMPORTANT: The parameters are optional. If both are empty
    // it should return all animals. Use dynamic query building:
    // build a $conditions array, then only add a WHERE clause
    // if there is something to filter on.
    // ----------------------------------------------------------
    public static function search(string $species = '', string $status = ''): array {
        $db = db();
        $stmt = $db->prepare('SELECT * FROM animals WHERE species LIKE ? AND status LIKE ? ORDER BY id DESC');
        $stmt->execute(["%{$species}%", "%{$status}%"]);
        return $stmt->fetchAll();
    }

    // ----------------------------------------------------------
    // TODO #6 — The SQL in this method is wrong.
    // It should only return animals with status = 'available'
    // but it currently returns all animals. Fix the query.
    // ----------------------------------------------------------
    public static function allAvailable(): array {
        $db = db();
        $stmt = $db->prepare('SELECT * FROM animals WHERE status = ? ORDER BY id DESC');
        $stmt->execute(['available']);
        return $stmt->fetchAll();
    }
}
