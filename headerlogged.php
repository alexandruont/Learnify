<?php
require_once("connection.php");

$page = basename($_SERVER['PHP_SELF']);
$IdUser = $_SESSION["user_id"];

$query = "SELECT pagini.Meniu, pagini.nume_meniu, pagini.pagina 
          FROM pagini 
          INNER JOIN drepturi ON drepturi.IdPage = pagini.Id 
          WHERE drepturi.IdUser = '$IdUser'";

$sql1 = mysqli_query($db, $query);
$rows = mysqli_num_rows($sql1);

$sw = 0;
?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #ffffff;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.html">
      <img src="img/logo3.png" alt="Learnify" width="70px" height="70px" class="d-inline-block align-text-top"> 
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navmenu">
      <ul class="navbar-nav">

        <?php
        if ($rows > 0) {
          while ($myrow = mysqli_fetch_array($sql1, MYSQLI_ASSOC)) {
            if ($myrow["pagina"] == $page) {
              $sw = 1;
            }
            if ($myrow["Meniu"] == 1) {
              echo "<li class='nav-item'>
                      <a class='nav-link' href='{$myrow["pagina"]}'>{$myrow["nume_meniu"]}</a>
                    </li>";
            }
          }
        }

        if ($sw == 0) {
          redirect("logout.php");
        }
        ?>

        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
