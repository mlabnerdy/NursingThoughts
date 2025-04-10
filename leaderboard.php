<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="leaderboard.css" />
</head>
<body>
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="navbar sticky-top d-flex justify-content-between align-items-center px-3">
      <div class="nav-avatar"></div>
      <div class="d-flex gap-4">
        <a class="nav-link" href="Homepage.php">Home</a>
        <a class="nav-link" href="Games.php">Games</a>
        <a class="nav-link active" href="leaderboard.php">Leaderboard</a>
      </div>
      <div class="dropdown">
        <div class="nav-profile dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" role="button" aria-expanded="false">
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
    <div class="main-content">
      <div class="leaderboard-container">
        <h2 class="leaderboard-title">LEADERBOARD</h2>
        <table class="table leaderboard-table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Name</th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="rank-cell"><img src="Image/Members/Paway, Mariel A..png" alt="Mariel" class="rank-icon"> 1</td>
              <td>Mariel</td>
              <td>95</td>
            </tr>
            <tr>
              <td class="rank-cell"><img src="Image/Members/john.png" alt="John" class="rank-icon"> 2</td>
              <td>John</td>
              <td>93</td>
            </tr>
            <tr>
              <td class="rank-cell"><img src="Image/Members/clarise.png" alt="Clarise" class="rank-icon"> 3</td>
              <td>Clarise</td>
              <td>90</td>
            </tr>
            <tr>
              <td class="rank-cell"><img src="Image/Members/ana.png" alt="Ana" class="rank-icon"> 4</td>
              <td>Ana</td>
              <td>88</td>
            </tr>
          </tbody>
        </table>
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
