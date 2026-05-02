<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Student System</a>
        <div class="navbar-nav ms-auto">
            <span class="navbar-text me-3">
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 
                (<?php echo ucfirst($_SESSION['role']); ?>)
            </span>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a class="nav-link" href="register.php">Add User</a>
            <?php endif; ?>
            <a class="nav-link" href="logout.php">Logout</a>
        </div>
    </div>
</nav>