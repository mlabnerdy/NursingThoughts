<?php
session_start();
require 'db_conn.php'; // ✅ Connect to DB using your existing file

// ✅ Get POST data
$fullname   = trim($_POST['fullname']);
$email      = trim($_POST['email']);
$schoolID   = trim($_POST['school_id']);
$yearLevel  = trim($_POST['year_level']);
$password   = $_POST['password'];
$confirm    = $_POST['confirm_password'];

// ✅ Check if passwords match
if ($password !== $confirm) {
    $_SESSION['error'] = "Passwords do not match!";
    header("Location: signup.php");
    exit();
}

// ✅ Check if email already exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    $_SESSION['error'] = "Email is already registered!";
    header("Location: signup.php");
    exit();
}

// ✅ Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// ✅ Insert the user
try {
    $stmt = $pdo->prepare("INSERT INTO users (schoolID, fullName, YrLvl, email, password_hash)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$schoolID, $fullname, $yearLevel, $email, $hashedPassword]);

    $_SESSION['success'] = "Registration successful! You can now log in.";
    header("Location: signup.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Something went wrong: " . $e->getMessage();
    header("Location: signup.php");
    exit();
}
?>
