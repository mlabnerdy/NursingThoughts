<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nursing Quiz Game</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../nav.css" />
  <link rel="stylesheet" href="quiz.css" />
</head>
<body>
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

  <!-- Completion Modal -->
  <div class="completion-modal" id="completionModal">
    <div class="completion-content">
      <div class="completion-title">Quiz Completed!</div>
      <div class="completion-text">
        You scored <span id="score">0</span> out of <span id="total-questions">0</span> correctly!
      </div>
      <div class="completion-buttons">
        <button class="completion-btn restart-btn" id="restartBtn">Restart Quiz</button>
        <button class="completion-btn finish-btn" id="finishBtn">Finish</button>
      </div>
    </div>
  </div>

  <div class="wrapper">
    <!-- Navbar -->
    <nav class="navbar sticky-top d-flex justify-content-between align-items-center px-3">
      <div class="nav-avatar"></div>
      <div class="d-flex gap-4">
        <a class="nav-link active" href="../Homepage.php">Home</a>
        <a class="nav-link" href="../Games.php">Games</a>
        <a class="nav-link" href="../Leaderboard.php">Leaderboard</a>
      </div>
      <div class="nav-profile">
        <i class="bi bi-person-fill"></i>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
      <div class="container quiz-container">
        <div class="quiz-header">
          <h1 class="mb-2"><i class="bi bi-question-circle"></i> NURSING QUIZ</h1>
          <div class="quiz-instruction mb-2">Select the correct answer</div>
          <div class="score-display mb-3">Score: <span id="current-score">0</span></div>
        </div>
        
        <div class="progress-indicator">
          Question <span id="current-question">1</span> of <span id="total-questions">15</span>
        </div>
        
        <div class="quiz-card" id="quizCard">
          <div class="quiz-question" id="question-content">
            Loading question...
          </div>
          <div class="quiz-options">
            <button class="quiz-option" id="option1" data-option="1"></button>
            <button class="quiz-option" id="option2" data-option="2"></button>
            <button class="quiz-option" id="option3" data-option="3"></button>
            <button class="quiz-option" id="option4" data-option="4"></button>
          </div>
        </div>
        
        <div class="timer-container">
          <div class="timer-progress" id="timer"></div>
        </div>
        
        <div class="quiz-controls">
          <button class="btn btn-outline-primary" id="prev-btn" disabled>
            <i class="bi bi-arrow-left"></i> Previous
          </button>
          <button class="btn btn-outline-primary" id="next-btn">
            Next <i class="bi bi-arrow-right"></i>
          </button>
        </div>
        
        <button class="btn btn-secondary shuffle-btn" id="shuffle-btn">
          <i class="bi bi-shuffle"></i> Shuffle Questions
        </button>
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
    document.addEventListener('DOMContentLoaded', function() {
      const quizCard = document.getElementById('quizCard');
      const timer = document.getElementById('timer');
      const questionContent = document.getElementById('question-content');
      const optionButtons = [
        document.getElementById('option1'),
        document.getElementById('option2'),
        document.getElementById('option3'),
        document.getElementById('option4')
      ];
      const prevBtn = document.getElementById('prev-btn');
      const nextBtn = document.getElementById('next-btn');
      const currentQuestionEl = document.getElementById('current-question');
      const totalQuestionsEl = document.getElementById('total-questions');
      const currentScoreEl = document.getElementById('current-score');
      const shuffleBtn = document.getElementById('shuffle-btn');
      const welcomeModal = document.getElementById('welcomeModal');
      const startBtn = document.getElementById('startBtn');
      const completionModal = document.getElementById('completionModal');
      const restartBtn = document.getElementById('restartBtn');
      const finishBtn = document.getElementById('finishBtn');
      const scoreDisplay = document.getElementById('score');
      const totalQuestionsDisplay = document.getElementById('total-questions');
      
      // Quiz data with questions, correct answer, and distractors
      const originalQuestions = [
        {
    question: "Which nutrient is the primary source of energy for the body?",
    correctAnswer: "B. Carbohydrate",
    distractors: ["A. Protein", "C. Fat", "D. Vitamins"]
  },
  {
    question: "Which vitamin is essential for calcium absorption?",
    correctAnswer: "C. Vitamin D",
    distractors: ["A. Vitamin A", "B. Vitamin C", "D. Vitamin E"]
  },
  {
    question: "Which of the following is a complete protein source?",
    correctAnswer: "C. Chicken",
    distractors: ["A. Rice", "B. Beans", "D. Corn"]
  },
  {
    question: "Which mineral is most important in maintaining fluid balance in the body?",
    correctAnswer: "C. Potassium",
    distractors: ["A. Iron", "B. Zinc", "D. Magnesium"]
  },
  {
    question: "What is the recommended dietary approach for managing hypertension?",
    correctAnswer: "B. DASH diet",
    distractors: ["A. Paleo diet", "C. Keto diet", "D. Atkins diet"]
  },
  {
    question: "Which condition results from a severe deficiency of vitamin C?",
    correctAnswer: "C. Scurvy",
    distractors: ["A. Pellagra", "B. Rickets", "D. Beriberi"]
  },
  {
    question: "What type of fat is considered most heart-healthy?",
    correctAnswer: "C. Polyunsaturated fat",
    distractors: ["A. Saturated fat", "B. Trans fat", "D. Hydrogenated fat"]
  },
  {
    question: "Which of the following diets is typically recommended for patients with chronic kidney disease?",
    correctAnswer: "B. Low sodium and low protein",
    distractors: ["A. High protein", "C. High carbohydrate", "D. High calcium"]
  },
  {
    question: "Which nutrient is most important for wound healing?",
    correctAnswer: "D. Vitamin C",
    distractors: ["A. Vitamin D", "B. Vitamin A", "C. Vitamin K"]
  },
  {
    question: "What condition is commonly associated with excessive alcohol intake and thiamine deficiency?",
    correctAnswer: "B. Wernicke-Korsakoff syndrome",
    distractors: ["A. Marasmus", "C. Scurvy", "D. Anemia"]
  },
  {
    question: "Protein is the body's primary source of energy.",
    correctAnswer: "FALSE",
    distractors: ["TRUE"]
  },
  {
    question: "Vitamin K is essential for proper blood clotting.",
    correctAnswer: "TRUE",
    distractors: ["FALSE"]
  },
  {
    question: "Trans fats are considered healthy and should be included in the diet.",
    correctAnswer: "FALSE",
    distractors: ["TRUE"]
  },
  {
    question: "Iron is necessary for the formation of red blood cells.",
    correctAnswer: "TRUE",
    distractors: ["FALSE"]
  },
  {
    question: "A high-fiber diet can help prevent constipation.",
    correctAnswer: "TRUE",
    distractors: ["FALSE"]
  }
      ];
      
      let questions = [...originalQuestions];
      let currentQuestionIndex = 0;
      let timerInterval;
      let countdown = 15; // 15 seconds per question
      let score = 0;
      let selectedOption = null;
      let isActive = false; // To track if quiz has started
      let userAnswers = []; // Track user's answers for each question
      
      // Initialize (but don't start timer yet)
      shuffleQuestions();
      totalQuestionsEl.textContent = questions.length;
      loadQuestion(currentQuestionIndex, false); // Don't start timer yet
      
      // Show welcome modal on load
      welcomeModal.style.display = 'flex';
      
      // Function to shuffle questions
      function shuffleQuestions() {
        // Fisher-Yates shuffle algorithm
        for (let i = questions.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [questions[i], questions[j]] = [questions[j], questions[i]];
        }
        currentQuestionIndex = 0;
        score = 0;
        userAnswers = new Array(questions.length).fill(null);
        currentScoreEl.textContent = score;
      }
      
      // Function to load a question
      function loadQuestion(index, startTimerImmediately = true) {
        // Clear any existing timers
        clearInterval(timerInterval);
        
        currentQuestionIndex = index;
        const question = questions[index];
        questionContent.textContent = question.question;
        currentQuestionEl.textContent = index + 1;
        
        // Generate answer options (correct answer + distractors)
        const options = [question.correctAnswer, ...question.distractors];
        
        // Shuffle the options
        for (let i = options.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [options[i], options[j]] = [options[j], options[i]];
        }
        
        // Assign options to buttons
        optionButtons.forEach((btn, i) => {
          btn.textContent = options[i];
          btn.dataset.value = options[i];
          
          // Reset button styles
          btn.classList.remove('correct', 'incorrect', 'selected');
          btn.disabled = false;
        });
        
        // Update button states
        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === questions.length - 1;
        
        // Highlight previously selected answer if exists
        if (userAnswers[index] !== null) {
          const selectedBtn = optionButtons.find(
            btn => btn.dataset.value === userAnswers[index].selectedAnswer
          );
          if (selectedBtn) {
            selectedBtn.classList.add('selected');
            if (userAnswers[index].isCorrect) {
              selectedBtn.classList.add('correct');
            } else {
              selectedBtn.classList.add('incorrect');
              // Also show correct answer
              const correctBtn = optionButtons.find(
                btn => btn.dataset.value === questions[index].correctAnswer
              );
              if (correctBtn) correctBtn.classList.add('correct');
            }
          }
          // Disable all options after selection
          optionButtons.forEach(btn => btn.disabled = true);
        }
        
        // Reset timer only if quiz is active
        if (isActive && startTimerImmediately) {
          resetTimer();
        } else {
          // If not active, just show full timer bar
          countdown = 15;
          updateTimerDisplay();
        }
      }
      
      // Function to check answer
      function checkAnswer(selectedButton) {
        if (!isActive) return; // Don't allow answering before quiz starts
        
        const selectedAnswer = selectedButton.dataset.value;
        const currentQuestion = questions[currentQuestionIndex];
        const isCorrect = selectedAnswer === currentQuestion.correctAnswer;
        
        // Store user's answer
        userAnswers[currentQuestionIndex] = {
          selectedAnswer,
          isCorrect
        };
        
        // Update score if correct
        if (isCorrect && !selectedButton.classList.contains('selected')) {
          score++;
          currentScoreEl.textContent = score;
        }
        
        // Highlight selected answer
        selectedButton.classList.add('selected');
        
        if (isCorrect) {
          selectedButton.classList.add('correct');
        } else {
          selectedButton.classList.add('incorrect');
          // Also show correct answer
          const correctButton = optionButtons.find(
            btn => btn.dataset.value === currentQuestion.correctAnswer
          );
          if (correctButton) correctButton.classList.add('correct');
        }
        
        // Disable all options after selection
        optionButtons.forEach(btn => btn.disabled = true);
        
        // Stop the timer
        clearInterval(timerInterval);
        
        // Auto-advance to next question after 1 second
        setTimeout(() => {
          if (currentQuestionIndex < questions.length - 1) {
            loadQuestion(currentQuestionIndex + 1);
          } else {
            // If it's the last question, show completion modal
            showCompletionModal();
          }
        }, 1000);
      }
      
      // Function to reset the timer
      function resetTimer() {
        clearInterval(timerInterval);
        countdown = 15;
        updateTimerDisplay();
        startTimer();
      }
      
      // Function to update timer display
      function updateTimerDisplay() {
        const percentage = (countdown / 15) * 100;
        timer.style.width = `${percentage}%`;
        
        // Change color when time is running out
        if (countdown <= 5) { // 5 seconds or less
          timer.style.backgroundColor = '#dc3545'; // red
        } else {
          timer.style.backgroundColor = '#f57c00'; // orange
        }
      }
      
      // Function to start the timer
      function startTimer() {
        timerInterval = setInterval(function() {
          countdown -= 0.1;
          updateTimerDisplay();
          
          if (countdown <= 0) {
            clearInterval(timerInterval);
            // Time's up - mark as incorrect if not answered
            if (userAnswers[currentQuestionIndex] === null) {
              const currentQuestion = questions[currentQuestionIndex];
              userAnswers[currentQuestionIndex] = {
                selectedAnswer: null,
                isCorrect: false
              };
              
              // Show correct answer
              const correctButton = optionButtons.find(
                btn => btn.dataset.value === currentQuestion.correctAnswer
              );
              if (correctButton) correctButton.classList.add('correct');
              
              // Disable all options
              optionButtons.forEach(btn => btn.disabled = true);
            }
            
            // Auto-advance to next question after 1 second
            setTimeout(() => {
              if (currentQuestionIndex < questions.length - 1) {
                loadQuestion(currentQuestionIndex + 1);
              } else {
                // Last question - show completion modal
                showCompletionModal();
              }
            }, 1000);
          }
        }, 100);
      }
      
      // Function to show completion modal
      function showCompletionModal() {
        scoreDisplay.textContent = score;
        totalQuestionsDisplay.textContent = questions.length;
        completionModal.style.display = 'flex';

            // Save score in the database
            const userId = 1; // Example user_id, replace with actual user ID
            const subjectId = 1; // Assuming subject_id is 1
            saveScore(userId, subjectId, score);
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
        shuffleQuestions();
        loadQuestion(0);
      });
      
      // Finish button click handler
      finishBtn.addEventListener('click', function() {
        window.location.href = '../Homepage.php';
      });
      
      // Event listeners for option buttons
      optionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
          if (userAnswers[currentQuestionIndex] === null) {
            checkAnswer(btn);
          }
        });
      });
      
      prevBtn.addEventListener('click', function() {
        if (currentQuestionIndex > 0) {
          loadQuestion(currentQuestionIndex - 1);
        }
      });
      
      nextBtn.addEventListener('click', function() {
        if (currentQuestionIndex < questions.length - 1) {
          loadQuestion(currentQuestionIndex + 1);
        } else {
          showCompletionModal();
        }
      });
      
      shuffleBtn.addEventListener('click', function() {
        shuffleQuestions();
        loadQuestion(0);
      });
      
      // Keyboard navigation
      document.addEventListener('keydown', function(e) {
        if (!isActive) return; // Don't respond to keys before quiz starts
        
        if (e.key === 'ArrowLeft' && currentQuestionIndex > 0) {
          loadQuestion(currentQuestionIndex - 1);
        } else if (e.key === 'ArrowRight' && currentQuestionIndex < questions.length - 1) {
          loadQuestion(currentQuestionIndex + 1);
        } else if (e.key >= '1' && e.key <= '4' && userAnswers[currentQuestionIndex] === null) {
          // Allow selecting options with 1-4 keys
          const optionIndex = parseInt(e.key) - 1;
          if (optionIndex >= 0 && optionIndex < optionButtons.length) {
            checkAnswer(optionButtons[optionIndex]);
          }
        }
      });
    });

    function saveScore(userId, subjectId, score) {
    fetch('save_score.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_id: userId, subject_id: subjectId, score: score })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Score saved successfully');
        } else {
            console.log('Failed to save score');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
  </script>
</body>
</html>