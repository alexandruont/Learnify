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
        <style>
            .star {
            color: #f1c40f;
            font-size: 1.1rem;
            }
        </style>
    </head>
    <body style="background-color: #ECF0F1;">
        
        <div class="container" style="padding-top: 120px;">
            <h2 class="text-primary fw-bold text-center mb-4">Student Feedback</h2>
            <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">HTML Basics</h5>
                    <p class="mb-1"><strong>Alex Ont</strong></p>
                    <p class="mb-2">Very beginner-friendly and clearly explained!</p>
                    <div class="star">
                    ★★★★☆
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
            <small>© 2025 Learnify</small>
        </footer>

        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
