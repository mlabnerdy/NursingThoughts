<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Now include the DB connection
require '../db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nursing Thoughts Quiz</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../nav.css" />
  <link rel="stylesheet" href="quiz.css" />
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
            <a class="nav-link" href="../Homepage.php"><i class="bi bi-house-door me-1"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../Games.php"><i class="bi bi-joystick me-1"></i> Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../Leaderboard.php"><i class="bi bi-trophy me-1"></i> Leaderboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../profile.php"><i class="bi bi-person me-1"></i> Profile</a>
          </li>

          <!-- Red divider before logout -->
          <li>
            <hr class="dropdown-divider" style="border-top: 2px solid #e74c3c; margin: 0 1rem;">
          </li>

          <!-- Red Logout Button -->
          <li class="nav-item ms-2">
            <a class="btn btn-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

    <!-- Welcome Modal -->
    <div class="welcome-modal" id="welcomeModal">
      <div class="welcome-content">
        <div class="welcome-title">NURSING QUIZ</div>
        <div class="welcome-subtitle">Welcome to Nursing Thoughts Quiz Game</div>
        <div class="welcome-text">
          Test your nursing knowledge with this interactive quiz game.<br>
          Answer multiple-choice questions and see how well you know<br>
          important nursing concepts and terminology.
        </div>
        <button class="start-btn" id="startBtn">Start Quiz</button>
      </div>
    </div>




<!-- Quiz Container -->
<div class="quiz-container" id="quizContainer">
  <h1 class="quiz-title">
    <i class="bi bi-question-circle"></i> QUIZ GAME
  </h1>
  <h2 class="quiz-subtitle">Select a correct answer</h2>
  <h2 class="quiz-mainSub">Answer all questions to Submit!</h2>

  <div id="timer">10:00</div>
  
  <div class="quiz-card">
    <div class="quiz-question" id="questionText"></div>
    <div class="quiz-options" id="optionsContainer"></div>
    <div class="true-false-container" id="trueFalseContainer" style="display: none;">
      <div class="true-false-btn" id="trueBtn">True</div>
      <div class="true-false-btn" id="falseBtn">False</div>
    </div>
    
    <div class="progress-indicator" id="progressIndicator"></div>

  
  </div>

  

  <div class="navigation-buttons">
  <button class="nav-btn" id="prevBtn" style="visibility: hidden;">Previous</button>
<button id="nextBtn" type="button" value="1" class="nav-btn">Next</button>


  </div>
  
  <button class="submit-btn" id="submitBtn">Submit Answers</button>
