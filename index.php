<?php
session_start();
// Add your database connection here
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Nursing Thoughts</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./index.css">

  <!-- Internal Styling for Title (Optional override) -->
  <style>
    .main-title {
      font-family: 'Great Vibes', cursive;
      font-size: 3rem;
      color: #fff;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
      letter-spacing: 2px;
    }
  </style>
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop id="bg-video">
  <source src="Image/For bg.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>

<!-- Welcome Section -->
<div class="intro-container text-white text-center">
  <h1 class="main-title">WELCOME TO NURSING THOUGHTS</h1>

  <div class="description-box mx-auto mt-3">
    <p>
      Your ultimate platform for mastering nursing concepts in an engaging and interactive way.
      Enhance your learning with game-based challenges and track your progress.
    </p>
  </div>

  <a href="login.php" class="btn btn-outline-light mt-4">Start Learning</a>
</div>

<!-- Faces Behind Section -->
<div id="aboutUs" class="container py-5 text-white">
  <h2 class="text-center fw-bold mb-4">THE FACES BEHIND</h2>
  <div class="row g-4 justify-content-center">

    <?php
    $faces = [
      "Banday, Khazyneth B.",
      "Bardon, Glenizze Jade M.",
      "Bautista, Shaira Denise S.",
      "Madarang, Maria Carmen A.",
      "Manago, Zcarina Deborah D.",
      "Paway, Mariel A.",
      "Rebusano, Angela M.",
      "Villeno, Isabella Nicole D.",
      "Yanto, Fearly Ann A.",
      "Zamudio, Rosenie B.",
      
    ];

    foreach ($faces as $name) {
      $filename = "./Image/Members/$name.png";
      
      echo '
      <div class="col-md-4 col-lg-3 text-center">
        <img src="'.$filename.'" alt="'.$name.'" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
        <div class="name-box mt-2 fw-semibold">'.$name.'</div>
      </div>';
    }
    ?>

  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
