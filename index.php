<?php
    session_start();

    include 'config/database.php';

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $sql = "SELECT `user_id`, `username`, `email`, `password`, `role_id`, `status` FROM `users` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            // Check if account is Accepted
            if ($row['status'] !== 'Accepted') {
                $error_msg = "Your account is pending approval. Please wait for admin to accept your registration.";
            }
            // Verify password
            elseif (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role_id'] = $row['role_id'];
                
                // Redirect based on role
                switch ($_SESSION['role_id']) {
                    case 1:
                        header('Location: admin/dashboard.php');
                        break;
                    case 2:
                        header('Location: lupon/dashboard.php');
                        break;
                    case 3:
                        header('Location: resident/dashboard.php');
                        break;
                    default:
                        header('Location: index.php');
                }
                exit;
            } else {
                $error_msg = "Invalid password!";
            }
        } else {
            $error_msg = "Email not found!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Complaint Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body style="background: linear-gradient(135deg, #1e3c00 0%, #2d5a27 25%, #3d7a3d 50%, #2d5a27 75%, #1e3c00 100%); min-height: 100vh;">
<!-- Center Form on Page -->
<!-- Center Form on Page -->
<div class="d-flex justify-content-center align-items-center min-vh-100 py-4">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; background: rgba(255, 255, 255, 0.95); border-radius: 15px;">
        
        <!-- Header with Icon -->
        <div class="text-center mb-4">
            <i class="bi bi-shield-check" style="font-size: 3rem; color: #198754;"></i>
            <h3 class="mt-3 fw-bold text-dark">Complaint System</h3>
            <p class="text-muted small">Barangay Lupon</p>
        </div>

        <!-- Bootstrap Dismissible Alert -->
        <?php if(!empty($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?php echo htmlspecialchars($error_msg); ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                    <i class="bi bi-envelope me-1 text-success"></i> Email Address
                </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    <i class="bi bi-lock me-1 text-success"></i> Password
                </label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold py-2" name="login" 
                    style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border: none;">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>
        </form>

        <!-- Register Link -->
        <div class="text-center mt-4">
            <p class="text-muted mb-0">Don't have an account?</p>
            <a href="registration.php" class="text-success fw-semibold text-decoration-none">
                <i class="bi bi-person-plus me-1"></i> Register here
            </a>
        </div>
    </div>
    
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>