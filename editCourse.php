<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("connection.php");
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Course - Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">
    <div class="container" style="padding-top: 80px;">
        <h2 class="text-primary fw-bold text-center mb-4">Edit Course</h2>

        <form action="updateCourse.php" method="POST" enctype="multipart/form-data" class="col-md-8 offset-md-2">
            <input type="hidden" name="id" value="<?= $course['id']; ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Course Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <?php
                    $categories = ["Web Development", "Design", "Programming", "Marketing"];
                    foreach ($categories as $cat) {
                        $selected = ($course['category'] === $cat) ? 'selected' : '';
                        echo "<option $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($course['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="pdf" class="form-label">Replace Course PDF (optional)</label>
                <input type="file" name="pdf" class="form-control" accept="application/pdf">
                <?php if (!empty($course['video_url'])): ?>
                    <p class="mt-1">
                        <small>Current PDF: <a href="<?= htmlspecialchars($course['video_url']); ?>" target="_blank">Download</a></small>
                    </p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" name="price" class="form-control" step="0.01" value="<?= htmlspecialchars($course['price']); ?>">
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Replace Thumbnail (optional)</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                <p class="mt-1">
                    <small>Current: <img src="<?= $course['thumbnail']; ?>" width="100"></small>
                </p>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
