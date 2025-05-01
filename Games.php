<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
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
  <link rel="stylesheet" href="./nav.css" />
  <link rel="stylesheet" href="./category.css"/>
</head>
<body>
  <div class="wrapper">
<!-- Navbar -->
<nav class="navbar sticky-top navbar-expand-lg px-3" style="background-color: #f57c00; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
  <div class="container-fluid">
    <!-- Logo with Nursing Theme -->
    <a class="navbar-brand d-flex align-items-center" href="Homepage.php">
      <div class="nav-logo me-2" style="font-size: 1.8rem; color: #e74c3c;">
        <i class="bi bi-heart-pulse"></i>
      </div>
      <span style="font-weight: 600; color: #2c3e50;">NursingThoughts</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <div class="d-flex ms-auto align-items-center">
        <ul class="navbar-nav mb-2 mb-lg-0 d-flex align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="Homepage.php"><i class="bi bi-house-door me-1"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="Games.php"><i class="bi bi-joystick me-1"></i> Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Leaderboard.php"><i class="bi bi-trophy me-1"></i> Leaderboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php"><i class="bi bi-person me-1"></i> Profile</a>
          </li>

          <!-- Red divider before logout -->
          <li>
            <hr class="dropdown-divider" style="border-top: 2px solid #e74c3c; margin: 0 1rem;">
          </li>

          <!-- Red Logout Button -->
          <li class="nav-item ms-2">
            <a class="btn btn-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
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
                <a href="GuessSub.php" class="btn btn-primary">Start</a>
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
