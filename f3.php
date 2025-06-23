
<?php

require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {

    redirect("index.php");
}

include 'headerlogged.php';

?>

<div class="row">
continut funct 3
</div>



<?php include 'footer.php'; ?>

