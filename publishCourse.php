<?php
require_once("connection.php");
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    header("Location: index.php");
    exit;
}

include 'headerlogged.php';

$title = $_POST['title'];
$category = $_POST['category'];
$description = $_POST['description'];
$video = $_POST['video'];
$price = $_POST['price'];

$thumbnailPath = '';
$pdfPath = '';

if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
    $uploadsDir = "img/";
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }
    $filename = basename($_FILES['thumbnail']['name']);
    $targetPath = $uploadsDir . $filename;
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath);
    $thumbnailPath = $targetPath;
}

if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
    $pdfDir = "CoursePDF/";
    if (!is_dir($pdfDir)) {
        mkdir($pdfDir, 0777, true);
    }

    $pdfFilename = basename($_FILES['pdf_file']['name']);
    $pdfTargetPath = $pdfDir . $pdfFilename;
    $pdfFileType = strtolower(pathinfo($pdfTargetPath, PATHINFO_EXTENSION));

    if ($pdfFileType === 'pdf') {
        if ($_FILES['pdf_file']['size'] <= 10 * 1024 * 1024) {
            move_uploaded_file($_FILES['pdf_file']['tmp_name'], $pdfTargetPath);
            $pdfPath = $pdfTargetPath;
        } else {
            die("PDF file too large. Max 10MB allowed.");
        }
    } else {
        die("Only PDF files are allowed.");
    }
}
//db insert
$stmt = $db->prepare("INSERT INTO courses (title, category, description, thumbnail, video_url, price, pdf_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $title, $category, $description, $thumbnailPath, $video, $price, $pdfPath);

if ($stmt->execute()) {
    header("Location: instructorCourse.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$db->close();
?>
