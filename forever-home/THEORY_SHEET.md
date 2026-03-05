# 🐾 Forever Home — Extension Theory Sheet

These questions go beyond definitions. You need to reason through
scenarios, spot mistakes, and write actual code from memory.

---

## Section 1 — Dependency Injection & Transactions

**Q1.** Look at this broken version of `updateStatus()`:

```php
public static function updateStatus(int $requestId, string $status): void {
    $db   = db();
    $stmt = $db->prepare('UPDATE adoption_requests SET status = ? WHERE id = ?');
    $stmt->execute([$status, $requestId]);

    if ($status === 'approved') {
        $request = self::findById($requestId);
        $db2     = db();
        $stmt2   = $db2->prepare('UPDATE animals SET status = ? WHERE id = ?');
        $stmt2->execute(['adopted', $request['animal_id']]);
    }
}
```

a) Even though `db()` is a Singleton and `$db` and `$db2` are the same object,
why is this code still wrong from a design perspective?
    - The db() function follows a singleton pattern meaning there will always just just be one active instance of the class so making 2 separate instances in useless and it's better just to have PDO argument in the function because updating is a stateful operation which means the view and the database need to see the constant updates happening.

b) The real fix requires a transaction. Write the corrected version of this method
with the correct signature, a transaction, and proper error handling using try/catch.
    - 

---

**Q2.** A teammate writes this controller code:

```php
Animal::create($name, $species, $age, $description);
AdoptionRequest::create($animalId, $userId, $message);
```

Both methods internally call `db()`. Your teammate says:
*"It's fine, they both use the Singleton so they share the same connection."*

Why are they wrong? What specific scenario would cause silent data corruption?

---

## Section 2 — Flash Messages

**Q3.** Trace through this exact sequence and describe what the user sees on screen
at each step. Be specific about session state at each point.

```
Step 1: Admin submits POST to approve a request
Step 2: Controller calls flash('Request approved!', 'success')
Step 3: Controller calls header('Location: index.php?action=admin_requests')
Step 4: Browser follows redirect, GET request hits the server
Step 5: header.php runs, calls get_flash()
Step 6: User loads ANY other page after that
```

---

**Q4.** Someone writes `get_flash()` like this:

```php
function get_flash(): ?array {
    return $_SESSION['flash'] ?? null;
}
```

What is wrong with it? Describe the exact bug and what the user would experience.

---

## Section 3 — Inheritance

**Q5.** Here is a broken `AdminUser` constructor:

```php
class AdminUser extends User {
    public function __construct(
        public readonly ?int $id,
        public readonly string $email,
        public readonly string $passwordHash,
        public bool $isAdminFlag
    ) {
        parent::__construct();
    }
}
```

a) What error does PHP throw at runtime when this constructor is called?
b) Write the corrected constructor.
c) Why does AdminUser need to re-declare `$id`, `$email`, and `$passwordHash`
   as constructor properties if User already has them?

---

**Q6.** Without inheritance, imagine you have `User` and `AdminUser` as two
completely separate classes. A security audit finds a bug in `verifyPassword()` —
it needs to be updated. What is the maintenance problem, and how does inheritance
solve it?

---

## Section 4 — Search & Dynamic Queries

**Q7.** Here is the broken `search()` method:

```php
public static function search(string $species = '', string $status = ''): array {
    $db = db();
    return $db->query('SELECT * FROM animals ORDER BY id DESC')->fetchAll();
}
```

Write the correct version. It must:
- Return all animals when both parameters are empty
- Filter by species only when species is provided
- Filter by status only when status is provided
- Filter by both when both are provided
- Use prepared statements (not string interpolation) to avoid SQL injection

---

## Section 5 — Sessions & Security

**Q8.** A user logs in and you store their info in `$_SESSION`:

```php
$_SESSION['user_id'] = $user->id;
$_SESSION['is_admin'] = $user->isAdmin();
```

Later in `require_admin()` you check `$_SESSION['is_admin']` directly.

a) Name two ways this could be exploited by a malicious user.
b) What is the correct approach and why does it prevent both attacks?

---

**Q9.** Explain what `session_start()` does step by step at the server level.
Why must it be called before ANY output is sent to the browser?
What happens if you forget it on a page that tries to read `$_SESSION`?

---

**Q10.** A logged-in user navigates directly to:
`index.php?action=adopt&id=3`
without going through the homepage first.

In the broken version of `request_adoption()`, what happens?
In the fixed version, what should happen and why?

---

Good luck. 🐾
