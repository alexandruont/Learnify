<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}

;

$sql = "
    SELECT u.id, u.username, ut.desc AS role_name
    FROM users u
    JOIN user_types ut ON u.type = ut.id
    WHERE u.type != 1
    ORDER BY u.id DESC
";
$result = mysqli_query($db, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users | Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body style="background-color: #ECF0F1;">
    <?php include 'headerlogged.php' ?>
  <div class="container" style="padding-top: 120px;">
    <h2 class="text-primary fw-bold text-center mb-5">Manage Users</h2>

    <div class="card mb-5">
      <div class="card-body">
        <table class="table table-hover text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Username</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td><?= htmlspecialchars($row['role_name']) ?></td>
                  <td>
                    <button class="btn btn-sm btn-warning">Block</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="4" class="text-muted">No users found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="text-end mb-5">
      <a href="adminDashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
  </div>

  <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
    <small>© 2025 Learnify</small>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
