<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/x-icon" href="../IMAGE/nurse.png">
  <link rel="stylesheet" href="./fsub.css" />
  <link rel="stylesheet" href="./nav.css" />
  <style>
html, body {
  height: 100%;  /* Full height for the page */
  margin: 0;     /* Remove default margin */
  display: flex;
  flex-direction: column;
}


.wrapper {
  display: flex;
  flex-direction: column;
  flex-grow: 1; 
}


footer {
  background-color: #f57c00;
  text-align: center;
  padding: 10px 0;
  width: 100%;  
  position: relative;
  bottom: 0;
}

footer a:hover {
  text-decoration: underline;
}

/* Welcome Modal Styles */
.welcome-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000; /* ensure it's above the navbar */
  overflow: auto;
  -webkit-overflow-scrolling: touch;
}

.welcome-content {
  background-color: white;
  padding: 40px;
  border-radius: 15px;
  text-align: center;
  max-width: 500px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  margin-top: 70px; /* push content below sticky navbar */
}

.welcome-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 20px;
  color: #f57c00;
}

.welcome-subtitle {
  font-size: 1.5rem;
  margin-bottom: 15px;
  color: #333;
}

.welcome-text {
  font-size: 1.1rem;
  margin-bottom: 25px;
  line-height: 1.6;
  color: #555;
}



.start-btn {
  background-color: #f57c00;
  color: white;
  border: none;
  padding: 10px 30px;
  font-size: 1.2rem;
  border-radius: 30px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.start-btn:hover {
  background-color: #e67300;
} 

/* Quiz Container */
.quiz-container {
  max-width: 500px;
  margin: 40px auto;
  padding: 20px;
  border: 2px solid #FF8F23;
  border-radius: 10px;
  background-color: rgb(255, 249, 241);
  text-align: center;
  flex-grow: 1;  /* This ensures the quiz container expands to fill space if needed */
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
  background-color: #f57c00;
  border: none;
  color: #000;
}

.quiz-container .btn:hover {
  background-color: rgb(248, 228, 200);
}

.result-item {
  text-align: left;
  margin-top: 10px;
  background: #fff3e6;
  padding: 10px;
  border-radius: 8px;
}
.custom-danger-btn {
    background-color: #dc3545 !important;
    color: white !important;
    border: 1px solid #dc3545 !important;
}

.custom-danger-btn:hover {
    background-color: #bb2d3b !important;
    border-color: #b02a37 !important;
    color: white !important;
}

.modal {
  display: none;
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.5);
  box-sizing: border-box;
  padding: 1rem;
  z-index: 2000;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow-y: auto;
}


.modal-content {
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 12px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  text-align: center;
  font-family: 'Poppins', sans-serif;
  box-sizing: border-box;
  animation: fadeIn 0.3s ease;
  margin-top: 60px; /* Adjust based on navbar height */
}



.modal-content p {
  margin-bottom: 1rem;
  font-size: 1rem;
  color: #333;
}

.modal-buttons {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.75rem;
}

.confirm-btn,
.cancel-btn {
  flex: 1 1 120px;
  padding: 10px;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.confirm-btn {
  background-color: #FF8F23;
  color: white;
}

.confirm-btn:hover {
  background-color: #e57f1f;
}

.cancel-btn {
  background-color: #ccc;
  color: #333;
}

.cancel-btn:hover {
  background-color: #bbb;
}

/* Optional fade-in animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}


  /* Responsive for smaller screens */
  @media (max-width: 576px) {
      #aboutUs img {
        width: 120px;
        height: 120px;
        margin-top: 60px;
      }
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

    <div class="wrapper">
   
    <!-- Welcome Modal -->
    <div class="welcome-modal" id="welcomeModal">
      <div class="welcome-content">
        <div class="welcome-title">MEDICAL TOOLS AND EQUIPMENT</div>
        <div class="welcome-subtitle">Welcome to Nursing Thoughts Medical Tools and Equipment Familiarization Activity</div>
        <div class="welcome-text">
          This is a practice mode designed to help you review and recognize common medical tools and equipment through images.
          <br><br>
          Your score here won’t affect your leaderboard rank. This is purely for learning and self-review.
          <br><br>
          Take your time, guess the correct tool based on the image, and reinforce your nursing knowledge in a fun and interactive way.
        </div>
        <button class="start-btn" id="startBtn">Start</button>
      </div>
    </div>

<!-- Quiz Container -->
<div class="quiz-container position-relative">
  <!-- Exit button positioned absolutely at top right -->
  <a href="Games.php" class="btn custom-danger-btn position-absolute top-0 end-0 m-2">
  <i class="fas fa-times"></i> Exit
</a>

  <div id="quiz-content">
    <div id="question-counter" style="font-weight: bold; margin-bottom: 15px;"></div>
    <h2>Guess the Medical Tools and Equipment</h2>
    <img id="tool-image" src="" alt="Medical Tool">
    <p id="description"></p>
    <input type="text" id="user-answer" placeholder="Type your answer here">
    <div id="feedback" style="margin-top: 10px;"></div>

    <div>
      <button class="btn" onclick="nextQuestion()">Next</button>
     <button class="btn" onclick="openConfirmationModal()">Submit</button>
    </div>
  </div>

  <!-- Result section -->
  <div id="result-section" style="display: none;">
    <div id="score" style="font-weight: bold; margin-top: 20px;"></div>
    <div id="review"></div>
    <div class="d-flex justify-content-center gap-3 mt-4">
      <button class="btn btn-warning px-4 fw-bold text-white" onclick="resetQuiz()" style="border-radius: 25px;">Try Again</button>
    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Are you sure you want to submit the quiz?</p>
    <div class="modal-buttons">
      <button class="confirm-btn" onclick="confirmSubmit()">Yes, Submit</button>
      <button class="cancel-btn" onclick="closeConfirmationModal()">Cancel</button>
    </div>
  </div>
</div>

    <!-- Footer (DO NOT MODIFY) -->
    <footer class="footer">
      <div>@NursingThoughts</div>
      <a href="./aboutus.php">About Us</a>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

      // Show the welcome modal on page load
  window.onload = function() {
    const modal = document.getElementById('welcomeModal');
    const startBtn = document.getElementById('startBtn');
    const quizContent = document.getElementById('quiz-content');

    // Show the modal when the page loads
    modal.style.display = 'flex';

    // When the user clicks "Start", hide the modal and show the quiz
    startBtn.addEventListener('click', function() {
      modal.style.display = 'none';
      quizContent.style.display = 'block';
      loadQuestion();
    });
  }
    window.onload = function() {
      const modal = document.getElementById('welcomeModal');
      const startBtn = document.getElementById('startBtn');
      const quizContent = document.getElementById('quiz-content');

      // Show the modal when the page loads
      modal.style.display = 'flex';

      // When the user clicks "Start", hide the modal and show the quiz
      startBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        quizContent.style.display = 'block';
        loadQuestion();
      });
    }

    // Warn before leaving or reloading the page
    window.addEventListener("beforeunload", function (e) {
      e.preventDefault(); 
      e.returnValue = ''; 
    });

    function openConfirmationModal() {
  document.getElementById("confirmationModal").style.display = "block";
}

function closeConfirmationModal() {
  document.getElementById("confirmationModal").style.display = "none";
}

function confirmSubmit() {
  closeConfirmationModal();
  finishQuiz(); // call your actual quiz submission function
}


  </script>
</body>
</html>
