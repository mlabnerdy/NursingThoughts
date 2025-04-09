<?php  
// signup.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup</title>
  <link rel="stylesheet" href="signup.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <!-- Background Video -->
  <video autoplay muted loop id="bg-video">
    <source src="IMAGE/for bg.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>

  <!-- Scrollable Signup Container -->
  <div class="form-outer">
    <div class="form-container">
      <form action="process_signup.php" method="POST" onsubmit="return validateForm();">
        <h2>WELCOME!</h2>

        <label>Full Name <span>*</span></label>
        <input type="text" name="fullname" id="fullname" required>

        <label>Email <span>*</span></label>
        <input type="email" name="email" id="email" required>

        <label>School ID <span>*</span></label>
        <input type="text" name="school_id" id="school_id" required>

        <label>Year Level <span>*</span></label>
        <select name="year_level" id="year_level" required>
          <option value="">-- Select Year Level --</option>
          <option value="1st year">1st year</option>
          <option value="2nd year">2nd year</option>
          <option value="3rd year">3rd year</option>
          <option value="4th year">4th year</option>
        </select>

        <label>Password <span>*</span></label>
        <input type="password" name="password" id="password" required>

        <label>Confirm Password <span>*</span></label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">SIGN UP</button>

        <p class="login-link">Already have an account? <a href="login.php">Log in here</a></p>
      </form>
    </div>
  </div>

  <script src="signup.js"></script>
</body>
</html>
