<?php
session_start();

// Include the database connection
include('db_conn.php'); // Ensure this file has your PDO database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL query to find the user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Check if a user with this email exists
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password with the stored hash in the database
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['fullName'];
            $_SESSION['email'] = $user['email'];
            
            // Redirect to the home/dashboard page
            header("Location: Homepage.php"); // Change this to your desired page
            exit();
        } else {
            // Invalid password
            $_SESSION['error_message'] = "Incorrect password. Please try again.";
            header("Location: login.php"); // Redirect back to the login page
            exit();
        }
    } else {
        // No user found with this email
        $_SESSION['error_message'] = "No account found with this email.";
        header("Location: login.php"); // Redirect back to the login page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Nursing Thoughts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../IMAGE/nurse.png">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="login.css"> <!-- Ensure the CSS file exists and matches the filename -->
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop id="bgVideo">
  <source src="IMAGE/For bg.mp4" type="video/mp4">
  Your browser does not support HTML5 video.
</video>

<!-- Login Form Container -->
<div class="login-container">
  <form class="login-box shadow-lg rounded" method="POST" action="login.php"> <!-- Action is now pointing to login.php -->
    <h2 class="text-center fw-bold">LOGIN</h2>

    <?php
    // Display error message if there is any
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Clear the error message after displaying it
    }
    ?>

    <div class="form-group mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>

    <div class="form-group mb-3 position-relative">
      <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
      <span toggle="#password" class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y pe-3" id="togglePassword"></span>
    </div>

    <button type="submit" class="btn login-btn w-100">LOGIN</button>

    <div class="mt-2">
      <a href="fpass.php" class="text-decoration-none text-warning small">Forgot Password?</a>
    </div>

    <div class="mt-3 text-center">
      <span class="small">For new users, click here to register</span>
      <a href="signup.php" class="text-decoration-none fw-bold text-warning"> SIGN UP</a>
    </div>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // JavaScript to toggle password visibility
  const togglePassword = document.getElementById('togglePassword');
  const passwordField = document.getElementById('password');
  
  togglePassword.addEventListener('click', function () {
    // Toggle the type of password field
    const type = passwordField.type === 'password' ? 'text' : 'password';
    passwordField.type = type;
    
    // Toggle the eye icon
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
  });
</script>

</body>
</html>
