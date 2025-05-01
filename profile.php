<?php
session_start();
require_once 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $yearlevel = $_POST['yearlevel'];

    $stmt = $pdo->prepare("UPDATE users SET fullName = ?, YrLvl = ?, email = ? WHERE user_id = ?");
    if ($stmt->execute([$fullname, $yearlevel, $email, $user_id])) {
        echo "<script>alert('Profile updated successfully'); window.location.href='profile.php';</script>";
    } else {
        echo "Error updating profile.";
    }
}

// Fetch current user data
$stmt = $pdo->prepare("SELECT schoolID, fullName, YrLvl, email FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nursing Thoughts - Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="icon" type="image/x-icon" href="../IMAGE/nurse.png">
    <link rel="stylesheet" href="./nav.css" />
    <link rel="stylesheet" href="./profile.css" />
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
                <a class="nav-link" href="Homepage.php"><i class="bi bi-house-door me-1"></i> Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Games.php"><i class="bi bi-joystick me-1"></i> Games</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Leaderboard.php"><i class="bi bi-trophy me-1"></i> Leaderboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="profile.php"><i class="bi bi-person me-1"></i> Profile</a>
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

    <div class="main-container container">
        <div class="profile-card">
            <h1 class="profile-title">User Profile</h1>
            <form class="profile-form" method="POST" action="profile.php">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($user['fullName']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="schoolid">School ID</label>
                    <input type="text" id="schoolid" name="schoolid" value="<?= htmlspecialchars($user['schoolID']) ?>" readonly>
                </div>

                <div class="form-group">
    <label for="yearlevel">Year Level</label>
    <select id="yearlevel" name="yearlevel" required>
        <option value="">Select Year Level</option>
        <?php
        $suffixes = ['1' => 'st', '2' => 'nd', '3' => 'rd', '4' => 'th', '5' => 'th'];
        for ($i = 1; $i <= 5; $i++) {
            $suffix = $suffixes[$i];
            $selected = ($user['YrLvl'] == $i) ? 'selected' : '';
            echo "<option value=\"$i\" $selected>{$i}{$suffix} Year</option>";
        }
        ?>
    </select>
</div>


                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <button type="submit" class="save-btn">Save Profile</button>
            </form>
        </div>
    </div>

      <!-- Footer -->
  <footer class="footer">
    <div>@NursingThoughts</div>
    <a href="AboutUs.php">About Us</a>
  </footer>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>