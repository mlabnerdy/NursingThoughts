<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nursing Thoughts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="introguessthephoto.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
<body style="overflow: hidden;">

<div class="wrapper">
    <!-- Navigation (DO NOT MODIFY) -->
    <nav class="navbar sticky-top navbar-expand-lg px-3" style="background-color: #f57c00; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
      <div class="container-fluid">
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
              <li><hr class="dropdown-divider" style="border-top: 2px solid #e74c3c; margin: 0 1rem;"></li>
              <li class="nav-item ms-2">
                <a class="btn btn-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>


  <!-- Welcome Modal -->
  <div class="welcome-modal" id="welcomeModal">
      <div class="welcome-content">
        <div class="welcome-title">MEDICAL TOOLS AND EQUIPMENT</div>
        <div class="welcome-subtitle">Welcome to Nursing Thoughts Medical Tools and Equipment Familiarization Activity</div>
        <div class="welcome-text">
            This is a practice mode designed to help you review and recognize common medical tools and equipment through images.
            <br><br>
            Your score here won’t affect your leaderboard rank. This is purely for learning and self-review.
            <br><br>
            Take your time, guess the correct tool based on the image, and reinforce your nursing knowledge in a fun and interactive way.
        
        </div>
        <button class="start-btn" id="startBtn">Start</button>
      </div>
    </div>

  <!-- Footer -->
  <footer class="footer">
    <div>@NursingThoughts</div>
    <a href="AboutUs.php">About Us</a>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap Icons (optional for the user icon) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>

