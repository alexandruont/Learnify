<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'connection.php';

$mode = isset($_POST['mode']) ? $_POST['mode'] : "";

if ($mode == "loginare") {
    $username = trim($_POST['username']);
    $pass = trim($_POST['user_password']);

    if ($username != "" && $pass != "") {
        $sql2 = mysqli_query($db, "SELECT users.Id, users.nume, users.username, user_types.redirect, dash_text.content_text, dash_text.titlu 
            FROM users 
            LEFT JOIN dash_text ON users.type = dash_text.user_type_id 
            LEFT JOIN user_types ON users.type = user_types.Id 
            WHERE users.username = '$username' AND users.password = '$pass'");

        if ($sql2 && mysqli_num_rows($sql2) > 0) {
            $myrow1 = mysqli_fetch_array($sql2, MYSQLI_ASSOC);

            $_SESSION["user_id"] = $myrow1["Id"];
            $_SESSION["name"] = $myrow1["nume"];
            $_SESSION["username"] = $myrow1["username"];
            $_SESSION["titlu"] = $myrow1["titlu"];
            $_SESSION["continut"] = $myrow1["content_text"];
            

            header("Location: " . $myrow1["redirect"]);
            exit;

        }
    }
    // failed login
    redirect("index.php");
    exit;
}

// if already logged in
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "") {
    $redirect = isset($_SESSION["redirect"]) ? $_SESSION["redirect"] : "dashboard.php";
    redirect($redirect);
    exit;
}

include 'header.php';
