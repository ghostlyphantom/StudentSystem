<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-white shadow-sm" style="backdrop-filter: blur(20px);">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold fs-4" href="dashboard.php">
            <i class="fas fa-graduation-cap text-primary me-2"></i>
            StudentPro
        </a>
        
        <button class="navbar-toggler sidebar-toggle d-lg-none" type="button">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="navbar-nav ms-auto align-items-center">
            <span class="navbar-text me-3 text-muted small">
                <i class="fas fa-circle text-success small me-1"></i>
                Online
            </span>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="assets/images/avatar.jpg" class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                    <span class="d-none d-md-inline"><?php echo ucfirst($_SESSION['username']); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <span class="dropdown-item-text px-3 py-2 border-bottom">
                            <i class="fas fa-user me-2 text-primary"></i>
                            <?php echo ucfirst($_SESSION['role']); ?> Account
                        </span>
                    </li>
                    <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>