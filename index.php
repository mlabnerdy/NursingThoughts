<?php
session_start();
include("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Nursing Thoughts</title>
  <link rel="stylesheet" href="index.css" />
</head>
<body>
  <video autoplay muted loop id="bgVideo">
    <source src="IMAGE/for bg.mp4" type="video/mp4">
  </video>

  <div class="login-container">
    <h1>WELCOME TO NURSING THOUGHTS</h1>
    <div class="login-box">
      <h2>LOGIN</h2>
      <form method="POST">
        <input type="email" name="email" placeholder="email" required>
        <input type="password" name="password" placeholder="password" required>
        <button type="submit">LOGIN</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <a href="#">Forgot Password?</a>
        <p>For new user click here to register <a href="signup.php">SIGN UP</a></p>
      </form>
    </div>
  </div>

  <script>
    console.log("Login page loaded");
</script>

</body>
</html>
