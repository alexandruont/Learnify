<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] === "") {
    header("Location: index.php");
    exit;
}

//edit quiz submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "edit") {
    $quiz_id = intval($_POST['quiz_id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $course_id = intval($_POST['course_id']);

    $stmt = $db->prepare("UPDATE quizes SET title = ?, description = ?, course_id = ? WHERE id = ?");
    $stmt->bind_param("ssii", $title, $description, $course_id, $quiz_id);
    $stmt->execute();
    header("Location: quizDashboard.php");
    exit;
}

//delete Quiz
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "delete") {
    $quiz_id = intval($_POST['quiz_id']);
    $db->query("DELETE FROM quiz_questions WHERE quiz_id = $quiz_id");
    $stmt = $db->prepare("DELETE FROM quizes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    header("Location: quizDashboard.php");
    exit;
}

$searchCourse = isset($_GET['search_course']) ? trim($_GET['search_course']) : '';

$query = "
    SELECT q.id AS quiz_id, q.title AS quiz_title, q.description, q.created_at, q.course_id,
           c.title AS course_title,
           (SELECT COUNT(*) FROM quiz_questions qq WHERE qq.quiz_id = q.id) AS question_count
    FROM quizes q
    JOIN courses c ON q.course_id = c.id
";

$params = [];
if ($searchCourse !== '') {
    $query .= " WHERE c.title LIKE ?";
    $params[] = "%" . $searchCourse . "%";
}

$query .= " ORDER BY q.created_at DESC";

$stmt = $db->prepare($query);
if (!empty($params)) {
    $stmt->bind_param("s", ...$params);
}
$stmt->execute();
$quizzes = $stmt->get_result();

$courses = $db->query("SELECT id, title FROM courses");
$courseOptions = [];
while ($row = $courses->fetch_assoc()) {
    $courseOptions[$row['id']] = $row['title'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Dashboard | Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #f8f9fa;">
<?php include 'headerlogged.php'; ?>

<div class="container py-5 pt-5 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">All Quizzes</h2>
        <a href="addQuiz.php" class="btn btn-success">+ Create New Quiz</a>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-10">
            <input type="text" name="search_course" value="<?= htmlspecialchars($searchCourse) ?>" class="form-control" placeholder="Search by course title...">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-primary w-100">Search</button>
        </div>
    </form>

    <?php if ($quizzes->num_rows === 0): ?>
        <p class="text-center text-muted">No quizzes found.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-light text-center">
                    <tr>
                        <th>Quiz Title</th>
                        <th>Course</th>
                        <th># Questions</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <?php while ($quiz = $quizzes->fetch_assoc()): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="quiz_id" value="<?= $quiz['quiz_id'] ?>">
                                <td><input type="text" name="title" value="<?= htmlspecialchars($quiz['quiz_title']) ?>" class="form-control"></td>
                                <td>
                                    <select name="course_id" class="form-select">
                                        <?php foreach ($courseOptions as $id => $title): ?>
                                            <option value="<?= $id ?>" <?= $id == $quiz['course_id'] ? 'selected' : '' ?>><?= htmlspecialchars($title) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><?= $quiz['question_count'] ?></td>
                                <td><textarea name="description" class="form-control" rows="1"><?= htmlspecialchars($quiz['description']) ?></textarea></td>
                                <td><?= $quiz['created_at'] ?></td>
                                <td>
                                    <input type="hidden" name="action" value="edit">
                                    <button class="btn btn-sm btn-outline-primary mb-1">Save</button>
                                    <a href="manageQuiz.php?quiz=<?= $quiz['quiz_id'] ?>" class="btn btn-sm btn-outline-info mb-1">Manage</a>
                            </form>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                <input type="hidden" name="quiz_id" value="<?= $quiz['quiz_id'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                                </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<footer class="text-center text-muted py-4 bg-white">
    <small>© 2025 Learnify</small>
</footer>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
