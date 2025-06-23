<?php
require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    redirect("index.php");
}

include 'headerlogged.php';
// still hardcoded for now, but can be dynamic later
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Learnify</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    </head>
    <body style="background-color: #ECF0F1;">
    
    <div class="container" style="padding-top: 120px;">
        <h2 class="text-primary fw-bold text-center mb-4">Inbox</h2>
        <div class="row">
        <div class="col-md-3 mb-4">
            <div class="nav flex-column nav-pills" id="messageTabs" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="inbox-tab" data-bs-toggle="pill" data-bs-target="#inbox" type="button" role="tab">Inbox</button>
            <button class="nav-link" id="sent-tab" data-bs-toggle="pill" data-bs-target="#sent" type="button" role="tab">Sent</button>
            <button class="nav-link" id="compose-tab" data-bs-toggle="pill" data-bs-target="#compose" type="button" role="tab">Write</button>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="messageTabsContent">
            <div class="tab-pane fade show active" id="inbox" role="tabpanel">
                <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <strong>Instructor</strong>
                    <span class="text-muted float-end">March 30, 2025</span>
                </div>
                <div class="card-body">
                    <p>Hi Alex, great job so far! Let me know if you have any questions on the next module.</p>
                </div>
                </div>
            </div>
            <div class="tab-pane fade" id="sent" role="tabpanel">
                <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <strong>You → Instructor </strong>
                    <span class="text-muted float-end">March 31, 2025</span>
                </div>
                <div class="card-body">
                    <p>Thanks for the feedback! I'll check out the next lesson tonight.</p>
                </div>
                </div>
            </div>
            <div class="tab-pane fade" id="compose" role="tabpanel">
                <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form>
                    <div class="mb-3">
                        <label for="recipient" class="form-label">To</label>
                        <input type="text" class="form-control" id="recipient" placeholder="Instructor name or email" required />
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Type your message here..." required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <footer class="text-center text-muted py-4 fixed-bottom" style="background-color: #ffffff;">
        <small>© 2025 Learnify</small>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
