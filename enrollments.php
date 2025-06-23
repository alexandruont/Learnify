<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$students = [];
$searchResults = [];

if ($course_id > 0) {
    $sql = "SELECT users.id, users.nume, users.username, enrollments.progress, enrollments.note 
            FROM enrollments
            JOIN users ON enrollments.user_id = users.id
            WHERE enrollments.course_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    if (isset($_GET['search'])) {
        $search = '%' . trim($_GET['search']) . '%';
        $sqlSearch = "SELECT id, nume, username FROM users WHERE type = 2 AND (nume LIKE ? OR username LIKE ?)";
        $stmtSearch = $db->prepare($sqlSearch);
        $stmtSearch->bind_param("ss", $search, $search);
        $stmtSearch->execute();
        $resultSearch = $stmtSearch->get_result();
        while ($row = $resultSearch->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Enrollments - Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">
<?php include 'headerlogged.php'; ?>

<div class="container" style="padding-top: 120px;">
  <h2 class="text-primary fw-bold text-center mb-4">Student Enrollments</h2>
  <!-- search form -->
  <form method="GET" class="row mb-4">
    <input type="hidden" name="course_id" value="<?= $course_id ?>">
    <div class="col-md-10">
      <input type="text" name="search" class="form-control" placeholder="Search students by name or username..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-outline-primary w-100">Search</button>
    </div>
  </form>

  <?php if (!empty($searchResults)): ?>
    <div class="card mb-4">
      <div class="card-body">
        <h5>Search Results:</h5>
        <ul class="list-group">
          <?php foreach ($searchResults as $user): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($user['nume']) ?> (<?= htmlspecialchars($user['username']) ?>)
              <form action="addStudent.php" method="POST" class="mb-0">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                <button type="submit" class="btn btn-sm btn-success">Enroll</button>
              </form>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Progress</th>
          <th>Note</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($students)): ?>
          <tr><td colspan="5" class="text-center">No students enrolled in this course yet.</td></tr>
        <?php else: ?>
          <?php foreach ($students as $student): ?>
            <tr>
              <td><?= htmlspecialchars($student['nume']) ?></td>
              <td><?= htmlspecialchars($student['username']) ?></td>
              <td><?= $student['progress'] ?? '--' ?>%</td>
              <td><?= htmlspecialchars($student['note'] ?? '') ?></td>
              <td>
                <a href="editEnrollment.php?user_id=<?= $student['id'] ?>&course_id=<?= $course_id ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
                <form action="removeStudent.php" method="POST" onsubmit="return confirm('Remove this student?');" style="display:inline;">
                  <input type="hidden" name="user_id" value="<?= $student['id'] ?>">
                  <input type="hidden" name="course_id" value="<?= $course_id ?>">
                  <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
  <small>© 2025 Learnify</small>
</footer>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>