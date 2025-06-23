<?php
require_once("connection.php");

if (!isset($_GET['id'])) {
    die("Course ID is required.");
}

$courseId = intval($_GET['id']);

// Fetch course
$query = "SELECT * FROM courses WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $courseId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Course not found.");
}

$course = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $published = isset($_POST['published']) ? 1 : 0;

    $update = "UPDATE courses SET title=?, category=?, price=?, published=? WHERE id=?";
    $stmt = $db->prepare($update);
    $stmt->bind_param("ssdii", $title, $category, $price, $published, $courseId);

    if ($stmt->execute()) {
        header("Location: adminCourses.php");
        exit;
    } else {
        echo "Update failed: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course (Admin)</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container" style="padding-top: 100px;">
    <h2 class="mb-4 text-primary">Edit Course (Admin)</h2>

    <form method="post">
        <div class="mb-3">
            <label>Course Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($course['category']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Price ($)</label>
            <input type="number" name="price" step="0.01" class="form-control" value="<?= $course['price'] ?>" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="published" class="form-check-input" id="pubCheck" <?= $course['published'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="pubCheck">Published</label>
        </div>
        <button type="submit" class="btn btn-success">Update Course</button>
        <a href="adminCourses.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
