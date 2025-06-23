<?php
require_once("connection.php");

if (!isset($_POST['id'])) {
    die("Missing course ID.");
}

$courseId = intval($_POST['id']);

$stmt = $db->prepare("DELETE FROM courses WHERE id = ?");
$stmt->bind_param("i", $courseId);

if ($stmt->execute()) {
    header("Location: adminCourses.php");
    exit;
} else {
    echo "Deletion failed: " . $db->error;
}
?>
