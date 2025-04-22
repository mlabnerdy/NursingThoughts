<?php
session_start();
include('db_conn.php');
date_default_timezone_set('Asia/Manila');

// Check if token is present from URL
$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match.";
    } else {
        // Find user with token and check expiry
        $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token LIMIT 1");
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['email']) && strtotime($user['token_expiry']) > time()) {
            // Update password (hashed), clear token
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password_hash = :password, reset_token = NULL, token_expiry = NULL WHERE email = :email");
            $update->execute([
                ':password' => $hashedPassword,
                ':email' => $user['email']
            ]);

            // Use JS to alert and redirect
            echo "<script>
                alert('Password successfully updated!');
                window.location.href = 'login.php';
            </script>";
            exit();
        } else {
            $_SESSION['error_message'] = "This reset link is invalid or expired.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Nursing Thoughts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="login.css">
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop id="bgVideo">
    <source src="IMAGE/For bg.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
</video>

<!-- Reset Password Form -->
<div class="login-container">
    <form class="login-box shadow-lg rounded" method="POST" action="resetpass.php">
        <h2 class="text-center fw-bold">RESET PASSWORD</h2>

        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }

        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>

        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <div class="form-group mb-3 position-relative">
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password" required>
            <i class="bi bi-eye-slash position-absolute" style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword('password', this)"></i>
        </div>

        <div class="form-group mb-3 position-relative">
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
            <i class="bi bi-eye-slash position-absolute" style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword('confirm_password', this)"></i>
        </div>

        <button type="submit" class="btn login-btn w-100">Reset Password</button>

        <div class="mt-3 text-center">
            <a href="login.php" class="text-decoration-none text-warning small">Back to Login</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Show/Hide Password Script -->
<script>
    function togglePassword(fieldId, icon) {
        const input = document.getElementById(fieldId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = "password";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
</body>
</html>
