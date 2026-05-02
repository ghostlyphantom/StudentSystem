<?php 
require_once 'config.php'; 
requireLogin(); 
$stats = getStudentStats($pdo);
$recentStudents = $pdo->query("SELECT * FROM students ORDER BY created_at DESC LIMIT 5")->fetchAll();
$topStudents = $pdo->query("SELECT first_name, last_name, gwa FROM students ORDER BY gwa DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
</head>
<body class="dashboard-body">
    <!-- Top Navigation -->
    <?php include 'includes/navbar.php'; ?>
    
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="header bg-white shadow-sm border-bottom">
                <div class="container-fluid">
                    <div class="row align-items-center py-3">
                        <div class="col">
                            <h1 class="h3 mb-0 fw-bold text-dark">
                                <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                Dashboard Overview
                            </h1>
                            <p class="mb-0 text-muted">Welcome back, <?php echo ucfirst(sanitizeInput($_SESSION['username'])); ?>!</p>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i><?php echo ucfirst($_SESSION['role']); ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="container-fluid px-4 py-4">
                <div class="row g-4 mb-5">
                    <div class="col-xl-3 col-md-6">
                        <div class="card-stat h-100 border-0 shadow-sm hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-muted mb-1">Total Students</h6>
                                        <h2 class="fw-bold text-primary mb-0"><?php echo number_format($stats['total']); ?></h2>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-primary opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6">
                        <div class="card-stat h-100 border-0 shadow-sm hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-muted mb-1">Male Students</h6>
                                        <h2 class="fw-bold text-info mb-0"><?php echo $stats['male']; ?></h2>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-male fa-2x text-info opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6">
                        <div class="card-stat h-100 border-0 shadow-sm hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-muted mb-1">Female Students</h6>
                                        <h2 class="fw-bold text-success mb-0"><?php echo $stats['female']; ?></h2>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-female fa-2x text-success opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6">
                        <div class="card-stat h-100 border-0 shadow-sm hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-muted mb-1">Avg. GWA</h6>
                                        <h2 class="fw-bold text-warning mb-0"><?php echo $stats['avg_gwa']; ?></h2>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x text-warning opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts & Recent Activity -->
                <div class="row g-4">
                    <div class="col-xl-8">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-0 pb-0">
                                <h5 class="card-title mb-0 fw-semibold">
                                    <i class="fas fa-chart-mixed me-2 text-primary"></i>
                                    Performance Overview
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <canvas id="performanceChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-0 pb-0">
                                <h6 class="card-title mb-0 fw-semibold">
                                    <i class="fas fa-trophy me-2 text-warning"></i>
                                    Top 5 Students
                                </h6>
                            </div>
                            <div class="card-body py-4">
                                <div class="list-group list-group-flush">
                                    <?php foreach ($topStudents as $i => $student): ?>
                                        <div class="list-group-item px-0 border-0 py-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="badge bg-warning rounded-pill fs-6"><?php echo $i+1; ?></span>
                                                </div>
                                                <div class="col">
                                                    <div class="fw-semibold"><?php echo sanitizeInput($student['first_name'].' '.$student['last_name']); ?></div>
                                                    <small class="text-muted">GWA: <?php echo $student['gwa']; ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>