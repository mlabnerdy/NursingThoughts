<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nursing Thoughts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="nav.css" />
</head>
<body>
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="navbar sticky-top d-flex justify-content-between align-items-center px-3">
      <div class="nav-avatar"></div>
      <div class="d-flex gap-4">
        <a class="nav-link active" href="Homepage.php">Home</a>
        <a class="nav-link" href="Games.php">Games</a>
        <a class="nav-link" href="Leaderboard.php">Leaderboard</a>
      </div>
      <div class="nav-profile">
        <i class="bi bi-person-fill"></i>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Dito ilalagay yung mga subject with percentage -->
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
