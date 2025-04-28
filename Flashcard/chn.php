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
  <title>Nursing Flashcards</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../nav.css" />
    <link rel="stylesheet" href="flashcard.css" />
    <style>
      /* Add space between Shuffle button and Exit button */
.shuffle-btn {
  margin-bottom: 20px; /* Adds space below the Shuffle Cards button */
}

.exit-btn {
  margin-top: 20px; /* Adds space above the Exit button */
}

    </style>
</head>
<body>
  <!-- Welcome Modal -->
  <div class="welcome-modal" id="welcomeModal">
    <div class="welcome-content">
      <div class="welcome-title">FLASHCARDS</div>
      <div class="welcome-subtitle">Welcome to Nursing Thoughts Quiz Game</div>
      <div class="welcome-text">
        Flashcards offer a quick, interactive way to reinforce<br>
        nursing concepts through active recall. Review key terms<br>
        and definitions at your own pace, enhancing retention.
      </div>
      <button class="start-btn" id="startBtn">Start</button>
    </div>
  </div>

  <!-- Completion Modal -->
  <div class="completion-modal" id="completionModal">
    <div class="completion-content">
      <div class="completion-title">Quiz Completed!</div>
      <div class="completion-text">
        You've finished all the flashcards. Would you like to restart the quiz or finish?
      </div>
      <div class="completion-buttons">
        <button class="completion-btn restart-btn" id="restartBtn">Restart</button>
        <button class="completion-btn finish-btn" id="finishBtn">Finish</button>
      </div>
    </div>
  </div>

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

  <!-- Main Content -->
<div class="main-content">
  <div class="container flashcard-container">
    <div class="flashcard-header">
      <h1 class="mb-3"><i class="bi bi-book"></i> FLASHCARDS</h1>
      <p class="lead">Click the card to flip or wait for auto-flip</p>
    </div>
    
    <div class="progress-indicator">
      Card <span id="current-card">1</span> of <span id="total-cards">10</span>
    </div>
    
    <div class="flashcard" id="flashcard">
      <div class="flashcard-inner">
        <div class="flashcard-front">
          <i class="bi bi-book book-icon"></i>
          <div class="flashcard-title">Question</div>
          <div class="flashcard-content" id="question-content">
            Loading question...
          </div>
          <div class="flashcard-hint">Click to reveal answer</div>
        </div>
        <div class="flashcard-back">
          <div class="flashcard-title">Answer</div>
          <div class="flashcard-content" id="answer-content">
            Loading answer...
          </div>
          <div class="flashcard-hint">Click to return to question</div>
        </div>
      </div>
    </div>
    
    <div class="timer-container">
      <div class="timer-progress" id="timer"></div>
    </div>
    
    <div class="flashcard-controls">
      <button class="btn btn-outline-primary" id="prev-btn" disabled>
        <i class="bi bi-arrow-left"></i> Previous
      </button>
      <button class="btn btn-outline-primary" id="next-btn">
        Next <i class="bi bi-arrow-right"></i>
      </button>
    </div>
    
    <button class="btn btn-secondary shuffle-btn" id="shuffle-btn">
      <i class="bi bi-shuffle"></i> Shuffle Cards
    </button>

    <!-- Exit Button -->
<a href="../Games.php" class="btn btn-danger exit-btn" id="exitBtn">
  <i class="bi bi-x-circle"></i> Exit
</a>
  </div>
