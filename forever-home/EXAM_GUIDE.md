# 🐾 Forever Home — Lab 6 Exam Practice

## Your Mission
The codebase in this folder is a **broken "Lab 5 style"** version of a
Forever Home animal adoption center. Your job is to upgrade it to
**Lab 6 standards** by applying the four concepts below.

---

## TODO Checklist

### 1. Dependency Injection (`app/models/Animal.php`, `User.php`, controllers)

- [ ] **TODO #1** — (Theory) Comment explaining why read methods don't need DI
- [ ] **TODO #2** — Fix `Animal::create()`, `update()`, `delete()` to accept `PDO $db` as first param
- [ ] **TODO #3** — Fix `User::create()` the same way
- [ ] **TODO #7** — In `admin.php`, pass `db()` into `Animal::create()`
- [ ] **TODO #10** — Pass `db()` into `Animal::update()`
- [ ] **TODO #13** — Pass `db()` into `Animal::delete()`
- [ ] **TODO #15** — Pass `db()` into `User::create()`

### 2. Flash Messages (`app/helpers.php`, `app/views/header.php`, controllers)

- [ ] **TODO #5** — Implement `get_flash()` in `helpers.php`
- [ ] **TODO #8** — Flash "Animal created" after creating
- [ ] **TODO #9** — Flash "Animal not found" error
- [ ] **TODO #11** — Flash "Animal updated" after editing
- [ ] **TODO #12** — Flash "Animal not found" on delete page
- [ ] **TODO #14** — Flash "Animal deleted" after deleting
- [ ] **TODO #16** — Flash "Account created! Please log in." in auth
- [ ] **TODO #19** — Render flash in `header.php`

### 3. CRUD (`app/models/Animal.php`)

- [ ] All five CRUD methods exist: `all()`, `findById()`, `create()`, `update()`, `delete()`
- [ ] Write methods use DI (covered above)
- [ ] No raw SQL anywhere except inside the model

### 4. Inheritance (`app/models/AdminUser.php`, `sql/schema.sql`)

- [ ] **TODO #4a** — `AdminUser extends User`
- [ ] **TODO #4b** — Delete duplicated methods from `AdminUser`
- [ ] **TODO #4c** — Add `isAdmin()` method
- [ ] **TODO #4d** — Call `parent::__construct()` in the constructor
- [ ] **TODO #6a** — Add flash error in `require_admin()` on access denied
- [ ] **TODO #17** — Add `is_admin` column to `users` table in `schema.sql`
- [ ] **TODO #18** — Show Admin Panel link in `header.php` only for admins

---

## Theory Questions (Answer These!)

**Q1.** Why do read methods call `db()` internally while write methods receive it as a parameter?
    - They call db() directly because reading queries is a stateless operation

**Q2.** `db()` is a Singleton. If write methods called `db()` internally and it always returns
the same object anyway, why does injecting `$db` still matter for transactions?
    - because it makes sure that every time someone updates, creates, or deletes in the database in avoids sql injections and keep the database and code clean.

**Q3.** What is the three-step life cycle of a flash message? (set → ? → ?)
    - set -> get -> delete

**Q4.** Why must `get_flash()` delete the message from the session immediately after reading it?
    - So that it doesn't stay forever and get in the way

**Q5.** What does `parent::__construct()` do and why is it needed in `AdminUser`?
    - This calls the parent constructor of a child class in the child's constructor.

**Q6.** Why does `require_admin()` re-query the database instead of reading `is_admin` from `$_SESSION`?
    - Becuase it is setting the admin object to the AdmiUser object created by get_admin_user() which does the querying.

**Q7.** What does CRUD stand for, and how does putting all SQL in a model class help maintenance?
    - Create, read, update, delete. These are the 4 main operations that are executed in system that revolve around database and each model represents a table in the database.

**Q8.** What design pattern does `db()` implement, and what problem does it solve?
    - Singleton, it solves the problem of keeping code clean and secure form sql injections.
---

## File Map

```
forever-home/
├── app/
│   ├── db.php                        ← Singleton db() function
│   ├── helpers.php                   ← flash() + TODO: get_flash()
│   ├── models/
│   │   ├── Animal.php                ← CRUD model (fix DI on writes)
│   │   ├── User.php                  ← User model (fix DI on create)
│   │   └── AdminUser.php             ← TODO: extend User
│   ├── controllers/
│   │   ├── admin.php                 ← Admin CRUD actions (fix DI + flash)
│   │   └── auth.php                  ← Register/login (fix DI + flash)
│   └── views/
│       ├── header.php                ← TODO: render flash, admin link
│       └── admin/
│           ├── animals.php           ← Read: animal list table
│           ├── animal_form.php       ← Create + Update shared form
│           └── animal_delete.php     ← Delete confirmation
├── sql/
│   └── schema.sql                    ← TODO: add is_admin column
└── assets/
    └── style.css
```

Good luck on your exam! 🐾
