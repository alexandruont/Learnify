<?php
$conn = new mysqli("localhost", "root", "", "learnify");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE instructors SET name=?, email=?, password=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $hashed, $id);
    } else {
        $stmt = $conn->prepare("UPDATE instructors SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
    }

    $stmt->execute();
}

$conn->close();
header("Location: adminInstructors.php");
exit;
