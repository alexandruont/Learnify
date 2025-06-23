<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}

$user_id = $_SESSION["user_id"];

$userQuery = $db->prepare("SELECT * FROM users WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

$courseQuery = $db->prepare("SELECT COUNT(*) as total FROM enrollments WHERE user_id = ?");
$courseQuery->bind_param("i", $user_id);
$courseQuery->execute();
$courseResult = $courseQuery->get_result()->fetch_assoc();
$totalCourses = $courseResult['total'];

$quizQuery = $db->prepare("SELECT COUNT(DISTINCT quiz_id) as total FROM quiz_results WHERE user_id = ?");
$quizQuery->bind_param("i", $user_id);
$quizQuery->execute();
$quizResult = $quizQuery->get_result()->fetch_assoc();
$totalQuizzes = $quizResult['total'];

include 'headerlogged.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Profile | Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background-color: #ECF0F1;">
    <div class="container py-5 pt-5 mt-5">
        <h2 class="text-primary fw-bold mb-4 text-center">Welcome, <?= htmlspecialchars($user['nume']) ?></h2>
        <div class="row justify-content-center text-center mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="text-primary"><?= $totalCourses ?></h5>
                        <p>Courses Enrolled</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="text-primary"><?= $totalQuizzes ?></h5>
                        <p>Quizzes Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="text-primary">Basic Information</h5>
                        <p><strong>Name:</strong> <?= htmlspecialchars($user['nume']) ?></p>
                        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-muted py-4 mt-5 bg-white">
        <small>© 2025 Learnify</small>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>