</div>


    <!-- Completion Modal -->
    <div class="modal" id="completionModal">
      <div class="modal-content">
        <h2 class="completion-title">Quiz Completed!</h2>
        <p class="completion-text" id="scoreText"></p>
        <div class="completion-buttons">
          <button class="completion-btn restart-btn" id="restartBtn">Try Again</button>
          <button class="completion-btn finish-btn" id="finishBtn">Submit Answer</button>
          <button class="completion-btn finish-btn" id="returnBtn">Go Back to Games</button>

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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const subject = urlParams.get('subject');

    //console.log(subject);
    if(subject === 'RABE' || subject === 'Fundamentals in Nursing' || subject === 'Bio-Ethics' ||subject === 'Nutrition and Diet Therapy' ||subject === 'Pharmacology' ||subject === 'Medical Terminologies' ||subject === 'Anatomy and Physiology' ||subject === 'Maternal and Child' ||subject === 'Community Health Nursing' ||subject === 'Health Assessment' ||subject === 'Theoretical Foundation of Nursing'){
        fetch(subject+'.json')
        .then(response => response.json())
        .then(question => {
            window.questions = question;
        })
        .catch(error => {
            console.error('Error loading JSON:', error);
        });

    }
    else{
        window.location.href = '../Games.php';
    }
        
    // Quiz variables
    let currentQuestionIndex = 0;
    let userAnswers = [];
    let timer;
    let timeLeft = 10 * 60; // 10 minutes in seconds
    let quizActive = false;

    // DOM elements
    const welcomeModal = document.getElementById('welcomeModal');
    const quizContainer = document.getElementById('quizContainer');
    const startBtn = document.getElementById('startBtn');
    const questionText = document.getElementById('questionText');
    const optionsContainer = document.getElementById('optionsContainer');
    const trueFalseContainer = document.getElementById('trueFalseContainer');
    const trueBtn = document.getElementById('trueBtn');
    const falseBtn = document.getElementById('falseBtn');
    const progressIndicator = document.getElementById('progressIndicator');
    const submitBtn = document.getElementById('submitBtn');
    const timerDisplay = document.getElementById('timer');
    const completionModal = document.getElementById('completionModal');
    const scoreText = document.getElementById('scoreText');
    const restartBtn = document.getElementById('restartBtn');
    const finishBtn = document.getElementById('finishBtn');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const returnBtn = document.getElementById('returnBtn');

    // Initialize the quiz
    function initQuiz() {

        submitBtn.style.display = 'none';

        shuffleArray(questions);

        userAnswers = new Array(questions.length).fill(null);

        welcomeModal.style.display = 'none';
        quizContainer.style.display = 'flex';
        
        startTimer();
        displayQuestion();

        quizActive = true;


        
    }

    // Display current question
    function displayQuestion() {
        const question = questions[currentQuestionIndex];
        questionText.textContent = question.question;

        progressIndicator.textContent = `Question ${currentQuestionIndex + 1} of ${questions.length}`;

        

        if (question.type === "mcq") {
            optionsContainer.style.display = "grid";
            trueFalseContainer.style.display = "none";

            optionsContainer.innerHTML = "";

            question.options.forEach((option, index) => {
                const optionElement = document.createElement("div");
                optionElement.className = "quiz-option";
                if (userAnswers[currentQuestionIndex] === index) {
                    optionElement.classList.add("selected");
                }
                optionElement.textContent = option;
                optionElement.addEventListener("click", () => selectOption(index));
                optionsContainer.appendChild(optionElement);
            });
        } else {
            optionsContainer.style.display = "none";
            trueFalseContainer.style.display = "flex";

            trueBtn.classList.remove("selected");
            falseBtn.classList.remove("selected");

            if (userAnswers[currentQuestionIndex] !== null) {
                if (userAnswers[currentQuestionIndex]) {
                    trueBtn.classList.add("selected");
                } else {
                    falseBtn.classList.add("selected");
                }
            }
        }
    }



    function selectOption(index) {
        document.querySelectorAll('.quiz-option').forEach(option => {
            option.classList.remove('selected');
        });

        event.target.classList.add('selected');

        userAnswers[currentQuestionIndex] = index;

        console.log(userAnswers);

        if (userAnswers.some(value => value === null)) {
            console.log("There are unanswered (null) values.");
            submitBtn.style.display = 'none';

        } else {
            submitBtn.style.display = 'inline-block';

        }

    }

    trueBtn.addEventListener('click', () => {
        trueBtn.classList.add('selected');
        falseBtn.classList.remove('selected');
        userAnswers[currentQuestionIndex] = true;

        console.log(userAnswers);

        if (userAnswers.some(value => value === null)) {
            console.log("There are unanswered (null) values.");
            submitBtn.style.display = 'none';

        } else {
            submitBtn.style.display = 'inline-block';

        }


    });

    falseBtn.addEventListener('click', () => {
        falseBtn.classList.add('selected');
        trueBtn.classList.remove('selected');
        userAnswers[currentQuestionIndex] = false;

        console.log(userAnswers);
   
        if (userAnswers.some(value => value === null)) {
            console.log("There are unanswered (null) values.");
            submitBtn.style.display = 'none';

        } else {
            submitBtn.style.display = 'inline-block';

        }


    });

    // Start timer
    function startTimer() {
        updateTimerDisplay();

        timer = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                clearInterval(timer);
                endQuiz();
            }
        }, 1000);
    }

    // Update timer display
    function updateTimerDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    // Shuffle array
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    // Calculate score
    function calculateScore() {
        let score = 0;

        questions.forEach((question, index) => {
            if (userAnswers[index] !== null) {
                if (question.type === "mcq") {
                    if (userAnswers[index] === question.answer) {
                        score++;
                    }
                } else {
                    if (userAnswers[index] === question.answer) {
                        score++;
                    }
                }
            }
        });

        return score;
    }

    // End quiz
    function endQuiz() {
        quizActive = false;
        clearInterval(timer);

        const score = calculateScore();
        const percentage = Math.round((score / questions.length) * 100);

        scoreText.textContent = `You scored ${score} out of ${questions.length} (${percentage}%)`;
        completionModal.style.display = 'flex';
        
        if (score <= 0) {
            finishBtn.style.display = 'none';
            returnBtn.style.display = 'inline-block';
        } else {
            finishBtn.style.display = 'inline-block';
            returnBtn.style.display = 'none';
        }
    }

    // Event listeners
    startBtn.addEventListener('click', initQuiz);

    returnBtn.addEventListener('click', () => {
        window.location.href = '../Games.php';
    });


    submitBtn.addEventListener('click', () => {
        const unanswered = userAnswers.filter(answer => answer === null).length;

        if (unanswered > 0) {
            if (alert(`You have ${unanswered} unanswered questions. PLease answer them all?`)) {
            //jeffmarker1
                //endQuiz();
            }
        } else {
            endQuiz();
        }
    });

    restartBtn.addEventListener('click', () => {
    submitBtn.style.display = 'none';

    currentQuestionIndex = 0;
    timeLeft = 20 * 60;
    userAnswers = new Array(questions.length).fill(null);

    completionModal.style.display = 'none';
    quizContainer.style.display = 'flex';

    // Reset navigation buttons
    prevBtn.style.visibility = 'hidden';
    prevBtn.style.display = 'inline-block';

    nextBtn.style.visibility = 'visible';
    nextBtn.style.display = 'inline-block';

    shuffleArray(questions);
    displayQuestion();

    quizActive = true;
});


    finishBtn.addEventListener('click', () => {
        endQuizSave();
        //window.location.href = '../Games.php';
    });

   


    // Navigation buttons functionality
    nextBtn.addEventListener('click', () => {

        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            displayQuestion();
        }

        // Hide next button on the last question
        if (currentQuestionIndex === questions.length - 1) {
            nextBtn.style.visibility = 'hidden';
        }
        
        // Show previous button when it's not the first question
        if (currentQuestionIndex > 0) {
            prevBtn.style.visibility = 'visible';
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            displayQuestion();
        }

        // Hide previous button when it's the first question
        if (currentQuestionIndex === 0) {
            prevBtn.style.visibility = 'hidden';
        }

        // Show next button when it's not the last question
        if (currentQuestionIndex < questions.length - 1) {
            nextBtn.style.visibility = 'visible';
        }
    });

