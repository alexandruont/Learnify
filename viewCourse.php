<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}

if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    die("Invalid course ID.");
}

$course_id = intval($_GET['course_id']);
$query = mysqli_prepare($db, "SELECT * FROM courses WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $course_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    die("Course not found.");
}

$quizStmt = mysqli_prepare($db, "SELECT id FROM quizes WHERE course_id = ?");
mysqli_stmt_bind_param($quizStmt, "i", $course_id);
mysqli_stmt_execute($quizStmt);
$quizResult = mysqli_stmt_get_result($quizStmt);
$quiz = mysqli_fetch_assoc($quizResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($course['title']) ?> | Learnify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #f8f9fa;">
    <?php include 'headerlogged.php'; ?>

    <div class="container py-5 pt-5 mt-5">
        <h2 class="text-center text-primary mb-4 mt-5"><?= htmlspecialchars($course['title']) ?></h2>

        <?php if (!empty($course['pdf_path'])): ?>
            <embed src="<?= htmlspecialchars($course['pdf_path']) ?>" width="100%" height="600px" type="application/pdf">
        <?php else: ?>
            <p class="text-danger text-center">No PDF available for this course.</p>
        <?php endif; ?>

        <?php if ($quiz): ?>
            <div class="text-center mt-4">
                <a href="userQuiz.php?quiz_id=<?= $quiz['id'] ?>" class="btn btn-success">Take the Quiz</a>
            </div>
        <?php else: ?>
            <p class="text-muted text-center mt-4">No quiz available for this course.</p>
        <?php endif; ?>
    </div>

    <footer class="text-center text-muted py-4 bg-white">
        <small>© 2025 Learnify</small>
    </footer>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
