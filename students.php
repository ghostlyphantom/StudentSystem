<?php 
require_once 'config.php'; 
requireLogin();

// Search and Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Handle CRUD operations
if ($_POST && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $stmt = $pdo->prepare("INSERT INTO students (first_name, middle_name, last_name, birthday, address, gender, course, gwa, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'],
                $_POST['birthday'], $_POST['address'], $_POST['gender'],
                $_POST['course'], $_POST['gwa'], $_POST['photo'] ?? null
            ]);
            $success = "Student added successfully!";
            break;
            
        case 'edit':
            $stmt = $pdo->prepare("UPDATE students SET first_name=?, middle_name=?, last_name=?, birthday=?, address=?, gender=?, course=?, gwa=? WHERE id=?");
            $stmt->execute([
                $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'],
                $_POST['birthday'], $_POST['address'], $_POST['gender'],
                $_POST['course'], $_POST['gwa'], $_POST['id']
            ]);
            $success = "Student updated successfully!";
            break;
            
        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $success = "Student deleted successfully!";
            break;
    }
}

// Fetch students
$where = $search ? "WHERE first_name LIKE ? OR last_name LIKE ? OR course LIKE ?" : "";
$countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM students $where");
$params = $search ? ["%$search%", "%$search%", "%$search%"] : [];
$countStmt->execute($params);
$totalStudents = $countStmt->fetch()['total'];
$totalPages = ceil($totalStudents / $limit);

$stmt = $pdo->prepare("SELECT * FROM students $where ORDER BY created_at DESC LIMIT ? OFFSET ?");
$params[] = $limit;
$params[] = $offset;
if ($search) $params = array_merge(["%$search%", "%$search%", "%$search%"], [$limit, $offset]);
else $params = [$limit, $offset];
$stmt->execute($params);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        
        <main class="flex-grow-1 p-4">
            <?php if (isset($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Students (<?php echo $totalStudents; ?>)</h2>
                <a href="add_student.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Student
                </a>
            </div>

            <!-- Search and Pagination -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" 
                                           value="<?php echo htmlspecialchars($search); ?>" placeholder="Search students...">
                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    <?php if ($search): ?>
                                        <a href="students.php" class="btn btn-outline-danger">Clear</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <?php if ($totalPages > 1): ?>
                                <nav>
                                    <ul class="pagination pagination-sm">
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Course</th>
                                    <th>GWA</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td>
                                            <?php if ($student['photo']): ?>
                                                <img src="uploads/<?php echo htmlspecialchars($student['photo']); ?>" 
                                                     class="rounded-circle" width="40" height="40" alt="Photo">
                                            <?php else: ?>
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width:40px;height:40px;">
                                                    <i class="bi bi-person text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></strong>
                                            <?php if ($student['middle_name']): ?>
                                                <br><small><?php echo htmlspecialchars($student['middle_name']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-<?php echo $student['gender']=='Male' ? 'primary' : 'pink'; ?>">
                                            <?php echo $student['gender']; ?></span></td>
                                        <td><?php echo htmlspecialchars($student['course']); ?></td>
                                        <td><strong><?php echo number_format($student['gwa'], 2); ?></strong></td>
                                        <td>
                                            <a href="view_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" style="display:inline;" 
                                                  onsubmit="return confirm('Delete this student?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>