</div>


    <!-- Footer -->
    <footer class="footer">
      <div>@NursingThoughts</div>
      <a href="../aboutus.php">About Us</a>
    </footer>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const flashcard = document.getElementById('flashcard');
      const timer = document.getElementById('timer');
      const questionContent = document.getElementById('question-content');
      const answerContent = document.getElementById('answer-content');
      const prevBtn = document.getElementById('prev-btn');
      const nextBtn = document.getElementById('next-btn');
      const currentCardEl = document.getElementById('current-card');
      const totalCardsEl = document.getElementById('total-cards');
      const shuffleBtn = document.getElementById('shuffle-btn');
      const welcomeModal = document.getElementById('welcomeModal');
      const startBtn = document.getElementById('startBtn');
      const completionModal = document.getElementById('completionModal');
      const restartBtn = document.getElementById('restartBtn');
      const finishBtn = document.getElementById('finishBtn');
      
      // Original flashcard data
      const originalFlashcards = [
        {
            question: "What is the primary goal of community health nursing?",
            answer: "To promote and preserve the health of the population."
        },
        {
            question: "Which level of prevention involves immunization?",
            answer: "Primary prevention."
        },
        {
            question: "What is the most important tool used by a community health nurse?",
            answer: "Bag technique."
        },
        {
            question: "What is the standard treatment protocol for TB under the DOTS program?",
            answer: "Directly Observed Treatment, Short-course."
        },
        {
            question: "What is the first step in community health nursing process?",
            answer: "Assessment."
        },
        {
            question: "What is the population covered by one Barangay Health Station (BHS)?",
            answer: "5,000 people."
        },
        {
            question: "What is the ideal ratio of public health nurse to population?",
            answer: "1:20,000."
        },
        {
            question: "What is the main role of the barangay health worker (BHW)?",
            answer: "Provide basic health care and link between community and health services."
        },
        {
            question: "What is epidemiology primarily concerned with?",
            answer: "Study of the distribution and determinants of health conditions."
        },
        {
            question: "What is the cold chain system used for in CHN?",
            answer: "Maintaining vaccine potency."
        },
        {
            question: "Which law institutionalized the Barangay Health Worker program in the Philippines?",
            answer: "R.A. 7883."
        },
        {
            question: "What is the focus of family health nursing?",
            answer: "Health of the family as a unit."
        },
        {
            question: "What is the most effective method of health teaching in communities?",
            answer: "Demonstration"
        },
        {
            question: "What is the priority in a community during disaster response?",
            answer: "Safety and survival of the affected population."
        },
        {
            question: "Which component of Primary Health Care promotes community involvement?",
            answer: "Community participation."
        }
            ];

      let flashcards = [...originalFlashcards];
      let currentCardIndex = 0;
      let timerInterval;
      let countdown = 10; // 10 seconds for question
      let answerTimer;
      let isFlipped = false;
      let isActive = false; // To track if quiz has started
      
      // Initialize (but don't start timer yet)
      shuffleCards();
      totalCardsEl.textContent = flashcards.length;
      loadCard(currentCardIndex, false); // Don't start timer yet
      
      // Show welcome modal on load
      welcomeModal.style.display = 'flex';
      
      // Function to shuffle cards
      function shuffleCards() {
        // Fisher-Yates shuffle algorithm
        for (let i = flashcards.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [flashcards[i], flashcards[j]] = [flashcards[j], flashcards[i]];
        }
        currentCardIndex = 0;
      }
      
      // Function to load a card
      function loadCard(index, startTimerImmediately = true) {
        // Clear any existing timers
        clearInterval(timerInterval);
        clearTimeout(answerTimer);
        
        currentCardIndex = index;
        const card = flashcards[index];
        questionContent.textContent = card.question;
        answerContent.textContent = card.answer;
        currentCardEl.textContent = index + 1;
        
        // Reset card to front
        flashcard.classList.remove('flipped');
        isFlipped = false;
        
        // Update button states
        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === flashcards.length - 1;
        
        // Reset timer only if quiz is active
        if (isActive && startTimerImmediately) {
          resetTimer();
        } else {
          // If not active, just show full timer bar
          countdown = 10;
          updateTimerDisplay();
        }
      }
      
      // Function to flip the card
      function flipCard() {
        if (!isActive) return; // Don't allow flipping before quiz starts
        
        flashcard.classList.toggle('flipped');
        isFlipped = !isFlipped;
        
        if (isFlipped) {
          // If we just flipped to show the answer, start the 5-second timer to go to next card
          clearInterval(timerInterval);
          countdown = 5;
          updateTimerDisplay();
          
          answerTimer = setTimeout(() => {
            if (currentCardIndex < flashcards.length - 1) {
              loadCard(currentCardIndex + 1);
            } else {
              // If it's the last card, show completion modal
              showCompletionModal();
            }
          }, 5000);
        } else {
          // If we flipped back to question, restart the question timer
          resetTimer();
        }
      }
      
      // Function to reset the timer
      function resetTimer() {
        clearInterval(timerInterval);
        clearTimeout(answerTimer);
        countdown = 10;
        updateTimerDisplay();
        startTimer();
      }
      
      // Function to update timer display
      function updateTimerDisplay() {
        const maxTime = isFlipped ? 5 : 10;
        const percentage = (countdown / maxTime) * 100;
        timer.style.width = `${percentage}%`;
        
        // Change color when time is running out
        if (countdown <= (maxTime * 0.3)) { // 30% of time remaining
          timer.style.backgroundColor = '#dc3545'; // red
        } else {
          timer.style.backgroundColor = '#f57c00'; // orange
        }
      }
      
      // Function to start the timer
      function startTimer() {
        const maxTime = isFlipped ? 5 : 10;
        
        timerInterval = setInterval(function() {
          countdown -= 0.1;
          updateTimerDisplay();
          
          if (countdown <= 0) {
            clearInterval(timerInterval);
            if (!isFlipped) {
              flipCard();
            } else if (currentCardIndex < flashcards.length - 1) {
              loadCard(currentCardIndex + 1);
            } else {
              // Last card - show completion modal
              showCompletionModal();
            }
          }
        }, 100);
      }
      
      // Function to show completion modal
      function showCompletionModal() {
        completionModal.style.display = 'flex';
      }
      
      // Start button click handler
      startBtn.addEventListener('click', function() {
        welcomeModal.style.display = 'none';
        isActive = true;
        resetTimer(); // Start the timer
      });
      
      // Restart button click handler
      restartBtn.addEventListener('click', function() {
        completionModal.style.display = 'none';
        shuffleCards();
        loadCard(0);
      });
      
      // Finish button click handler
      finishBtn.addEventListener('click', function() {
        window.location.href = '../Homepage.php';
      });
      
      // Event listeners
      flashcard.addEventListener('click', flipCard);
      
      prevBtn.addEventListener('click', function() {
        if (currentCardIndex > 0) {
          loadCard(currentCardIndex - 1);
        }
      });
      
      nextBtn.addEventListener('click', function() {
        if (currentCardIndex < flashcards.length - 1) {
          loadCard(currentCardIndex + 1);
        } else {
          showCompletionModal();
        }
      });
      
      shuffleBtn.addEventListener('click', function() {
        shuffleCards();
        loadCard(0);
      });
      
      // Keyboard navigation
      document.addEventListener('keydown', function(e) {
        if (!isActive) return; // Don't respond to keys before quiz starts
        
        if (e.key === 'ArrowLeft' && currentCardIndex > 0) {
          loadCard(currentCardIndex - 1);
        } else if (e.key === 'ArrowRight' && currentCardIndex < flashcards.length - 1) {
          loadCard(currentCardIndex + 1);
        } else if (e.key === ' ' || e.key === 'Spacebar') {
          flipCard();
        }
      });
    });

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


  </script>
</body>
</html>