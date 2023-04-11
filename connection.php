<?php
session_start();

$localhost = "localhost";
$username = "root";
$password = "";
$database = "something_new";

$conn = mysqli_connect($localhost, $username, $password, $database);
