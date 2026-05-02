<?php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    
    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            $redirect = $_GET['redirect'] ?? 'dashboard.php';
            header("Location: $redirect");
            exit();
        }
    }
    $error = 'Invalid credentials!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
</head>
<body class="login-bg">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-4 col-lg-5 col-md-7">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white text-center py-4">
                        <div class="logo-container mb-3">
                            <i class="fas fa-graduation-cap fa-3x"></i>
                        </div>
                        <h3 class="mb-1 fw-bold">Student Management</h3>
                        <p class="mb-0 opacity-75">Sign in to your account</p>
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" novalidate>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Username</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg" 
                                           name="username" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg" 
                                           name="password" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold shadow-sm">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        <div class="text-center">
                            <small class="text-muted">
                                Default: <strong>admin</strong> / <strong>password123</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>