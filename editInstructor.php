<?php
$conn = new mysqli("localhost", "root", "", "learnify");

if (!isset($_GET['id'])) {
    header("Location: adminInstructors.php");
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM instructors WHERE id = $id");
$instructor = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
  <div class="container">
    <h3 class="mb-4">Edit Instructor</h3>
    <form method="POST" action="updateInstructor.php" class="row g-3">
      <input type="hidden" name="id" value="<?= $instructor['id'] ?>">

      <div class="col-md-4">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($instructor['name']) ?>" required>
      </div>

      <div class="col-md-4">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($instructor['email']) ?>" required>
      </div>

      <div class="col-md-4">
        <label>New Password (optional)</label>
        <input type="password" name="password" class="form-control" placeholder="Leave empty to keep current">
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-success">Update Instructor</button>
        <a href="adminInstructors.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
