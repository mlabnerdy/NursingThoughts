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
  <title>Nursing Thoughts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="./fsub.css" />
  <link rel="stylesheet" href="./nav.css" />
  <link rel="icon" type="image/x-icon" href="../IMAGE/nurse.png">
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
    <h1 class="text-center page-title">SUBJECTS</h1>
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-10">
        <div class="subject-grid">
          <a href="Flashcard/rabe.php"><button class="subject-btn">RABE</button></a>
          <a href="Flashcard/fin.php"><button class="subject-btn">Fundamentals in Nursing</button></a>
          <a href="Flashcard/be.php"><button class="subject-btn">Bio-Ethics</button></a>
          <a href="Flashcard/ndt.php"><button class="subject-btn">Nutrition and Diet Therapy</button></a>
          <a href="Flashcard/pharma.php"><button class="subject-btn">Pharmacology</button></a>
          <a href="FLashcard/mt.php"><button class="subject-btn">Medical Terminologies</button></a>
          <a href="Flashcard/anp.php"><button class="subject-btn">Anatomy and Physiology</button></a>
          <a href="Flashcard/mtc.php"><button class="subject-btn">Maternal and Child</button></a>
          <a href="Flashcard/chn.php"><button class="subject-btn">Community Health Nursing</button></a>
          <a href="Flashcard/ha.php"><button class="subject-btn">Health Assessment</button></a>
          <a href="Flashcard/tfn.php"><button class="subject-btn">Theoretical Foundation of Nursing</button></a>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Footer -->
    <footer class="footer">
      <div>@NursingThoughts</div>
      <a href="./aboutus.php">About Us</a>
    </footer>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>