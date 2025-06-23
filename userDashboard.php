<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION["user_id"];

//enroll
if (isset($_POST['enroll']) && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);

    $check = mysqli_query($db, "SELECT * FROM enrollments WHERE user_id = $user_id AND course_id = $course_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($db, "INSERT INTO enrollments (user_id, course_id, enrolled_at) VALUES ($user_id, $course_id, NOW())");
        header("Location: userDashboard.php"); 
        exit;
    }
}

$enrolled_course_ids = [];
$enrolled_query = mysqli_query($db, "SELECT course_id FROM enrollments WHERE user_id = $user_id");
while ($row = mysqli_fetch_assoc($enrolled_query)) {
    $enrolled_course_ids[] = $row["course_id"];
}
$enrolled_ids_str = implode(",", $enrolled_course_ids);

$enrolled_courses = [];
if (!empty($enrolled_course_ids)) {
    $result = mysqli_query($db, "SELECT * FROM courses WHERE id IN ($enrolled_ids_str)");
    while ($row = mysqli_fetch_assoc($result)) {
        $enrolled_courses[] = $row;
    }
}

$available_courses = [];
$query = empty($enrolled_ids_str)
    ? "SELECT * FROM courses"
    : "SELECT * FROM courses WHERE id NOT IN ($enrolled_ids_str)";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $available_courses[] = $row;
}

include 'headerlogged.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background-color: #ECF0F1;">
    <div style="padding-top: 100px;" class="container">
        <div class="text-center mb-5">
            <h2 class="text-primary fw-bold">Welcome back, <?= htmlspecialchars($_SESSION["name"] ?? 'Student') ?>!</h2>
            <p class="lead">Here's your Learnify dashboard overview.</p>
        </div>

        <h4 class="text-primary mb-3" id="Courses">Your Courses</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            <?php if (empty($enrolled_courses)): ?>
                <p class="text-muted">You are not enrolled in any courses yet.</p>
            <?php else: ?>
                <?php foreach ($enrolled_courses as $course): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= htmlspecialchars($course['thumbnail'] ?? 'placeholder.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                                <a href="viewCourse.php?course_id=<?= $course['id'] ?>" class="btn btn-primary btn-sm mt-auto">Continue</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h4 class="text-primary mb-3">Browse Courses</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            <?php if (empty($available_courses)): ?>
                <p class="text-muted">No new courses available.</p>
            <?php else: ?>
                <?php foreach ($available_courses as $course): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= htmlspecialchars($course['thumbnail'] ?? 'placeholder.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                                <form method="post" action="">
                                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                    <button type="submit" name="enroll" class="btn btn-outline-success btn-sm mt-auto">Enroll</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer class="text-center text-muted py-4" style="background-color: #ffffff;">
        <small>© 2025 Learnify</small>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
