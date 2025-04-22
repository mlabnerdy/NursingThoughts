<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_conn.php';
// Load quiz items from JSON file
$jsonData = file_get_contents('guessthephoto.json');
$quizItems = json_decode($jsonData, true);
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
  <style>
    .quiz-container {
      max-width: 600px;
      margin: 40px auto;
      padding: 20px;
      border: 2px solid #f0c28a;
      border-radius: 10px;
      background-color: #fff9f1;
      text-align: center;
    }
    .quiz-container img {
      max-width: 100%;
      border-radius: 10px;
    }
    .quiz-container input[type="text"] {
      width: 90%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 20px;
    }
    .quiz-container .btn {
      margin: 5px;
      background-color: #f0c28a;
      border: none;
      color: #000;
    }
    .quiz-container .btn:hover {
      background-color: #e0a95c;
    }
    .result-item {
      text-align: left;
      margin-top: 10px;
      background: #fff3e6;
      padding: 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
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

    <!-- Quiz Container -->
    <div class="quiz-container">
      <h2>Guess the Medical Tool</h2>
      <img id="tool-image" src="" alt="Medical Tool">
      <p id="description"></p>
      <input type="text" id="user-answer" placeholder="Type your answer here">
      <div id="feedback" style="margin-top: 10px;"></div>

      <div>
        <button class="btn" onclick="nextQuestion()">Next</button>
        <button class="btn" onclick="finishQuiz()">Submit</button>
      </div>
      <div id="score" style="font-weight: bold; margin-top: 20px;"></div>
      <div id="review"></div>
    </div>

    <!-- Footer (DO NOT MODIFY) -->
    <footer class="footer">
      <div>@NursingThoughts</div>
      <a href="AboutUs.php">About Us</a>
    </footer>
  </div>


  <script>
  const items = <?php echo json_encode($quizItems); ?>;

  let currentIndex = 0;
  let userAnswers = Array(items.length).fill("");
  let answeredFlags = Array(items.length).fill(false);

  function loadQuestion() {
    const current = items[currentIndex];
    document.getElementById('tool-image').src = `IMAGE/MEDICAL TOOLS AND EQUIPMENT/${current.image}`;
    document.getElementById('description').textContent = current.description;
    document.getElementById('user-answer').value = userAnswers[currentIndex] || "";
    document.getElementById('score').textContent = "";
    document.getElementById('review').innerHTML = "";
    document.getElementById('feedback').innerHTML = "";

    const input = document.getElementById('user-answer');
    input.disabled = answeredFlags[currentIndex];

    if (answeredFlags[currentIndex]) {
      showAnswerFeedback(currentIndex);
    }
  }

  function showAnswerFeedback(index) {
    const user = userAnswers[index];
    const correct = items[index].answer;
    const input = document.getElementById('user-answer');

    let feedbackText = "";
    let feedbackColor = "";

    if (!user) {
      feedbackText = "❗ No answer";
      feedbackColor = "orange";
    } else if (user.toLowerCase() === correct.toLowerCase()) {
      feedbackText = "✅ Correct";
      feedbackColor = "green";
    } else {
      feedbackText = `❌ Wrong answer<br>Correct answer: <strong>${correct}</strong>`;
      feedbackColor = "red";
    }

    document.getElementById('feedback').innerHTML = `<div style="color: ${feedbackColor}; font-weight: bold;">${feedbackText}</div>`;
  }

  function nextQuestion() {
    const input = document.getElementById('user-answer');

    if (answeredFlags[currentIndex]) return;

    userAnswers[currentIndex] = input.value.trim();
    answeredFlags[currentIndex] = true;
    input.disabled = true;

    showAnswerFeedback(currentIndex);

    // Auto move to next question
    setTimeout(() => {
      if (currentIndex < items.length - 1) {
        currentIndex++;
        loadQuestion();
      } else {
        finishQuiz();
      }
    }, 1500);
  }

  function finishQuiz() {
    if (!answeredFlags[currentIndex]) {
      userAnswers[currentIndex] = document.getElementById('user-answer').value.trim();
      answeredFlags[currentIndex] = true;
    }

    let score = 0;
    let reviewHTML = "<h4 class='mt-4'>Review:</h4>";

    items.forEach((item, index) => {
      const user = userAnswers[index];
      const correct = item.answer;
      const isCorrect = user.toLowerCase() === correct.toLowerCase();

      if (isCorrect) score++;

      let statusText = "";
      let statusColor = "";

      if (!user) {
        statusText = "❗No answer";
        statusColor = "orange";
      } else if (isCorrect) {
        statusText = "✅ Correct";
        statusColor = "green";
      } else {
        statusText = "❌ Wrong";
        statusColor = "red";
      }

      reviewHTML += `
        <div class="result-item">
          <strong>Q${index + 1}:</strong> ${item.description}<br>
          <strong>Your answer:</strong> ${user || "<i>No answer</i>"}<br>
          <strong>Correct answer:</strong> ${correct}<br>
          <span style="color: ${statusColor}; font-weight: bold;">${statusText}</span>
        </div>
      `;
    });

    document.getElementById('score').innerHTML = `You scored <strong>${score}</strong> out of ${items.length}`;
    document.getElementById('review').innerHTML = reviewHTML;
    document.getElementById('feedback').innerHTML = "";
  }

  window.onload = loadQuestion;
</script>

</body>
</html>
