<?php
session_start();
(!isset($_SESSION['student_login'])) ? header("location: ./register") : null;
session_destroy();
session_unset();

setcookie('emailcookie', '', time() - 3600);
setcookie('passwordcookie', '', time() - 3600);

header("location: ./register");
