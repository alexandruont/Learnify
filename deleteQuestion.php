<?php
$conn = new mysqli("localhost", "root", "", "learnify");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $quiz = intval($_POST['quiz']);

    $stmt = $conn->prepare("DELETE FROM quiz_questions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: manageQuiz.php?quiz=$quiz");
    exit;
}
?>
