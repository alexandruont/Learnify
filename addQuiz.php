<?php
require_once("connection.php");
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $course_id = intval($_POST["course_id"]);
    $points = intval($_POST["points"]);

    if (!empty($title) && $course_id > 0 && $points > 0) {
        $stmt = mysqli_prepare($db, "INSERT INTO quizes (course_id, title, description, points, created_at) VALUES (?, ?, ?, ?, NOW())");
        mysqli_stmt_bind_param($stmt, "issi", $course_id, $title, $description, $points);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: quizDashboard.php?added=1");
            exit;
        } else {
            $error = "Database error: " . mysqli_error($db);
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "All fields are required and points must be greater than 0.";
    }
}

//get courses to assign quiz to
$course_query = mysqli_query($db, "SELECT id, title FROM courses ORDER BY title ASC");
$courses = [];
while ($row = mysqli_fetch_assoc($course_query)) {
    $courses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Quiz | Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body style="background-color: #ECF0F1;">
<?php include 'headerlogged.php'; ?>

<div class="container" style="padding-top: 120px; max-width: 600px;">
    <h2 class="text-primary text-center mb-4">Create New Quiz</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="addQuiz.php">
        <div class="mb-3">
            <label for="title" class="form-label">Quiz Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Quiz Description (optional)</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Points</label>
            <input type="number" name="points" id="points" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label for="course_id" class="form-label">Assign to Course</label>
            <select name="course_id" id="course_id" class="form-select" required>
                <option value="" disabled selected>Select a course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Add Quiz</button>
            <a href="quizDashboard.php" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>

<footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
    <small>© 2025 Learnify</small>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
