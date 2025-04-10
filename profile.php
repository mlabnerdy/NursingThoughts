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
        body {
            background-color:rgb(231, 215, 194);
        }
        .profile-section {
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        /* Color scheme */
        .btn-orange {
            background-color: #f39c12;
            color: white;
        }
        .btn-orange:hover {
            background-color: #e67e22;
        }
        .accordion-button.collapsed {
            background-color: #f39c12;
            color: white;
        }
        .accordion-button.collapsed:hover {
            background-color: #e67e22;
        }
        .accordion-body {
            background-color: #f9f9f9;
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
                            <!-- Nutrition and Diet Therapy -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="nutritionHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nutritionCollapse">
                                        Nutrition and Diet Therapy
                                        <span class="badge bg-primary ms-auto">85</span>
                                    </button>
                                </h2>
                                <div id="nutritionCollapse" class="accordion-collapse collapse" data-bs-parent="#subjectAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Quiz Game</span>
                                                <span class="badge bg-info">90/100</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Flashcard</span>
                                                <span class="badge bg-info">80/100</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Anatomy and Physiology -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="anatomyHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#anatomyCollapse">
                                        Anatomy and Physiology
                                        <span class="badge bg-primary ms-auto">92</span>
                                    </button>
                                </h2>
                                <div id="anatomyCollapse" class="accordion-collapse collapse" data-bs-parent="#subjectAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Quiz Game</span>
                                                <span class="badge bg-info">95/100</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Flashcard</span>
                                                <span class="badge bg-info">90/100</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Add more subjects in similar fashion -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data for the performance pie chart
        const data = {
            labels: [
                'Nutrition and Diet Therapy',
                'Anatomy and Physiology',
                'Community Health Nursing',
                'Fundamentals of Nursing',
                'Pharmacology',
                'Maternal and Child Nursing',
                'Health Assessment',
                'Bio-Ethics',
                'Medical Terminologies',
                'RABE',
                'Theoretical Foundation of Nursing'
                'Medical tools and Equipment'
            ],
            datasets: [{
                data: [85, 92, 78, 80, 89, 91, 86, 75, 88, 83, 77], // Sample performance data for each subject
                backgroundColor: [
                    '#FF5733', '#FF8D1A', '#FFC300', '#FFB400', '#FF6F00', '#D35400',
                    '#F39C12', '#E67E22', '#F39C12', '#F0A500', '#F39C12'
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
