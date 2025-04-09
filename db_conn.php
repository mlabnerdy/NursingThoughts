<?php
$host = 'localhost';
$dbname = 'nursingthoughts';
$username = 'root';
$password = ''; // your actual password

try {
     // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());  // Handle connection errors
}
?>
