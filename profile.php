<?php
session_start();
// Add your database connection here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .profile-section {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .scores-card {
            height: 600px;
            overflow-y: auto;
        }
        .accordion-button {
    display: flex;
    justify-content: space-between;
    align-items: center;
        }

        .accordion-button .badge {
            margin-left: 10px;
        }

        .scores-card {
            height: 600px;
            overflow-y: auto;
        }

        .list-group-item {
            border: none;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <!-- User Details Section -->
            <div class="col-md-8">
                <div class="profile-section">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="default-avatar.png" class="img-fluid rounded-circle" alt="Profile Picture">
                        </div>
                        <div class="col-md-8">
                            <h2>Student Name</h2>
                            <p>Student ID: 12345</p>
                            <p>Course: Bachelor of Science in Nursing</p>
                            <p>Year Level: 3rd Year</p>
                        </div>
                    </div>
                </div>
                
                <!-- Graph Section -->
                <div class="profile-section">
                    <h3>Performance Overview</h3>
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
<!-- Scores Section -->
<div class="col-md-4">
    <div class="card scores-card">
        <div class="card-header">
            <h3>Subject Scores</h3>
        </div>
        <div class="card-body">
            <div class="accordion" id="subjectAccordion">
                <!-- Anatomy -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="anatomyHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#anatomyCollapse">
                            Anatomy
                            <span class="badge bg-primary ms-auto">95</span>
                        </button>
                    </h2>
                    <div id="anatomyCollapse" class="accordion-collapse collapse" data-bs-parent="#subjectAccordion">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Quiz Game</span>
                                    <span class="badge bg-info">98/100</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Flashcard</span>
                                    <span class="badge bg-info">92/100</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Guess the Photo</span>
                                    <span class="badge bg-info">95/100</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Physiology -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="physiologyHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#physiologyCollapse">
                            Physiology
                            <span class="badge bg-primary ms-auto">88</span>
                        </button>
                    </h2>
                    <div id="physiologyCollapse" class="accordion-collapse collapse" data-bs-parent="#subjectAccordion">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Quiz Game</span>
                                    <span class="badge bg-info">85/100</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Flashcard</span>
                                    <span class="badge bg-info">90/100</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Guess the Photo</span>
                                    <span class="badge bg-info">89/100</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Add more subjects following the same pattern -->

            </div>
        </div>
    </div>
</div>

    <script>
    // Sample data for the pie chart
const data = {
    labels: [
        'Quiz Game',
        'Flashcard',
        'Guess the Photo'
    ],
    datasets: [{
        data: [
            // Average scores for each category across all subjects
            90, // Quiz Game average
            85, // Flashcard average
            88  // Guess the Photo average
        ],
        backgroundColor: [
            '#FF6384',
            '#36A2EB',
            '#FFCE56'
        ]
    }]
};

// Create the pie chart
const ctx = document.getElementById('performanceChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.raw}%`;
                    }
                }
            }
        }
    }
});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>