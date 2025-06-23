<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("connection.php");
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $result = $db->query("SELECT thumbnail, pdf_path FROM courses WHERE id = $id");
    $row = $result->fetch_assoc();

    $thumbnailPath = $row['thumbnail'];
    $pdfPath = $row['pdf_path'];

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
        $uploadsDir = "uploads/";
        if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0777, true);

        $filename = basename($_FILES['thumbnail']['name']);
        $thumbnailPath = $uploadsDir . uniqid() . "_" . $filename;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath);
    }

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === 0) {
        $pdfDir = "CoursePDF/";
        if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

        $filename = basename($_FILES['pdf']['name']);
        $pdfPath = $pdfDir . uniqid() . "_" . $filename;
        move_uploaded_file($_FILES['pdf']['tmp_name'], $pdfPath);
    }

    $stmt = $db->prepare("UPDATE courses SET title=?, category=?, description=?, thumbnail=?, pdf_path=?, price=? WHERE id=?");
    $stmt->bind_param("ssssssi", $title, $category, $description, $thumbnailPath, $pdfPath, $price, $id);
    $stmt->execute();
}

$db->close();
header("Location: instructorCourse.php");
exit;
?>
