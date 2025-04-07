<!--School ID, Yr Lvl, Full Name -->
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
</head>
<body>

  <!-- Background Video -->
  <video autoplay muted loop id="bg-video">
    <source src="IMAGE/for bg.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>

  <!-- Signup Form Container -->
  <div class="form-container">
    <form action="process_signup.php" method="POST" onsubmit="return validateForm();">
      <h2>WELCOME!</h2>
      
      <label>Full Name <span>*</span></label>
      <input type="text" name="fullname" id="fullname" required>

      <label>Email <span>*</span></label>
      <input type="email" name="email" id="email" required>

      <label>Password <span>*</span></label>
      <input type="password" name="password" id="password" required>

      <label>Confirm password <span>*</span></label>
      <input type="password" name="confirm_password" id="confirm_password" required>

      <button type="submit">SIGN UP</button>
    </form>
  </div>

  <script src="signup.js"></script>
</body>
</html>
