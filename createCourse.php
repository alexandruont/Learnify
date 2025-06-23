<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}

include 'headerlogged.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Learnify</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />

  <script>
    function validateCourseForm(event) {
      const title = document.getElementById('courseTitle').value.trim();
      const category = document.getElementById('category').value;
      const description = document.getElementById('courseDescription').value.trim();
      const pdfFile = document.getElementById('pdfFile').files[0];
      const thumbnail = document.getElementById('courseImage').files[0];
      const price = document.getElementById('coursePrice').value;

      let errors = [];

      if (title === "") errors.push("Course title is required.");
      if (!category) errors.push("Please select a category.");
      if (description === "") errors.push("Course description is required.");

      if (!pdfFile) {
        errors.push("Please upload a PDF file.");
      } else if (!pdfFile.name.toLowerCase().endsWith('.pdf')) {
        errors.push("The uploaded file must be a PDF.");
      }

      if (thumbnail && !thumbnail.type.startsWith('image/')) {
        errors.push("Thumbnail must be an image file.");
      }

      if (price !== "" && (isNaN(price) || parseFloat(price) < 0)) {
        errors.push("Price must be a positive number.");
      }

      if (errors.length > 0) {
        alert("Please fix the following:\n\n" + errors.join("\n"));
        event.preventDefault();
      }
    }
  </script>
</head>
<body style="background-color: #ECF0F1;">
  
  <div class="container" style="padding-top: 120px;">
    <h2 class="text-primary fw-bold text-center mb-4">Create a New Course</h2>

    <form class="col-md-8 offset-md-2" action="publishCourse.php" method="POST" enctype="multipart/form-data" onsubmit="validateCourseForm(event)">
      <div class="mb-3">
        <label for="courseTitle" class="form-label">Course Title</label>
        <input type="text" class="form-control" name="title" id="courseTitle" placeholder="e.g., Mastering HTML & CSS" required />
      </div>

      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-select" name="category" id="category" required>
          <option value="" disabled selected>Select a category</option>
          <option>Web Development</option>
          <option>Design</option>
          <option>Programming</option>
          <option>Marketing</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="courseDescription" class="form-label">Course Description</label>
        <textarea class="form-control" name="description" id="courseDescription" rows="5" placeholder="Describe your course in detail..." required></textarea>
      </div>

      <div class="mb-3">
        <label for="courseImage" class="form-label">Upload Thumbnail Image</label>
        <input class="form-control" type="file" name="thumbnail" id="courseImage" accept="image/*" />
      </div>

      <div class="mb-3">
        <label for="pdfFile" class="form-label">Upload Course PDF</label>
        <input class="form-control" type="file" name="pdf_file" id="pdfFile" accept="application/pdf" required />
      </div>

      <div class="mb-3">
        <label for="coursePrice" class="form-label">Price</label>
        <input type="number" class="form-control" name="price" id="coursePrice" placeholder="e.g., 49.99" step="0.01" />
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Publish Course</button>
      </div>
    </form>
  </div>

  <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
    <small>© 2025 Learnify</small>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
