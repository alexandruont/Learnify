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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Learnify</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body style="background-color: #ECF0F1;">
    
    <div class="container" style="padding-top: 120px;">
      <div class="text-center mb-5">
        <h2 class="text-primary fw-bold">My Certificates</h2>
        <p class="lead">Here are the certificates you've earned with Learnify.</p>
      </div>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        <div class="col">
          <div class="card shadow-sm h-100">
            <img src="img/certificate1.png" class="card-img-top" alt="HTML Certificate">
            <div class="card-body text-center">
              <h5 class="card-title">HTML Basics</h5>
              <p class="card-text">Issued: March 2025</p>
              <a href="#" class="btn btn-outline-success btn-sm">Download PDF</a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card shadow-sm h-100">
            <img src="img/certificate2.png" class="card-img-top" alt="JavaScript Certificate">
            <div class="card-body text-center">
              <h5 class="card-title">JavaScript Essentials</h5>
              <p class="card-text">Issued: February 2025</p>
              <a href="#" class="btn btn-outline-success btn-sm">Download PDF</a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card shadow-sm h-100">
            <img src="img/certificate3.png" class="card-img-top" alt="CSS Certificate">
            <div class="card-body text-center">
              <h5 class="card-title">Intro to CSS</h5>
              <p class="card-text">Issued: January 2025</p>
              <a href="#" class="btn btn-outline-success btn-sm">Download PDF</a>
            </div>
          </div>
        </div>

      </div>
    </div>
    <footer class="text-center text-muted py-4" style="background-color: #ffffff;">
      <small>© 2025 Learnify</small>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
