<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Now include the DB connection
require 'db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Games</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="category.css"/>
</head>
<body>
  <div class="wrapper">
     <!-- Navbar -->
     <nav class="navbar sticky-top d-flex justify-content-between align-items-center px-3">
      <div class="nav-avatar"></div>
      <div class="d-flex gap-4">
        <a class="nav-link" href="Homepage.php">Home</a>
        <a class="nav-link active" href="Games.php">Games</a>
        <a class="nav-link" href="Leaderboard.php">Leaderboard</a>
      </div>
      <div class="dropdown">
        <div class="nav-profile dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-fill"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center">
      <div class="container py-5">
        <h1 class="text-center mb-5">Choose Your Learning Mode</h1>

        <div class="row justify-content-center g-4">
          <!-- Flashcards -->
          <div class="col-md-4">
            <div class="card category-card text-center h-100 shadow-sm">
              <div class="card-body">
                <div class="card-icon mb-3 text-warning fs-1">
                  <i class="bi bi-collection-play-fill"></i>
                </div>
                <h3 class="card-title">Flashcards</h3>
                <p class="card-text">Review concepts with interactive flashcards</p>
                <a href="FlashcardSub.php" class="btn btn-primary">Start Learning</a>
              </div>
            </div>
          </div>

          <!-- Quiz Game -->
          <div class="col-md-4">
            <div class="card category-card text-center h-100 shadow-sm">
              <div class="card-body">
                <div class="card-icon mb-3 text-warning fs-1">
                  <i class="bi bi-controller"></i>
                </div>
                <h3 class="card-title">Quiz Game</h3>
                <p class="card-text">Test your knowledge with fun quizzes</p>
                <a href="QuizSub.php" class="btn btn-primary">Start Quiz</a>
              </div>
            </div>
          </div>

          <!-- Guess the Photo -->
          <div class="col-md-4">
            <div class="card category-card text-center h-100 shadow-sm">
              <div class="card-body">
                <div class="card-icon mb-3 text-warning fs-1">
                  <i class="bi bi-camera2"></i>
                </div>
                <h3 class="card-title">Guess the Photo</h3>
                <p class="card-text">Learn through visual identification</p>
                <a href="GuessSub.php" class="btn btn-primary">Start Game</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <div>@NursingThoughts</div>
      <a href="AboutUs.php">About Us</a>
    </footer>
  </div>

  <!-- Bootstrap JS (Only one version) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
