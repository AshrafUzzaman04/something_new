<?php

include_once("./connection.php");


function sefuda($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);

    return $data;
}

// sign up form validations
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register'])) {
    if (isset($_POST['r_email'], $_POST['s_password'], $_POST['scp_password'])) {
        $r_email =  sefuda($_POST['r_email']);
        $s_password = sefuda($_POST['s_password']);
        $scp_password = sefuda($_POST['scp_password']);


        // search the existing email address
        $select_existing_data = $conn->query("SELECT * FROM `students` WHERE `student_email` = '$r_email'");


        $lowercase = preg_match('@[a-z]@', $s_password);
        $number    = preg_match('@[0-9]@', $s_password);
        if (empty($r_email)) {
            $res =  array(
                'error_for' => 1,
                'msg' => 'Must be provide your email.'
            );
            exit(json_encode($res));
        } elseif (!filter_var($r_email, FILTER_VALIDATE_EMAIL)) {
            $res =  array(
                'error_for' => 1,
                'msg' => 'Invalid email address!'
            );
            exit(json_encode($res));
        } elseif ($select_existing_data->num_rows > 0 || $select_existing_data->num_rows === 1) {
            $res =  array(
                'error_for' => 1,
                'msg' => 'Email address already exists!'
            );
            exit(json_encode($res));
        } elseif (empty($s_password)) {
            $res = array(
                'error_for' => 2,
                'msg' => 'Must be provide your password!'
            );
            exit(json_encode($res));
        } elseif (!$lowercase || !$number) {
            $res = array(
                'error_for' => 2,
                'msg' => 'You must use a strong password!'
            );
            exit(json_encode($res));
        } elseif (strlen($s_password) < 6) {
            $res = array(
                'error_for' => 2,
                'msg' => 'Your password must be at least 6 digits long!'
            );
            exit(json_encode($res));
        } elseif (empty($scp_password)) {
            $res = array(
                'error_for' => 3,
                'msg' => 'Please enter your password again!'
            );
            exit(json_encode($res));
        } elseif ($s_password !== $scp_password) {
            $res = array(
                'error_for' => 3,
                'msg' => 'Your password must be the same!'
            );
            exit(json_encode($res));
        } else {
            $student_data_insert = $conn->query("INSERT INTO `students`(`student_email`, `student_pass`) VALUES ('$r_email','$s_password')");

            $r_email = $s_password = $scp_password = null;

            if ($student_data_insert) {
                $res = array(
                    'error_for' => 4,
                    'msg' => 'Data inserted successfully!'
                );
                exit(json_encode($res));
            } else {
                $res = array(
                    'error_for' => 5,
                    'msg' => 'Something went wrong!'
                );
                exit(json_encode($res));
            }
        }
    }
}
