<?php
require_once("connection.php");
require_once("headerlogged.php");

$sql = "
SELECT 
  c.id, 
  c.title, 
  c.category, 
  c.price, 
  c.published, 
  i.name AS instructor_name
FROM courses c
LEFT JOIN instructors i ON c.instructor_id = i.id
ORDER BY c.id DESC
";

$result = mysqli_query($db, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($db));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Courses | Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">

  <div class="container" style="padding-top: 120px;">
    <h2 class="text-primary fw-bold text-center mb-4">All Courses by Instructors</h2>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Course Title</th>
                <th>Instructor</th>
                <th>Category</th>
                <th>Price ($)</th>
                <th>Published</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['instructor_name'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                    <td>
                      <span class="badge bg-<?= $row['published'] ? 'success' : 'secondary' ?>">
                        <?= $row['published'] ? 'Yes' : 'No' ?>
                      </span>
                    </td>
                    <td>
                      <a href="editCourseAdmin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                      <form action="deleteCourseAdmin.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-muted">No courses found.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
    <small>© 2025 Learnify</small>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
