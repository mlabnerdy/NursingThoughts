<?php

$servername = 'srv1786.hstgr.io';
$dbname = 'u572625467_thoughts';
$username = 'u572625467_thoughts';
$password = ':5kkw#nI'; // your actual password

try {
     // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());  // Handle connection errors
}
?>
