<?php

$conn = mysqli_connect("localhost", "root", "", "something_new");

function sefuda($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);

    return $data;
}

// sign up form validations
if ($_SERVER['REQUEST_METHOD'] && isset($_POST['register'])) {
    if (isset($_POST['r_email']) && isset($_POST['s_password']) && isset(['scp_password'])) {
        $r_email =  sefuda($_POST['r_email']);
        $s_password = sefuda($_POST['s_password']);
        $scp_password = sefuda($_POST['scp_password']);


        $lowercase = preg_match('@[a-z]@', $s_password);
        $number    = preg_match('@[0-9]@', $s_password);
        if (empty($r_email)) {
            $error_r_email = "Must be provided by your email.";
        } elseif (!filter_var($r_email, FILTER_VALIDATE_EMAIL)) {
            $error_r_email = "Invalid email address!";
        } elseif (empty($s_password)) {
            $error_s_password = "Must be provided by your password!";
        } elseif (!$lowercase || !$number || strlen($s_password)) {
            $error_s_password = "You must use a strong password!";
        } elseif (empty($scp_password)) {
            $error_scp_password = "Please enter your password again!";
        } elseif ($s_password !== $scp_password) {
            $error_scp_password = "Your password must be the same!";
        } else {
            $student_data_insert = $conn->query("INSERT INTO `students`(`student_email`, `student_pass`) VALUES ('$r_email','$s_password')");

            echo "<script>alert('good')</script>";
        }
    }
}
