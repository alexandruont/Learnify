<?php
require_once("connection.php");
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}
session_start();

if (!isset($_GET['user_id'], $_GET['course_id'])) {
    die("Invalid parameters");
}

$user_id = intval($_GET['user_id']);
$course_id = intval($_GET['course_id']);

$stmt = $db->prepare("SELECT e.*, u.nume, u.username FROM enrollments e
                      JOIN users u ON e.user_id = u.id
                      WHERE e.user_id = ? AND e.course_id = ?");
$stmt->bind_param("ii", $user_id, $course_id);
$stmt->execute();
$enrollment = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Enrollment</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3>Edit Enrollment for <?= htmlspecialchars($enrollment['nume']) ?> (<?= $enrollment['username'] ?>)</h3>
  <form action="updateEnrollment.php" method="POST" class="mt-4">
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <input type="hidden" name="course_id" value="<?= $course_id ?>">

    <div class="mb-3">
      <label for="progress" class="form-label">Progress (%)</label>
      <input type="number" class="form-control" name="progress" min="0" max="100" value="<?= $enrollment['progress'] ?>">
    </div>

    <div class="mb-3">
      <label for="note" class="form-label">Note (optional)</label>
      <textarea class="form-control" name="note" rows="3"><?= htmlspecialchars($enrollment['note']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="enrollments.php?course_id=<?= $course_id ?>" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
