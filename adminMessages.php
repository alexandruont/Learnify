<?php
require_once("connection.php");
include 'headerlogged.php';

//delete
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    mysqli_query($db, "DELETE FROM messages WHERE id = $delete_id");
}

//update
if (isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $subject = mysqli_real_escape_string($db, $_POST['edit_subject']);
    $body = mysqli_real_escape_string($db, $_POST['edit_body']);
    mysqli_query($db, "UPDATE messages SET subject='$subject', body='$body' WHERE id=$id");
}

// mark as complete
if (isset($_POST['mark_complete'])) {
    $id = intval($_POST['mark_complete']);
    mysqli_query($db, "UPDATE messages SET completed=1 WHERE id=$id");
}

//create new message
if (isset($_POST['new_message'])) {
    $user_id = intval($_POST['user_id']);
    $subject = mysqli_real_escape_string($db, $_POST['subject']);
    $body = mysqli_real_escape_string($db, $_POST['body']);
    mysqli_query($db, "INSERT INTO messages (user_id, subject, body) VALUES ($user_id, '$subject', '$body')");
}

//read messages
$result = mysqli_query($db, "
    SELECT m.*, u.username 
    FROM messages m
    JOIN users u ON m.user_id = u.id
    ORDER BY m.sent_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Messages</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-color: #ECF0F1;">
<div class="container py-5">
  <h2 class="text-primary fw-bold text-center mb-4">Admin Messages</h2>

  <form method="POST" class="card p-4 mb-4">
    <h5 class="mb-3">Add New Message</h5>
    <input type="hidden" name="new_message" value="1">
    <div class="row g-2">
      <div class="col-md-2">
        <input type="number" name="user_id" class="form-control" placeholder="User ID" required>
      </div>
      <div class="col-md-3">
        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
      </div>
      <div class="col-md-5">
        <input type="text" name="body" class="form-control" placeholder="Message Body" required>
      </div>
      <div class="col-md-2">
        <button class="btn btn-success w-100">Add Message</button>
      </div>
    </div>
  </form>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>From</th>
              <th>Subject</th>
              <th>Message</th>
              <th>Sent</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr class="<?= $row['completed'] ? 'table-success' : '' ?>">
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['body'])) ?></td>
              <td><?= $row['sent_at'] ?></td>
              <td>
                <?= $row['completed'] ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-warning text-dark">Pending</span>' ?>
              </td>
              <td>
                <?php if (!$row['completed']): ?>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="mark_complete" value="<?= $row['id'] ?>">
                  <button class="btn btn-sm btn-outline-success">Complete</button>
                </form>
                <?php endif; ?>

                <form method="POST" style="display:inline;">
                  <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                  <input type="hidden" name="edit_subject" value="<?= $row['subject'] ?>">
                  <input type="hidden" name="edit_body" value="<?= $row['body'] ?>">
                  <button class="btn btn-sm btn-outline-primary" onclick="return editMsg(this.form)">Edit</button>
                </form>

                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                  <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                  <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function editMsg(form) {
  const subject = prompt("Edit subject:", form.edit_subject.value);
  if (subject === null) return false;
  const body = prompt("Edit body:", form.edit_body.value);
  if (body === null) return false;
  form.edit_subject.value = subject;
  form.edit_body.value = body;
  form.submit();
  return false;
}
</script>

<footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
  <small>© 2025 Learnify</small>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
