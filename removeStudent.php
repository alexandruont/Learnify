<?php
require_once("connection.php");
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = intval($_POST['user_id']);
    $course_id = intval($_POST['course_id']);

    $stmt = $db->prepare("DELETE FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();

    header("Location: enrollments.php?course_id=" . $course_id);
    exit;
}

// remove student from enrollment !!!!