<?php
session_start();
(!isset($_SESSION['student_login'])) ? header("location: ./register") : null;
session_destroy();

setcookie('emailcookie', '', time() - 86400);
setcookie('passwordcookie', '', time() - 86400);

header("location: ./register");
