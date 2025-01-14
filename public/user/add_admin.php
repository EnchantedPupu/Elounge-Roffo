<?php
session_start();
include_once "../../utils.php";

// Super admin check - only existing admins can create new admins
/* if ($_SESSION['user'] != 'admin') {
    header("Location: ../index.php");
    exit();
} */

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $matric = filter_input(INPUT_POST, 'matric', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $faculty = filter_input(INPUT_POST, 'faculty', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $residential = filter_input(INPUT_POST, 'residential', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);

    // Check if email already exists
    $conn = create_new_database_connection();
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = '<div class="alert alert-danger">Email already exists!</div>';
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new admin
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, matric, isadmin, gender, profile_pic, faculty, phone, residential, bio) VALUES (?, ?, ?, ?, 1, ?, 'default.jpg', ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $email, $hashed_password, $matric, $gender, $faculty, $phone, $residential, $bio);

        if ($stmt->execute()) {
            $message = '<div class="alert alert-success">Admin account created successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error creating admin account!</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Add New Admin</h3>
                </div>
                <div class="card-body">
                    <?php echo $message; ?>
                    
                    <form method="POST" action="" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="matric" class="form-label">Matric Number</label>
                                <input type="text" class="form-control" id="matric" name="matric" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Choose...</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="faculty" class="form-label">Faculty</label>
                                <input type="text" class="form-control" id="faculty" name="faculty" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="residential" class="form-label">Residential Address</label>
                                <input type="text" class="form-control" id="residential" name="residential" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Create Admin Account</button>
                            <a href="admin.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

</body>
</html>