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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Learnify</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body style="background-color: #ECF0F1;">
        
        <div class="container" style="padding-top: 120px;">
            <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-primary fw-bold mb-4 text-center">Settings</h2>
        
                <form>
                <div class="mb-3">
                    <label for="uploadPhoto" class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" id="uploadPhoto" accept="image/*" />
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" value="Alex Ont" />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" value="alex@email.com" />
                </div>
                <div class="text-center mb-4 pb-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-primary" href="change-password.html">Change Password</a>
                </div>
                </form>
            </div>
            </div>
        </div>      
        <footer class="text-center text-muted py-4" style="background-color: #ffffff;">
            <small>© 2025 Learnify</small>
        </footer>

        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
