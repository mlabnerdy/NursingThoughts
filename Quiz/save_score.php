<?php
// save_score.php

// Enable CORS if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Get the posted JSON data
$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['user_id'];
$subjectId = $data['subject_id'];
$score = $data['score'];

// Database connection
$host = 'localhost';
$dbname = 'nursingthoughts';
$username = 'root';
$password = ''; // your actual password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Insert into the scores table
$stmt = $conn->prepare("INSERT INTO scores (user_id, subject_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $userId, $subjectId, $score);

if ($stmt->execute()) {
  echo json_encode(["success" => true, "message" => "Score saved"]);
} else {
  echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
