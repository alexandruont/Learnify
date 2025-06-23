<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}
include 'headerlogged.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM courses";

if ($search !== '') {
    $query .= " WHERE title LIKE ?";
    $stmt = $db->prepare($query);
    $likeSearch = '%' . $search . '%';
    $stmt->bind_param("s", $likeSearch);
} else {
    $stmt = $db->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">
  <?php // include 'headerlogged.php'; ?>

  <div class="container" style="padding-top: 120px;">
    <h2 class="text-primary fw-bold text-center mb-4">Instructor Courses</h2>
    <form class="row g-3 mb-4 justify-content-center" method="GET" action="instructorCourse.php">
      <div class="col-md-8">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search courses by title...">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-outline-primary w-100">Search</button>
      </div>
    </form>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <img src="<?php echo htmlspecialchars($row['thumbnail']); ?>" class="card-img-top" alt="Course Thumbnail" style="height: 200px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="d-flex justify-content-between">
                  <a href="editCourse.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">Edit</a>
                  <a href="enrollments.php?course_id=<?php echo $row['id']; ?>" class="btn btn-outline-secondary btn-sm">Enrollments</a>
                  <form method="POST" action="deleteCourse.php" onsubmit="return confirm('Are you sure you want to delete this course?');">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <p class="text-muted">No courses published yet.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <footer class="text-center text-muted py-4" style="background-color: #ffffff;">
    <small>© 2025 Learnify</small>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $db->close(); ?>
