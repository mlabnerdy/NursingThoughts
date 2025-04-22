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
      max-width: 500px;
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
  <div id="quiz-content">
    <div id="question-counter" style="font-weight: bold; margin-bottom: 15px;"></div>
    <h2>Guess the Medical Tools and Equipment</h2>
    <img id="tool-image" src="" alt="Medical Tool">
    <p id="description"></p>
    <input type="text" id="user-answer" placeholder="Type your answer here">
    <div id="feedback" style="margin-top: 10px;"></div>

    <div>
      <button class="btn" onclick="nextQuestion()">Next</button>
      <button class="btn" onclick="finishQuiz()">Submit</button>
    </div>
  </div>

  <!-- This will remain and be shown after Submit -->
  <div id="result-section" style="display: none;">
    <div id="score" style="font-weight: bold; margin-top: 20px;"></div>
    <div id="review"></div>
    <div class="d-flex justify-content-center gap-3 mt-4">
      <button class="btn btn-warning px-4 fw-bold text-white" onclick="resetQuiz()" style="border-radius: 25px;">Try Again</button>
      <a href="Homepage.php" class="btn btn-outline-warning px-4 fw-bold" style="border-radius: 25px;">Exit</a>
    </div>
  </div>
</div>


    

    <!-- Footer (DO NOT MODIFY) -->
    <footer class="footer">
      <div>@NursingThoughts</div>
      <a href="AboutUs.php">About Us</a>
    </footer>
  </div>

  <script>
  const items = <?php echo json_encode($quizItems); ?>;

  // Shuffle function
function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

// Shuffle the items
const shuffledItems = shuffle([...items]); // Clone and shuffle
let currentIndex = 0;
let userAnswers = Array(shuffledItems.length).fill("");
let answeredFlags = Array(shuffledItems.length).fill(false);

function loadQuestion() {
  const current = shuffledItems[currentIndex];
  document.getElementById('tool-image').src = `IMAGE/MEDICAL TOOLS AND EQUIPMENT/${current.image}`;
  document.getElementById('description').textContent = current.description;
  document.getElementById('user-answer').value = userAnswers[currentIndex] || "";
  document.getElementById('score').textContent = "";
  document.getElementById('review').innerHTML = "";
  document.getElementById('feedback').innerHTML = "";

  // Set question counter
  document.getElementById('question-counter').textContent = `Question ${currentIndex + 1} of ${shuffledItems.length}`;

  const input = document.getElementById('user-answer');
  input.disabled = answeredFlags[currentIndex];

  if (answeredFlags[currentIndex]) {
    showAnswerFeedback(currentIndex);
  }
}

function showAnswerFeedback(index) {
  const user = userAnswers[index];
  const correct = shuffledItems[index].answer;
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

  setTimeout(() => {
    if (currentIndex < shuffledItems.length - 1) {
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

  shuffledItems.forEach((item, index) => {
    const user = userAnswers[index] || "No answer";
    const correct = item.answer;
    const isCorrect = user.toLowerCase() === correct.toLowerCase();

    if (isCorrect) score++;

    reviewHTML += `
      <div class="result-item">
        <strong>Question ${index + 1}:</strong><br>
        <em>${item.description}</em><br>
        Your Answer: <strong>${user}</strong><br>
        Correct Answer: <strong>${correct}</strong><br>
        Result: ${isCorrect ? "<span style='color:green;'>✅ Correct</span>" : "<span style='color:red;'>❌ Incorrect</span>"}
      </div>
    `;
  });

  // Hide quiz content and show results
  document.getElementById('quiz-content').style.display = 'none';
  document.getElementById('result-section').style.display = 'block';

  document.getElementById('score').innerHTML = `You got <strong>${score}</strong> out of <strong>${shuffledItems.length}</strong> correct.`;
  document.getElementById('review').innerHTML = reviewHTML;
}

function resetQuiz() {
  currentIndex = 0;
  userAnswers = Array(shuffledItems.length).fill("");
  answeredFlags = Array(shuffledItems.length).fill(false);
  shuffle(shuffledItems);
  document.getElementById('quiz-content').style.display = 'block';
  document.getElementById('result-section').style.display = 'none';
  loadQuestion();
}


window.onload = loadQuestion;

  </script>
</body>
</html>
