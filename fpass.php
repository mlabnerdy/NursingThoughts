<?php
session_start();
include('db_conn.php');

// Set default timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Always set a default message to prevent timing attacks
    $message = "Reset link sent. Check your inbox or spam folder.";

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Please enter a valid email address.";
        header("Location: fpass.php");
        exit();
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate secure token and expiry (set expiry to 15 minutes)
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime('+15 minutes')); // Token expires in 15 minutes

        // Update DB with token and expiry
        $update = $pdo->prepare("UPDATE users SET reset_token = :token, token_expiry = :expiry WHERE email = :email");
        $update->execute([
            ':token' => $token,
            ':expiry' => $expiry,
            ':email' => $email
        ]);

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'nursingthoughtfsy@gmail.com'; // Your Gmail address
            $mail->Password = 'ryac rnob orsv eoun'; // Your App Password (if 2FA enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = 587;  // Port for TLS

            $mail->setFrom('your@email.com', 'Nursing Thoughts');
            $mail->addAddress($email);

            // This link should go to resetpass.php instead of fpass.php
            $resetLink = "http://localhost/NursingThoughts/resetpass.php?token=" . urlencode($token);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = "Hello,<br><br>Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a><br><br>This link will expire in 15 minutes.";

            $mail->send();

            $_SESSION['success_message'] = "Reset link sent. Check your inbox or spam folder.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Could not send reset email. Error: " . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['error_message'] = "No account found with that email.";
    }

    header("Location: fpass.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Nursing Thoughts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="login.css">
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop id="bgVideo">
<source src="IMAGE/For bg.mp4" type="video/mp4">
Your browser does not support HTML5 video.
</video>

<!-- Forgot Password Form -->
<div class="login-container">
<form class="login-box shadow-lg rounded" method="POST" action="fpass.php">
    <h2 class="text-center fw-bold">FORGOT PASSWORD</h2>

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

    <div class="form-group mb-3">
    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
    </div>

    <button type="submit" class="btn login-btn w-100">Send Reset Link</button>

    <div class="mt-3 text-center">
    <a href="login.php" class="text-decoration-none text-warning small">Back to Login</a>
    </div>
</form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
