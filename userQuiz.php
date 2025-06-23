<?php
require_once("connection.php");
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;
$isSubmitted = $_SERVER["REQUEST_METHOD"] === "POST";

if ($isSubmitted && isset($_POST['quiz_id'], $_POST['answer'])) {
    $quiz_id = intval($_POST['quiz_id']);
    $answers = $_POST['answer'];
    $score = 0;
    $total = count($answers);

    //get correct answers
    $stmt = $db->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $correct = [];
    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $correct[$row['id']] = $row['correct_option'];
        $questions[$row['id']] = $row;
    }

    //calculate score
    foreach ($correct as $qid => $correctOption) {
        if (isset($answers[$qid]) && strtolower($answers[$qid]) === strtolower($correctOption)) {
            $score++;
        }
    }

    $percent = round(($score / max($total, 1)) * 100);
    $feedback = "You answered $score out of $total correctly.";

    //count previous attempts
    $attemptQuery = $db->prepare("SELECT COUNT(*) as total FROM quiz_results WHERE user_id=? AND quiz_id=?");
    $attemptQuery->bind_param("ii", $user_id, $quiz_id);
    $attemptQuery->execute();
    $attemptCount = $attemptQuery->get_result()->fetch_assoc();
    $attempt = $attemptCount['total'] + 1;

    //insert result
    $stmt = $db->prepare("INSERT INTO quiz_results (user_id, quiz_id, score, feedback, submitted_at, attempt_number) VALUES (?, ?, ?, ?, NOW(), ?)");
    $stmt->bind_param("iiisi", $user_id, $quiz_id, $percent, $feedback, $attempt);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Quiz</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light pt-2">
<?php include 'headerlogged.php'; ?>
<div class="container mt-5 pt-5">
<?php
if ($isSubmitted): ?>
  <h2 class="text-success">Quiz Submitted!</h2>
  <p class="lead"><?= $feedback ?> (Score: <?= $percent ?>%)</p>

  <h4 class="mt-4">Your Answers:</h4>
  <?php
  foreach ($questions as $q):
    $userAnswer = $answers[$q['id']] ?? null;
    $correctAnswer = $q['correct_option'];
    $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);

    $optionKey = "option_" . strtolower($userAnswer);
    $answerText = $q[$optionKey] ?? 'Invalid option';

    $correctOptionKey = "option_" . strtolower($correctAnswer);
    $correctText = $q[$correctOptionKey] ?? 'Unknown';
  ?>
    <div class="mb-4 p-3 border <?= $isCorrect ? 'border-success bg-light' : 'border-danger bg-white' ?>">
      <p><strong><?= htmlspecialchars($q['question']) ?></strong></p>
      <p>
        Your Answer:
        <span class="<?= $isCorrect ? 'text-success' : 'text-danger' ?>">
          <?= htmlspecialchars($answerText) ?>
        </span>
      </p>
      <?php if (!$isCorrect): ?>
        <p class="text-success">
          Correct Answer: <?= htmlspecialchars($correctText) ?>
        </p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
  <a href="userQuiz.php?quiz_id=<?= $quiz_id ?>" class="btn btn-outline-primary">Retake / View Quiz</a>
  <a href="userDashboard.php" class="btn btn-secondary">Back to Dashboard</a>

<?php elseif ($quiz_id):
    $stmt = $db->prepare("SELECT title, description FROM quizes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $quiz = $stmt->get_result()->fetch_assoc();

    $stmt = $db->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $questions = $stmt->get_result();
?>
  <h2><?= htmlspecialchars($quiz['title']) ?></h2>
  <p><?= htmlspecialchars($quiz['description']) ?></p>
  <form method="POST" action="userQuiz.php">
    <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
    <?php $i = 1; while ($q = $questions->fetch_assoc()): ?>
      <div class="mb-4">
        <p><strong><?= $i++ ?>. <?= htmlspecialchars($q['question']) ?></strong></p>
        <?php foreach (['a', 'b', 'c', 'd'] as $opt): ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="answer[<?= $q['id'] ?>]" value="<?= $opt ?>" required>
            <label class="form-check-label"><?= htmlspecialchars($q['option_' . $opt]) ?></label>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endwhile; ?>
    <button type="submit" class="btn btn-primary">Submit Quiz</button>
  </form>

<?php else:
    $stmt = $db->prepare("SELECT quizes.id, quizes.title, courses.title AS course FROM quizes JOIN courses ON quizes.course_id = courses.id");
    $stmt->execute();
    $quizzes = $stmt->get_result();
?>
  <h2 class="mb-4">Available Quizzes</h2>
  <ul class="list-group">
    <?php while ($q = $quizzes->fetch_assoc()): ?>
      <li class="list-group-item">
        <div class="d-flex justify-content-between align-items-center">
          <span>
            <strong><?= htmlspecialchars($q['title']) ?></strong>
            <small class="text-muted">(<?= htmlspecialchars($q['course']) ?>)</small>
          </span>
          <a href="userQuiz.php?quiz_id=<?= $q['id'] ?>" class="btn btn-sm btn-outline-primary">Start Quiz</a>
        </div>

        <?php
        $stmtHistory = $db->prepare("SELECT score, submitted_at, attempt_number, feedback FROM quiz_results WHERE user_id = ? AND quiz_id = ? ORDER BY attempt_number DESC");
        $stmtHistory->bind_param("ii", $user_id, $q['id']);
        $stmtHistory->execute();
        $results = $stmtHistory->get_result();
        ?>
        <?php if ($results->num_rows > 0): ?>
          <div class="mt-2">
            <button class="btn btn-sm btn-outline-info mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#attempts<?= $q['id'] ?>">
              View Attempts
            </button>
            <div class="collapse" id="attempts<?= $q['id'] ?>">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th>Attempt</th>
                    <th>Score </th>
                    <th>Submitted At</th>
                    <th>Feedback</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                      <td><?= $row['attempt_number'] ?></td>
                      <td><?= $row['score'] ?></td>
                      <td><?= $row['submitted_at'] ?></td>
                      <td><?= htmlspecialchars($row['feedback']) ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </li>
    <?php endwhile; ?>
  </ul>
<?php endif; ?>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>