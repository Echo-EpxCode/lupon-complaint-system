<?php
    include 'config/database.php';

    if (isset($_POST['submit'])) {
        $role_id = $_POST['role'];
        
        // Combine names into username
        $username = trim($_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name']);
        $username = preg_replace('/\s+/', ' ', $username); // Remove extra spaces
        
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        // Check if email exists
        $check = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        $checkResult = mysqli_stmt_get_result($check);
        
        if (mysqli_num_rows($checkResult) > 0) {
            $error_msg = "Email already exists! Please use a different email.";
        } else {
            // Hash password
            $hashed = password_hash($password, PASSWORD_DEFAULT);
    
            // Insert user with Pending status
            $sql = "INSERT INTO users (username, email, password, role_id, status) VALUES (?, ?, ?, ?, 'Pending')";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $hashed, $role_id);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_msg = "Registration successful! Please wait for admin approval.";
            } else {
                $error_msg = "Error: " . mysqli_error($conn);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Complaint Management System</title>
    <!-- Bootstrap CSS for responsive layout and styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for visual elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body style="background: linear-gradient(135deg, #1e3c00 0%, #2d5a27 25%, #3d7a3d 50%, #2d5a27 75%, #1e3c00 100%); min-height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
        <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%; background: rgba(255, 255, 255, 0.95); border-radius: 15px;">
            
            <!-- Header -->
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill" style="font-size: 3rem; color: #198754;"></i>
                <h3 class="mt-3 fw-bold text-dark">Create Account</h3>
                <p class="text-muted small">Barangay Lupon Complaint System</p>
            </div>

            <!-- Success Alert -->
            <?php if (!empty($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div><?php echo htmlspecialchars($success_msg); ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Error Alert -->
            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div><?php echo htmlspecialchars($error_msg); ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form method="POST" action="" id="registerForm">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person-badge me-1 text-success"></i> Register as:
                    </label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" selected disabled>Choose a role</option>
                        <option value="2">Lupon Member</option>
                        <option value="3">Resident</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person me-1 text-success"></i> First Name
                    </label>
                    <input type="text" class="form-control" name="first_name" placeholder="Enter first name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person me-1 text-success"></i> Middle Name
                    </label>
                    <input type="text" class="form-control" name="middle_name" placeholder="Enter middle name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person me-1 text-success"></i> Last Name
                    </label>
                    <input type="text" class="form-control" name="last_name" placeholder="Enter last name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-envelope me-1 text-success"></i> Email Address
                    </label>
                    <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-lock me-1 text-success"></i> Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-lock-fill me-1 text-success"></i> Confirm Password
                    </label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm your password" required>
                </div>

                <!-- Password Error Alert (Hidden by default) -->
                <div id="passwordError" class="alert alert-danger d-none d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>Passwords do not match!</div>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold py-2" name="submit" 
                        style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border: none;">
                    <i class="bi bi-person-plus me-2"></i> Register
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <p class="text-muted mb-0">Already have an account?</p>
                <a href="index.php" class="text-success fw-semibold text-decoration-none">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login here
                </a>
            </div>
        </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Password Match Validation with Bootstrap Alert -->
        <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorAlert = document.getElementById('passwordError');
            
            if (password !== confirmPassword) {
                e.preventDefault();
                errorAlert.classList.remove('d-none');
                // Hide error after 3 seconds
                setTimeout(() => {
                    errorAlert.classList.add('d-none');
                }, 3000);
            }
        });
        </script>
</body>
</html>