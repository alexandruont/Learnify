<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$conn = new mysqli("localhost", "root", "", "learnify");
$quiz = isset($_GET['quiz']) ? intval($_GET['quiz']) : 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz = intval($_POST['quiz']);
    $question = $_POST['question'];
    $a = $_POST['option_a'];
    $b = $_POST['option_b'];
    $c = $_POST['option_c'];
    $d = $_POST['option_d'];
    $correct = $_POST['correct'];

    $stmt = $conn->prepare("INSERT INTO quiz_questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $quiz, $question, $a, $b, $c, $d, $correct);
    $stmt->execute();

    header("Location: manageQuiz.php?quiz=$quiz");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Question</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
  <div class="container">
    <h3 class="mb-4 text-primary">Add Question - Quiz <?= $quiz ?></h3>
    <form method="POST">
      <input type="hidden" name="quiz" value="<?= $quiz ?>">
      <div class="mb-3">
        <label>Question</label>
        <textarea name="question" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label>Option A</label>
        <input type="text" name="option_a" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Option B</label>
        <input type="text" name="option_b" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Option C</label>
        <input type="text" name="option_c" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Option D</label>
        <input type="text" name="option_d" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Correct Option</label>
        <select name="correct" class="form-select" required>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select>
      </div>
      <button class="btn btn-success">Add Question</button>
      <a href="manageQuiz.php?quiz=<?= $quiz ?>" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
