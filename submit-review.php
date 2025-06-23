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
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Learnify</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            .stars input {
            display: none;
            }

            .stars label {
            float: right;
            font-size: 2rem;
            color: #ccc;
            padding: 0 5px;
            cursor: pointer;
            transition: color 0.2s;
            }

            .stars input:checked ~ label,
            .stars label:hover,
            .stars label:hover ~ label {
            color: #f1c40f;
            }
        </style>
    </head>
    <body style="background-color: #ECF0F1;">
        
        <div class="container" style="padding-top: 120px;">
            <h2 class="text-primary fw-bold text-center mb-4">Leave a Course Review</h2>
            <form class="col-md-8 offset-md-2">
            <div class="mb-3">
                <label for="courseSelect" class="form-label">Select Course:</label>
                <select class="form-select" id="courseSelect" required>
                <option selected disabled value="">Choose a course</option>
                <option value="html">Intro to HTML</option>
                <option value="js">JavaScript Essentials</option>
                <option value="css">Intro to CSS</option>
                </select>
            </div>
            <div class="mb-3 pb-5">
                <label for="reviewMessage" class="form-label">Your Review:</label>
                <textarea class="form-control" id="reviewMessage" rows="4" placeholder="Share your thoughts..." required></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-5 pb-5 flex-wrap gap-3">
                <button type="submit" class="btn btn-primary">Submit Review</button>
                <div>
                    <label class="form-label mb-1">Your Rating:</label>
                    <div class="stars d-inline-block align-middle">
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5">&#9733;</label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4">&#9733;</label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3">&#9733;</label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2">&#9733;</label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1">&#9733;</label>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
            <small>© 2025 Learnify</small>
        </footer>

        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
