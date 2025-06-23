
<?php

require_once("connection.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {

    redirect("index.php");
}

include 'headerlogged.php';


?>

<div class="row">

    <div>
<?php echo$_SESSION["titlu"] ?>
    </div>
    <div>
    <?php echo $_SESSION["continut"] ?>
</div>
<div>
       ADMINNNN!! jhhgjhghjghjghjg fghfghfghf
</div>
</div>


<?php include 'footer.php'; ?>

