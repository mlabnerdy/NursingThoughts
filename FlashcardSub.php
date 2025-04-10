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
  <title>Nursing Thoughts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="fsub.css" />
  <link rel="stylesheet" href="nav.css" />
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
      <a href="AboutUs.php">About Us</a>
    </footer>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>