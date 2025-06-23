<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Learnify</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body style="background-color: #ECF0F1;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #ffffff;">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.html">
          <img src="../img/logo3.png" alt="Learnify" width="70px" height="70px" class="d-inline-block align-text-top"> 
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <div class="d-flex align-items-center">
            <form class="d-flex me-3" role="search">
              <input class="form-control me-1" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">User</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="../profile.html">My Profile</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="Dashboard.html">My Courses</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="../certificates.html">My Certificates</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="../settings.html">Settings</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="../index.html" class="nav-link">Log Out</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
  </nav>

    <div class="container" style="padding-top: 120px;">
      <h2 class="text-primary fw-bold text-center mb-4">Lesson 5 Quiz</h2>
      <form>
        <div class="mb-4">
          <label class="form-label">1. Which tag is used for an unordered list?</label>
          <select class="form-select">
            <option disabled selected>Select an answer</option>
            <option>&lt;ul&gt;</option>
            <option>&lt;ol&gt;</option>
            <option>&lt;li&gt;</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label">2. What tag is used to define a list item in a list?</label>
          <select class="form-select">
            <option disabled selected>Select an answer</option>
            <option>&lt;ul&gt;</option>
            <option>&lt;li&gt;</option>
            <option>&lt;td&gt;</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label">3. Which tag creates a new row in a table?</label>
          <select class="form-select">
            <option disabled selected>Select an answer</option>
            <option>&lt;tr&gt;</option>
            <option>&lt;th&gt;</option>
            <option>&lt;td&gt;</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label">4. Which tag is used to define a cell containing header information in a table?</label>
          <select class="form-select">
            <option disabled selected>Select an answer</option>
            <option>&lt;td&gt;</option>
            <option>&lt;tr&gt;</option>
            <option>&lt;th&gt;</option>
          </select>
        </div>

        <div class="text-center">
          <a href="p5.html" class="btn btn-danger btn-lg mt-3 mb-3">Back to Lesson</a>
          <button type="submit" class="btn btn-success btn-lg">Submit Answers</button>
          <a href="p6.html" class="btn btn-primary btn-lg mt-3 mb-3">Next Lesson</a>
          
        </div>
      </form>
    </div>

    <footer class="text-center text-muted py-4 mt-5" style="background-color: #ffffff;">
      <small>© 2025 Learnify</small>
    </footer>
    <script src="../js/bootstrap.bundle.min.js"></script>
  </body>
</html>