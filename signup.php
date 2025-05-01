<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup</title>
  <link rel="stylesheet" href="./signup.css">
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

        <!-- ✅ SESSION MESSAGE HANDLER -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="error-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="success-message"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

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

  <!-- ✅ JS VALIDATION -->
  <script>
    function validateForm() {
      const password = document.getElementById("password").value;
      const confirm = document.getElementById("confirm_password").value;

      const existingError = document.querySelector(".error-message");
      if (existingError) existingError.remove(); // remove old error if any

      if (password !== confirm) {
        const msg = document.createElement("div");
        msg.className = "error-message";
        msg.innerText = "Passwords do not match!";
        document.querySelector("form").prepend(msg);
        return false;
      }
      return true;
    }
  </script>

</body>
</html>
