<?php
$conn = new mysqli("localhost", "root", "", "learnify");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM courses WHERE instructor_id = $id");
    $stmt = $conn->prepare("DELETE FROM instructors WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
$conn->close();
header("Location: adminInstructors.php");
exit;
