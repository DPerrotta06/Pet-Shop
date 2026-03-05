<?php

// ============================================================
//  FOREVER HOME — AdoptionRequest Model
//  STATUS: Broken. Multiple things to fix.
//
//  This model handles adoption requests submitted by users.
//  Each request links a user to an animal with a status:
//  'pending', 'approved', or 'rejected'.
// ============================================================

class AdoptionRequest {

    public function __construct(
        public readonly ?int   $id,
        public readonly int    $userId,
        public readonly int    $animalId,
        public readonly string $status,
        public readonly string $message,
    ) {}

    // ----------------------------------------------------------
    // TODO #1 — These read methods call db() internally.
    // Are they fine as-is or do they need DI? Write a comment
    // justifying your answer before moving on.
    // They are fine as is since they are just reading from the database meaning this is a staeless operation and makes no difference if they were internally called or passed as arguments
    // ----------------------------------------------------------

    public static function allWithDetails(): array {
        $db = db();
        return $db->query('
            SELECT ar.*, u.email, a.name AS animal_name
            FROM adoption_requests ar
            JOIN users u ON ar.user_id = u.id
            JOIN animals a ON ar.animal_id = a.id
            ORDER BY ar.id DESC
        ')->fetchAll();
    }

    public static function findByUser(int $userId): array {
        $db = db();
        $stmt = $db->prepare('
            SELECT ar.*, a.name AS animal_name, a.species
            FROM adoption_requests ar
            JOIN animals a ON ar.animal_id = a.id
            WHERE ar.user_id = ?
            ORDER BY ar.id DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array {
        $db = db();
        $stmt = $db->prepare('SELECT * FROM adoption_requests WHERE id = ?');
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        return $row ?: null;
    }

    // TODO #2 — existsForUser() is a read. Leave it or fix it?
    // Justify with a comment, then make sure the method is correct.
    //I say leave it since we are looking up the user in the database and then just returning true or false if they exist or not
    public static function existsForUser(int $userId, int $animalId): bool {
        $db = db();
        $stmt = $db->prepare(
            'SELECT id FROM adoption_requests WHERE user_id = ? AND animal_id = ?'
        );
        $stmt->execute([$userId, $animalId]);
        return (bool) $stmt->fetch();
    }

    // ----------------------------------------------------------
    // TODO #3 — Fix the two write methods below (Lab 5 style).
    // You know what they need.
    // ----------------------------------------------------------

    public static function create(PDO $db, int $userId, int $animalId, string $message): void {
        $stmt = $db->prepare('INSERT INTO adoption_requests (user_id, animal_id, message, status) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $animalId, $message, 'pending']);
    }

    // TODO #4 — This method updates a request status AND updates
    // the animal's status in the same operation. Right now they use
    // separate internal db() calls. This is dangerous — if the second
    // query fails, the first already ran with no way to undo it.
    //
    // Fix this method to:
    //   a) Accept PDO $db as first parameter
    //   b) Wrap both queries in a transaction
    //
    // THEORY: Why is a transaction necessary here specifically?
    // What real-world problem does it prevent?
    public static function updateStatus(PDO $db, int $requestId, string $status): void {
        try{
            $stmt = $db->prepare('UPDATE adoption_requests SET status = ? WHERE id = ?');
            $stmt->execute([$status, $requestId]);
            if ($status === 'approved') {
                $request = self::findById($requestId);
                $stmt = $db->prepare('UPDATE animals SET status = ? WHERE id = ?');
                $stmt->execute(['adopted', $request['animal_id']]);
            }
            $db->commit();
        }catch(Exception $e){
            $db->rollBack();
            throw $e;
        }
    }
}
