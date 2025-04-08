<?php
session_start();
// Include database connection if needed here
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Nursing Thoughts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="login.css"> <!-- make sure the filename matches your actual CSS file -->
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop id="bgVideo">
  <source src="IMAGE/For bg.mp4" type="video/mp4">
  Your browser does not support HTML5 video.
</video>

<!-- Login Form Container -->
<div class="login-container">
  <form class="login-box shadow-lg rounded" method="POST" action="login_process.php">
    <h2 class="text-center fw-bold">LOGIN</h2>

    <div class="form-group mb-3">
      <input type="email" name="email" class="form-control" placeholder="email" required>
    </div>

    <div class="form-group mb-3">
      <input type="password" name="password" class="form-control" placeholder="password" required>
    </div>

    <button type="submit" class="btn login-btn w-100">LOGIN</button>

    <div class="mt-2">
      <a href="#" class="text-decoration-none text-warning small">Forgot Password?</a>
    </div>

    <div class="mt-3 text-center">
      <span class="small">For new user click here to register</span>
      <a href="signup.php" class="text-decoration-none fw-bold text-warning"> SIGN UP</a>
    </div>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
