<?php
require_once("connection.php");
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = intval($_POST['user_id']);
    $course_id = intval($_POST['course_id']);

    $check = $db->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
    $check->bind_param("ii", $user_id, $course_id);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;

    if (!$exists) {
        $stmt = $db->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $course_id);
        $stmt->execute();
    }
    header("Location: enrollments.php?course_id=" . $course_id);
    exit;
}
