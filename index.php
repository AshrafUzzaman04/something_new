<?php
session_start();

include_once("./includes/header.php");
include_once("./includes/nav.php");
(!isset($_SESSION['student_login'])) ? header("location: ./register") : null;
include_once("./includes/loadingp.php");
?>
<?php
include_once("./includes/footer.php");
?>