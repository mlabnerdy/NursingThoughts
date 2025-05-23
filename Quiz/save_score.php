<?php
session_start();
require '../db_conn.php'; // Include your database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

// Get the user ID, subject ID, and score from the POST request
$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in session
$subject_id = isset($_POST['subject_id']) ? (int)$_POST['subject_id'] : 0; // Ensure subject_id is an integer
$score = isset($_POST['score']) ? (float)$_POST['score'] : 0; // Ensure score is a valid number

// Validate input
if ($subject_id <= 0 || $score <= 0) {
    header('Content-Type: application/json');
    //echo json_encode(['status' => 'error', 'message' => 'Invalid input for subject_id or score']);
    
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid input for subject_id or score',
    'debug' => [
        'user_id' => $user_id,
        'subject_id' => $subject_id,
        'score' => $score
    ]
]);
    
    exit();
}

// Check if the subject ID exists in the database
$stmt = $pdo->prepare("SELECT COUNT(*) FROM subjects WHERE subject_id = ?");
$stmt->execute([$subject_id]);
if ($stmt->fetchColumn() == 0) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid subject ID']);
    exit();
}

// Insert or update the score if the user-subject pair already exists
$query = "
    INSERT INTO scores (user_id, subject_id, score)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE score = VALUES(score)
";
$stmt = $pdo->prepare($query);

if ($stmt->execute([$user_id, $subject_id, $score])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Score saved/updated successfully']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Failed to save or update score']);
}

?>
