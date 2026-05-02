# Student Management System

A PHP/MySQL web app with login, student CRUD, search, pagination, and a stats dashboard.

## File Map

| File | Purpose |
|------|---------|
| `config.php` | DB connection + helper functions |
| `index.php` | Redirect to dashboard or login |
| `login.php` | Login page |
| `logout.php` | Session destroy + redirect |
| `dashboard.php` | Stats overview + top students |
| `students.php` | Student list with search & pagination |
| `add_student.php` | Add new student form |
| `register.php` | Create system users (admin only) |
| `includes/navbar.php` | Top navigation bar |
| `includes/sidebar.php` | Left sidebar menu |
| `assets/css/dashboard.css` | Main theme (professional) |
| `assets/css/style.css` | Alternate/login theme |
| `database.sql` | DB schema + default admin |
| `uploads/` | Student photo uploads (auto-created) |

## Setup — Localhost (XAMPP/WAMP)

1. Copy this folder into `htdocs/` (XAMPP) or `www/` (WAMP).
2. Open **phpMyAdmin** → import `database.sql`.
3. Open `config.php` — the defaults (`localhost`, `root`, `student_system`) already match XAMPP.
4. Visit `http://localhost/student_system/`
5. Login: **admin** / **password123**

## Setup — InfinityFree (or any shared host)

1. Upload all files via FileZilla to `htdocs/`.
2. Create a MySQL database in your hosting control panel.
3. Import `database.sql` via phpMyAdmin.
4. Edit `config.php` — replace these lines with your panel credentials:
   ```php
   $host     = 'sqlXXX.infinityfree.com';
   $dbname   = 'if0_XXXXXXX';
   $username = 'if0_XXXXXXX';
   $password = 'your_db_password';
   ```
5. Make sure the `uploads/` folder has write permissions (chmod 755).

## Default Login

| Username | Password |
|----------|----------|
| admin | password123 |

> Change this immediately after first login via **Admin → Add User**.
