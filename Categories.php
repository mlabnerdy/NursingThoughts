<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursing Thoughts - Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .category-card {
            transition: transform 0.3s;
        }
        .category-card:hover {
            transform: scale(1.05);
        }
        .card-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <!--Sample-->
        <h1 class="text-center mb-5">Choose Your Learning Mode</h1>
        
        <div class="row justify-content-center g-4">
            <!-- Flashcards -->
            <div class="col-md-4">
                <div class="card category-card text-center h-100">
                    <div class="card-body">
                        <div class="card-icon">📚</div>
                        <h3 class="card-title">Flashcards</h3>
                        <p class="card-text">Review concepts with interactive flashcards</p>
                        <a href="flashcards.php" class="btn btn-primary">Start Learning</a>
                    </div>
                </div>
            </div>

            <!-- Quiz Game -->
            <div class="col-md-4">
                <div class="card category-card text-center h-100">
                    <div class="card-body">
                        <div class="card-icon">❓</div>
                        <h3 class="card-title">Quiz Game</h3>
                        <p class="card-text">Test your knowledge with fun quizzes</p>
                        <a href="quiz.php" class="btn btn-primary">Start Quiz</a>
                    </div>
                </div>
            </div>

            <!-- Guess the Photo -->
            <div class="col-md-4">
                <div class="card category-card text-center h-100">
                    <div class="card-body">
                        <div class="card-icon">🖼️</div>
                        <h3 class="card-title">Guess the Photo</h3>
                        <p class="card-text">Learn through visual identification</p>
                        <a href="guess-photo.php" class="btn btn-primary">Start Game</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>