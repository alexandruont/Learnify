<?php
$conn = new mysqli("localhost", "root", "", "learnify");

$id = intval($_GET['id']);
$quiz = intval($_GET['quiz']);

$result = $conn->query("SELECT * FROM quiz_questions WHERE id = $id");
$question = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $q = $_POST['question'];
    $a = $_POST['option_a'];
    $b = $_POST['option_b'];
    $c = $_POST['option_c'];
    $d = $_POST['option_d'];
    $correct = $_POST['correct'];

    $stmt = $conn->prepare("UPDATE quiz_questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE id=?");
    $stmt->bind_param("ssssssi", $q, $a, $b, $c, $d, $correct, $id);
    $stmt->execute();

    header("Location: manageQuiz.php?quiz=$quiz");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
  <div class="container">
    <h3 class="mb-4 text-primary">Edit Question - Quiz <?= $quiz ?></h3>
    <form method="POST">
      <div class="mb-3">
        <label>Question</label>
        <textarea name="question" class="form-control" required><?= htmlspecialchars($question['question']) ?></textarea>
      </div>
      <div class="mb-3">
        <label>Option A</label>
        <input type="text" name="option_a" class="form-control" value="<?= htmlspecialchars($question['option_a']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Option B</label>
        <input type="text" name="option_b" class="form-control" value="<?= htmlspecialchars($question['option_b']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Option C</label>
        <input type="text" name="option_c" class="form-control" value="<?= htmlspecialchars($question['option_c']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Option D</label>
        <input type="text" name="option_d" class="form-control" value="<?= htmlspecialchars($question['option_d']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Correct Option</label>
        <select name="correct" class="form-select" required>
          <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
            <option value="<?= $opt ?>" <?= $question['correct_option'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button class="btn btn-primary">Save Changes</button>
      <a href="manageQuiz.php?quiz=<?= $quiz ?>" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
