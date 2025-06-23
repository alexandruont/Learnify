<?php
$conn = new mysqli("localhost", "root", "", "learnify");
$quiz = 1;

$stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY id ASC");
$stmt->bind_param("i", $quiz);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
  $questions[] = $row;
}
$score = 0;
$total = count($questions);
$submitted = ($_SERVER["REQUEST_METHOD"] === "POST");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HTML Quiz <?= $quiz ?> | Learnify</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">
  <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #ffffff;">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.html">
        <img src="../img/logo3.png" alt="Learnify" width="70px" height="70px" class="d-inline-block align-text-top"> 
      </a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item"><a href="../quizDashboard.php" class="nav-link">My Quizzes</a></li>
          <li class="nav-item"><a href="../index.html" class="nav-link">Log Out</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container" style="padding-top: 120px;">
    <h2 class="text-primary fw-bold text-center mb-4">HTML Quiz <?= $quiz ?></h2>

    <?php if ($submitted): ?>
      <div class="alert alert-info text-center">
        <?php
          foreach ($questions as $q) {
            $qid = $q['id'];
            $correct = $q['correct_option'];
            $userAnswer = $_POST["q$qid"] ?? null;

            if ($userAnswer === $correct) {
              $score++;
            }
          }
          echo "<h5>Your Score: $score / $total</h5>";
        ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <?php $qNumber = 1; foreach ($questions as $q): ?>
        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <h5><strong>Question <?= $qNumber++ ?>:</strong> <?= htmlspecialchars($q['question']) ?></h5>
            <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
              <div class="form-check">
                <input 
                  class="form-check-input" 
                  type="radio" 
                  name="q<?= $q['id'] ?>" 
                  value="<?= $opt ?>"
                  <?= (($_POST["q{$q['id']}"] ?? '') === $opt) ? 'checked' : '' ?>
                  <?= $submitted ? 'disabled' : '' ?>
                >
                <label class="form-check-label">
                  <?= htmlspecialchars($q["option_" . strtolower($opt)]) ?>
                  <?php
                  if ($submitted && $q['correct_option'] === $opt) {
                    echo '<span class="badge bg-success ms-2">Correct</span>';
                  } elseif ($submitted && ($_POST["q{$q['id']}"] ?? '') === $opt) {
                    echo '<span class="badge bg-danger ms-2">Your Answer</span>';
                  }
                  ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (!$submitted): ?>
        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-lg">Submit Quiz</button>
        </div>
      <?php endif; ?>
    </form>
  </div>

  <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
    <small>© 2025 Learnify</small>
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
