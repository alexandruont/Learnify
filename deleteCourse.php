<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $course_id = intval($_POST['id']);

    $quiz_ids = [];
    $quiz_result = mysqli_query($db, "SELECT id FROM quizes WHERE course_id = $course_id");
    while ($row = mysqli_fetch_assoc($quiz_result)) {
        $quiz_ids[] = $row['id'];
    }

    foreach ($quiz_ids as $quiz_id) {
        $stmt = mysqli_prepare($db, "DELETE FROM quiz_questions WHERE quiz_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $quiz_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $stmt2 = mysqli_prepare($db, "DELETE FROM quizes WHERE course_id = ?");
    mysqli_stmt_bind_param($stmt2, "i", $course_id);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    $stmt3 = mysqli_prepare($db, "DELETE FROM enrollments WHERE course_id = ?");
    mysqli_stmt_bind_param($stmt3, "i", $course_id);
    mysqli_stmt_execute($stmt3);
    mysqli_stmt_close($stmt3);

    $stmt4 = mysqli_prepare($db, "DELETE FROM courses WHERE id = ?");
    mysqli_stmt_bind_param($stmt4, "i", $course_id);
    mysqli_stmt_execute($stmt4);
    mysqli_stmt_close($stmt4);

    header("Location: instructorCourse.php");
    exit();
}
?>
