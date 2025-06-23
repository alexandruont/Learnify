<?php
require_once("connection.php");

$page = basename($_SERVER['PHP_SELF']);
$IdUser = $_SESSION["user_id"] ?? '';

if (!$IdUser) {
    redirect("index.php");
}

$query = "SELECT 1 FROM drepturi 
          INNER JOIN pagini ON drepturi.IdPage = pagini.Id 
          WHERE drepturi.IdUser = ? AND pagini.pagina = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("is", $IdUser, $page);
$stmt->execute();
$access = $stmt->get_result();

if ($access->num_rows === 0) {
    redirect("logout.php");
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "
  SELECT i.*, COUNT(c.id) AS course_count
  FROM instructors i
  LEFT JOIN courses c ON i.id = c.instructor_id
";
if ($search !== '') {
    $sql .= " WHERE i.name LIKE ? OR i.email LIKE ? ";
}
$sql .= " GROUP BY i.id ORDER BY i.id DESC";

$stmt = $db->prepare($sql);
if ($search !== '') {
    $likeSearch = '%' . $search . '%';
    $stmt->bind_param("ss", $likeSearch, $likeSearch);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Learnify – Manage Instructors</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">

<?php include 'headerlogged.php'; ?>

<div class="container" style="padding-top: 120px;">
  <h2 class="text-primary fw-bold text-center mb-4">Manage Instructors</h2>

  <form class="row g-3 mb-4" method="GET" action="adminInstructors.php">
    <div class="col-md-10">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by name or email.">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-outline-primary w-100">Search</button>
    </div>
  </form>

  <div class="card shadow-sm mb-5">
    <div class="card-body">
      <form action="addInstructor.php" method="POST" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-success mt-2">Add Instructor</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Courses</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['course_count'] ?></td>
                <td>
                  <a href="editInstructor.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                  <form action="deleteInstructor.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
            <?php if ($result->num_rows === 0): ?>
              <tr><td colspan="5" class="text-muted">No instructors registered yet.</td></tr>
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
