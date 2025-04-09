<?php
// save_score.php
// Replace with your database connection details
$host = 'localhost';
$dbname = 'nursingthoughts';
$username = 'root';
$pass = ''; // your actual password


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get POST data from JavaScript
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['user_id'];
    $subjectId = $data['subject_id'];
    $score = $data['score'];

    // Insert score into the database
    $stmt = $pdo->prepare("INSERT INTO scores (user_id, subject_id, score) VALUES (:user_id, :subject_id, :score)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':subject_id', $subjectId);
    $stmt->bindParam(':score', $score);

    $stmt->execute();

    // Return success response
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Return error response
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