// Function to end the quiz, calculate the score, and save it to the database
function endQuizSave() {
    //jeffMarker2
    quizActive = false;
    clearInterval(timer);

    const score = calculateScore();
    const percentage = Math.round((score / questions.length) * 100);

    // Show the completion modal with score
    scoreText.textContent = `You scored ${score} out of ${questions.length} (${percentage}%)`;
    completionModal.style.display = 'flex';

    // Get the subject_id from the first question (assuming all questions are from the same subject)
    const subjectId = questions[0].subjectID;

    // Send the score to the backend to save it in the database
    

    saveScoreToDatabase(score, subjectId);
}

// Function to save the score to the database
function saveScoreToDatabase(score) {
    
    const subjectId = questions[currentQuestionIndex].subjectID; // Get subjectID from the current question

    // Create FormData to send score, subject_id, and user_id
    const formData = new FormData();
    formData.append('score', score);
    formData.append('subject_id', subjectId);
    formData.append('user_id', <?php echo $_SESSION['user_id']; ?>); // Add user_id from session

    // Use fetch API to send data to save_score.php
    fetch('save_score.php', {
        method: 'POST',
        body: formData // Send data as FormData
    })
    .then(response => response.json())  // Parse the JSON response
    .then(data => {
        console.log('Success:', data);
        if (data.status === 'success') {
            showScoreSavedPopup(); // Show success popup if the score is saved
        } else {
            alert('Error: ' + data.message); // Handle error
        }
    })
    .catch(error => {
        console.error('Error:', error);  // Log any error that occurs during the fetch
        alert('An error occurred. Please try again later.'); // Display user-friendly error message
    });
    showScoreSavedPopup(); 

}


// Show the score saved popup and redirect after 3 seconds
function showScoreSavedPopup() {
    const popup = document.createElement('div');
    popup.classList.add('score-saved-popup');
    popup.innerHTML = '<p>Score Saved!</p><button id="okBtn">Okay</button>';
    document.body.appendChild(popup);

    document.getElementById('okBtn').addEventListener('click', () => {
        window.location.href = '../Games.php'; // Redirect to Games.php
    });


    // Automatically close the popup and redirect after 3 seconds
    setTimeout(() => {
        window.location.href = '../Games.php';
    }, 100);
}   

let isQuizInProgress = true; // Set to true while the quiz is active

window.addEventListener('beforeunload', function (e) {
  if (isQuizInProgress) {
    e.preventDefault();
    e.returnValue = ''; // This triggers the browser's default confirmation dialog
  }
});

document.getElementById('submitBtn').addEventListener('click', function () {
  isQuizInProgress = false;
});


    // Initially hide quiz container
    quizContainer.style.display = 'none';
    completionModal.style.display = 'none';


</script>
</body>
</html>