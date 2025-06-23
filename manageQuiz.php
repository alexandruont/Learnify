<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("connection.php");

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

$quiz = isset($_GET['quiz']) ? intval($_GET['quiz']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$query = "SELECT * FROM quiz_questions WHERE quiz_id = ?";
if ($search !== '') {
    $query .= " AND question LIKE ?";
    $stmt = $db->prepare($query);
    $likeSearch = '%' . $search . '%';
    $stmt->bind_param("is", $quiz, $likeSearch);
} else {
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $quiz);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Quiz <?= $quiz ?> Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">
<?php include 'headerlogged.php'; ?>

<div class="container" style="padding-top: 120px;">
  <h2 class="text-primary fw-bold text-center mb-4">Manage Questions - Quiz <?= $quiz ?></h2>
  <form method="GET" class="row g-3 mb-4 justify-content-center">
    <input type="hidden" name="quiz" value="<?= $quiz ?>">
    <div class="col-md-8">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search questions...">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-outline-primary w-100">Search</button>
    </div>
  </form>
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Question</th>
              <th>Correct</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td class="text-start"><?= htmlspecialchars($row['question']) ?></td>
                <td><?= $row['correct_option'] ?></td>
                <td>
                  <a href="editQuestion.php?id=<?= $row['id'] ?>&quiz=<?= $quiz ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                  <form action="deleteQuestion.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this question?');">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="quiz" value="<?= $quiz ?>">
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
            <?php if ($result->num_rows === 0): ?>
              <tr><td colspan="4" class="text-muted">No questions found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <a href="addQuestion.php?quiz=<?= $quiz ?>" class="btn btn-success mt-3">Add New Question</a>
    </div>
  </div>
</div>

<footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
  <small>© 2025 Learnify</small>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
