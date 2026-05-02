<?php 
require_once 'config.php'; 
requireLogin();

if ($_POST) {
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $photo = time() . '_' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $targetDir . $photo);
    }
    
    $stmt = $pdo->prepare("INSERT INTO students (first_name, middle_name, last_name, birthday, address, gender, course, gwa, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'],
        $_POST['birthday'], $_POST['address'], $_POST['gender'],
        $_POST['course'], $_POST['gwa'], $photo
    ]);
    header('Location: students.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        
        <main class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Add New Student</h2>
                <a href="students.php" class="btn btn-secondary">Back to Students</a>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">First Name *</label>
                                        <input type="text" class="form-control" name="first_name" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" name="last_name" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Birthday</label>
                                        <input type="date" class="form-control" name="birthday">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gender *</label>
                                        <select class="form-select" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="2"></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Course</label>
                                        <input type="text" class="form-control" name="course">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">GWA (0.00-5.00)</label>
                                        <input type="number" step="0.01" min="0" max="5" class="form-control" name="gwa">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Photo</label>
                                    <input type="file" class="form-control" name="photo" accept="image/*">
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">Save Student</button>
                                    <a href="students.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>