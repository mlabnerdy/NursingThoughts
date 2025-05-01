<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
    exit();
}

require 'db_conn.php'; // This gives you the $pdo instance

// Get subject filter if provided
$subjectFilter = isset($_GET['subject']) && !empty($_GET['subject']) ? $_GET['subject'] : null;

// Fetch subjects for the filter dropdown
$stmtSubjects = $pdo->query("SELECT subject_id, name FROM subjects");
$subjects = $stmtSubjects->fetchAll(PDO::FETCH_ASSOC);

// Prepare leaderboard query using PDO
if ($subjectFilter) {
    $stmt = $pdo->prepare("
        SELECT u.fullName, SUM(s.score) AS total_score
        FROM scores s
        JOIN users u ON s.user_id = u.user_id
        WHERE s.subject_id = :subject_id
        GROUP BY s.user_id
        ORDER BY total_score DESC
    ");
    $stmt->bindParam(':subject_id', $subjectFilter, PDO::PARAM_INT);
} else {
    $stmt = $pdo->prepare("
        SELECT u.fullName, SUM(s.score) AS total_score
        FROM scores s
        JOIN users u ON s.user_id = u.user_id
        GROUP BY s.user_id
        ORDER BY total_score DESC
    ");
}

$stmt->execute();
$leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nursing Thoughts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="icon" type="image/x-icon" href="../IMAGE/nurse.png">
  <link rel="stylesheet" href="./nav.css" />
  <link rel="stylesheet" href="./leaderboard.css" />
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
            <a class="nav-link" href="Games.php"><i class="bi bi-joystick me-1"></i> Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="Leaderboard.php"><i class="bi bi-trophy me-1"></i> Leaderboard</a>
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
    <div class="main-content">
      <div class="leaderboard-container">
        <h2 class="leaderboard-title">LEADERBOARD</h2>

        <!-- Subject Filter -->
        <form method="get" class="mb-4">
          <div class="row g-2 align-items-center">
            <div class="col-auto">
              <label for="subject" class="col-form-label">Filter by Subject:</label>
            </div>
            <div class="col-auto">
              <select class="form-select" name="subject" id="subject" onchange="this.form.submit()">
                <option value="">All Subjects</option>
                <?php foreach ($subjects as $subject): ?>
                  <option value="<?= htmlspecialchars($subject['subject_id']) ?>" <?= ($subjectFilter == $subject['subject_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($subject['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </form>

        <!-- Leaderboard Table -->
        <table class="table leaderboard-table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Name</th>
              <th>Total Score</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($leaderboard) > 0): ?>
              <?php foreach ($leaderboard as $index => $entry): ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= htmlspecialchars($entry['fullName']) ?></td>
                  <td><?= htmlspecialchars($entry['total_score']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="text-center">No scores found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
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
