<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}

include 'headerlogged.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Learnify</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
    </head>
    <body style="background-color: #ECF0F1;">
        
        <div class="container" style="padding-top: 120px;">
            <h2 class="text-primary fw-bold text-center mb-4">Instructor Dashboard</h2>
            <div class="row text-center mb-5">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="text-primary">5</h3>
                            <p>Courses Created</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="text-primary">240</h3>
                            <p>Total Enrollments</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="text-primary">17</h3>
                            <p>New Reviews</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <a href="createCourse.php" class="btn btn-outline-primary w-100">Create New Course</a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="instructorCourse.php" class="btn btn-outline-primary w-100">My Courses</a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="quizDashboard.php" class="btn btn-outline-primary w-100">My Quizzes</a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="viewQuizResults.php" class="btn btn-outline-primary w-100">View Quiz Results</a>
                </div>
            </div>
        </div>
        <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
            <small>© 2025 Learnify</small>
        </footer>

        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
