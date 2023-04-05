<?php

include_once("./connection.php");


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $update = $conn->query("UPDATE `students` SET `student_status` = 'active' WHERE `token` = '$token';");

    if ($update) {
        echo "<script>alert('Email Activated')</script>";
        header("location: ./register");
    } else {
        echo "<script>alert('Failed!')</script>";
        header("location: ./register");
    }
}
