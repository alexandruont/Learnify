<?php
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
$db=mysqli_connect("localhost","root","");
mysqli_select_db($db,"learnify");
session_start();


require_once 'functions.php';
?>