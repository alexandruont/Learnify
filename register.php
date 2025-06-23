<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume = trim($_POST["nume"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["user_password"]);

    if ($nume && $username && $password) {
        $sql = "INSERT INTO users (nume, username, password, type) VALUES (?, ?, ?, 2)";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $nume, $username, $password);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.html");
            exit();
        } else {
            echo "Database error: " . mysqli_error($db);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "All fields must be filled in.";
    }
    
}
// need rethinking
?>

