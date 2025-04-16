<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_conn.php'; // Provides $pdo

// --- Featured Leaderboard / Top Performers ---
$featuredQuery = "
    SELECT u.user_id, u.fullName, u.schoolID, u.YrLvL, SUM(s.score) AS total_score
    FROM scores s
    JOIN users u ON s.user_id = u.user_id
    GROUP BY u.user_id
    ORDER BY total_score DESC
    LIMIT 3
";
$stmtFeatured = $pdo->query($featuredQuery);
$topPerformers = $stmtFeatured->fetchAll(PDO::FETCH_ASSOC);

// --- Performance Overview for the logged-in user ---
$user_id = $_SESSION['user_id'];

$query = "
    SELECT sub.subject_id, sub.name, SUM(s.score) AS total_score, COUNT(*) AS attempts
    FROM scores s
    JOIN subjects sub ON s.subject_id = sub.subject_id
    WHERE s.user_id = :user_id
    GROUP BY sub.subject_id
";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$subjectsPerformance = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the pie chart
$chartLabels = [];
$chartData   = [];
foreach ($subjectsPerformance as $subject) {
    $chartLabels[] = $subject['name'];
    $chartData[]   = $subject['total_score'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nursing Thoughts - Performance Overview</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="Homepage.css" />
</head>
<body>
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
            <a class="nav-link active" href="Homepage.php"><i class="bi bi-house-door me-1"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Games.php"><i class="bi bi-joystick me-1"></i> Games</a>
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




<!-- Main Content Container -->
<div class="container container-flex">
    
    <!-- Top Performers Card -->
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <i class="bi bi-trophy-fill me-2"></i>
        <h3 class="mb-0">Top Performers</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <?php if (count($topPerformers) > 0): ?>
            <?php foreach ($topPerformers as $performer): ?>
              <div class="col-md-4 featured-item text-center">
                <h5><?= htmlspecialchars($performer['fullName']) ?></h5>
                <div class="performer-details">
                  <div><i class="bi bi-person-badge me-1"></i> <?= htmlspecialchars($performer['schoolID']) ?></div>
                  <div><i class="bi bi-book me-1"></i> Year <?= htmlspecialchars($performer['YrLvL']) ?></div>
                  <div class="mt-2">
                    <span class="badge bg-warning text-dark">
                      <i class="bi bi-star-fill me-1"></i> <?= htmlspecialchars($performer['total_score']) ?> pts
                    </span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center py-4">
              <i class="bi bi-emoji-frown display-4 text-muted mb-3"></i>
              <p class="lead">No performers to display yet</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Performance Overview Card -->
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <i class="bi bi-bar-chart-fill me-2"></i>
        <h4 class="mb-0">Performance Overview</h4>
      </div>
      <div class="card-body">
        <div class="row align-items-center">
          <!-- Pie Chart -->
          <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="performance-chart">
              <canvas id="performancePieChart"></canvas>
            </div>
          </div>
          
          <!-- Subject Scores List -->
          <div class="col-lg-6">
            <h5 class="mb-3 d-flex align-items-center">
              <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>
              Subject Scores
            </h5>
            <div class="subject-list">
              <ul class="list-group">
                <?php foreach ($subjectsPerformance as $subject): 
                    $maxScore = $subject['attempts'] * 15;
                    $percentage = round(($subject['total_score'] / $maxScore) * 100);
                ?>
                  <li class="list-group-item">
                    <div>
                      <strong><?= htmlspecialchars($subject['name']) ?></strong>
                      <div class="progress mt-2" style="height: 8px;">
                        <div class="progress-bar bg-warning" 
                             role="progressbar" 
                             style="width: <?= $percentage ?>%;" 
                             aria-valuenow="<?= $percentage ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                        </div>
                      </div>
                    </div>
                    <span><?= htmlspecialchars($subject['total_score']) ?>/<?= $maxScore ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
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

<!-- Chart.js Script -->
<script>
  // Enhanced Chart Configuration
  const chartLabels = <?php echo json_encode($chartLabels); ?>;
  const chartData = <?php echo json_encode($chartData); ?>;
  
  const ctx = document.getElementById('performancePieChart').getContext('2d');
  const performancePieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: chartLabels,
      datasets: [{
        data: chartData,
        backgroundColor: [
          '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
          '#9966FF', '#FF9F40', '#8FD3F4', '#B0E0E6',
          '#A0D6B4', '#90EE90', '#FFB6C1'
        ],
        borderWidth: 0,
        hoverOffset: 10
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: {
          position: 'right',
          labels: {
            boxWidth: 12,
            padding: 20,
            font: {
              size: 12
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.raw;
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = Math.round((value / total) * 100);
              return `${label}: ${value} (${percentage}%)`;
            }
          }
        }
      },
      animation: {
        animateScale: true,
        animateRotate: true
      }
    }
  });
</script>

<!-- Add Bootstrap Icons if not already included -->
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
