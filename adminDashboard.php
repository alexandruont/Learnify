<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}

include 'headerlogged.php';

//total registered users
$userCountResult = mysqli_query($db, "SELECT COUNT(*) AS count FROM users");
$userCount = mysqli_fetch_assoc($userCountResult)['count'];

//total courses
$courseCountResult = mysqli_query($db, "SELECT COUNT(*) AS count FROM courses");
$courseCount = mysqli_fetch_assoc($courseCountResult)['count'];

//recent users by ID (no timestamps)
$recentUsersQuery = "SELECT nume, username FROM users ORDER BY id DESC LIMIT 5";
$recentUsers = mysqli_query($db, $recentUsersQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background-color: #ECF0F1;">

  <div class="container" style="padding-top: 120px;">
    <h2 class="text-primary fw-bold text-center mb-5">Admin Dashboard</h2>

    <div class="row text-center mb-5">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h3 class="text-primary"><?= $userCount ?></h3>
            <p>Registered Users</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h3 class="text-primary"><?= $courseCount ?></h3>
            <p>Total Courses</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h3 class="text-primary">0</h3>
            <p>Messages Received</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-5">
      <div class="card-body">
        <h5 class="text-primary mb-3">Recent Users</h5>
        <table class="table table-hover table-sm">
          <thead>
            <tr>
              <th>Name</th>
              <th>Username</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($user = mysqli_fetch_assoc($recentUsers)): ?>
              <tr>
                <td><?= htmlspecialchars($user['nume']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
