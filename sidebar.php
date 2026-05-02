<div class="sidebar d-flex flex-column p-3">
    <div class="sidebar-brand mb-4 pb-3 border-bottom">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="fas fa-chart-line me-2"></i>
            Menu
        </h5>
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
            <i class="fas fa-tachometer-alt me-3"></i>
            <span>Dashboard</span>
        </a>
        
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='students.php' ? 'active' : ''; ?>" href="students.php">
            <i class="fas fa-users me-3"></i>
            <span>Students</span>
            <span class="badge bg-primary rounded-pill ms-auto"><?php echo getStudentStats($pdo)['total']; ?></span>
        </a>
        
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='top_students.php' ? 'active' : ''; ?>" href="top_students.php">
            <i class="fas fa-trophy me-3"></i>
            <span>Top Students</span>
        </a>
        
        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='charts.php' ? 'active' : ''; ?>" href="charts.php">
            <i class="fas fa-chart-bar me-3"></i>
            <span>Analytics</span>
        </a>
        
        <div class="dropdown mt-3">
            <a class="nav-link dropdown-toggle text-muted" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-file-export me-3"></i>
                <span>Reports</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="print_students.php" target="_blank"><i class="fas fa-print me-2"></i>Print List</a></li>
                <li><a class="dropdown-item" href="export.php"><i class="fas fa-file-csv me-2"></i>Export CSV</a></li>
                <li><a class="dropdown-item" href="export.php?format=pdf"><i class="fas fa-file-pdf me-2"></i>Export PDF</a></li>
            </ul>
        </div>
        
        <?php if (isAdmin()): ?>
        <div class="dropdown mt-3">
            <a class="nav-link dropdown-toggle text-muted" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-3"></i>
                <span>Admin</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="register.php"><i class="fas fa-user-plus me-2"></i>Add User</a></li>
                <li><a class="dropdown-item" href="logs.php"><i class="fas fa-history me-2"></i>Activity Log</a></li>
            </ul>
        </div>
        <?php endif; ?>
    </nav>
</div>