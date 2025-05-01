<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include the DB connection
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nursing Thoughts</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="icon" type="image/x-icon" href="../IMAGE/nurse.png">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="./fsub.css" />
  <link rel="stylesheet" href="./nav.css" />
  <link rel="stylesheet" href="./index.css" />

  <!-- Internal Styling for Title and Cards -->
  <style>
   .main-title {
  font-family: 'Great Vibes', cursive;
  font-size: 3rem;
  color: #f57c00; /* Nice orange, same as your theme */
  text-shadow: 2px 2px 5px rgba(0,0,0,0.1);
  letter-spacing: 2px;
}


    #aboutUs .member-card {
      background: rgba(245, 161, 106, 0.75);
      border-radius: 15px;
      padding: 20px;
      transition: transform 0.3s ease;
    }

    #aboutUs .member-card:hover {
      transform: scale(1.05);
    }

    #aboutUs img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      object-position: center;
      border-radius: 50%;
      border: 4px solid #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .name-box {
    margin-top: 10px;
    font-weight: bold;
    font-size: 1rem;
    color: black; /* Changed font color to black */
  }

    /* Responsive for smaller screens */
    @media (max-width: 576px) {
      #aboutUs img {
        width: 120px;
        height: 120px;
      }
    }
  </style>
</head>

<body>
<div class="wrapper">

<!-- Navbar (ORIGINAL - untouched) -->
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
      <ul class="navbar-nav mb-2 mb-lg-0 d-flex align-items-center ms-auto">
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

        <li>
          <hr class="dropdown-divider" style="border-top: 2px solid #e74c3c; margin: 0 1rem;">
        </li>

        <li class="nav-item ms-2">
          <a class="btn btn-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Faces Behind Section (Fixed) -->
<div id="aboutUs" class="container py-5">
  <h2 class="main-title text-center mb-5">THE FACES BEHIND</h2>
  <div class="row g-4 justify-content-center">

    <?php
    $faces = [
      "Madarang, Maria Carmen A.",
      "Paway, Mariel A.",
      "Rebusano, Angela M.",
      "Manago, Zcarina Deborah D.",
      "Villeno, Isabella Nicole D.",
      "Yanto, Fearly Ann A.",
      "Zamudio, Rosenie B.",
      "Banday, Khazyneth B.",
      "Bardon, Glenizze Jade M.",
      "Bautista, Shaira Denise S."
    ];

    foreach ($faces as $name) {
      $filename = "Image/Members/$name.png";
      echo '
      <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
        <div class="member-card text-center">
          <img src="'.$filename.'" alt="'.$name.'">
          <div class="name-box">'.$name.'</div>
        </div>
      </div>';
    }
    ?>

  </div>
</div>


<!-- Footer (ORIGINAL - untouched) -->
<footer class="footer">
  <div>@NursingThoughts</div>
  <a href="./aboutus.php">About Us</a>
</footer>

</div> <!-- End wrapper -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
