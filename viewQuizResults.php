<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] === "") {
    redirect("index.php");
}

include 'headerlogged.php';

//delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $db->prepare("DELETE FROM quiz_results WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
}

//update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $score = floatval($_POST['score']);
    $feedback = $_POST['feedback'];
    $stmt = $db->prepare("UPDATE quiz_results SET score = ?, feedback = ? WHERE id = ?");
    $stmt->bind_param("dsi", $score, $feedback, $update_id);
    $stmt->execute();
}

$query = "
    SELECT qr.id, qr.user_id, qr.quiz_id, qr.score, qr.submitted_at, qr.feedback,
           u.nume AS user_name, u.username,
           q.title AS quiz_title,
           c.title AS course_title
    FROM quiz_results qr
    JOIN users u ON qr.user_id = u.id
    JOIN quizes q ON qr.quiz_id = q.id
    JOIN courses c ON q.course_id = c.id
    ORDER BY qr.submitted_at DESC
";

$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results | Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #f8f9fa;">
    <div class="container py-5 pt-5 mt-5">
        <h2 class="text-primary text-center mb-4">All Quiz Attempts</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>User</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Quiz</th>
                        <th>Score</th>
                        <th>Submitted At</th>
                        <th>Feedback</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="text-center">
                                <form method="POST">
                                    <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['course_title']) ?></td>
                                    <td><?= htmlspecialchars($row['quiz_title']) ?></td>
                                    <td>
                                        <input type="number" name="score" value="<?= $row['score'] ?>" step="0.01" class="form-control" style="max-width: 80px; margin: auto;">
                                    </td>
                                    <td><?= $row['submitted_at'] ?></td>
                                    <td>
                                        <textarea name="feedback" class="form-control" rows="2"><?= htmlspecialchars($row['feedback']) ?></textarea>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this result?');">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger mt-1">Delete</button>
                                </form>
                                    </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center text-muted">No quiz results found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="text-center text-muted py-4 mt-5 bg-white">
        <small>© 2025 Learnify</small>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>