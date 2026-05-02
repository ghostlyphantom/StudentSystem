<?php
// ─────────────────────────────────────────────
// Student Management System - config.php
// ─────────────────────────────────────────────

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure'   => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Strict',
    ]);
}

// ── Database Configuration ───────────────────
// LOCALHOST / XAMPP defaults:
$host     = 'localhost';
$dbname   = 'student_system';
$username = 'root';
$password = '';
// For InfinityFree, replace above with your panel credentials.

define('UPLOAD_PATH', __DIR__ . '/uploads/');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2 MB

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function getStudentStats($pdo) {
    $stmt = $pdo->query("
        SELECT
            COUNT(*)                                AS total,
            SUM(gender = 'Male')                    AS male,
            SUM(gender = 'Female')                  AS female,
            ROUND(AVG(COALESCE(gwa, 0)), 2)         AS avg_gwa,
            COUNT(CASE WHEN gwa >= 1.75 THEN 1 END) AS honors
        FROM students
    ");
    return $stmt->fetch();
}

function getTopStudents($pdo, $limit = 10) {
    $stmt = $pdo->prepare("SELECT * FROM students ORDER BY gwa DESC, last_name ASC LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}
