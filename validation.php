<?php

// sign in form validations
if (isset($_POST['register'])) {
    if (isset($_POST['r_email']) && isset($_POST['s_password']) && isset(['scp_password'])) {
        $r_email =    $_POST['r_email'];
        $s_password =  $_POST['s_password'];
        $scp_password =  $_POST['scp_password'];

        $lowercase = preg_match('@[a-z]@', $log_Password);
        $number    = preg_match('@[0-9]@', $log_Password);
        if (empty($r_email)) {
            $error_r_email = "Must be provided by your email.";
        } elseif (!filter_var($log_Email, FILTER_VALIDATE_EMAIL)) {
            $error_r_email = "Invalid email address";
        } elseif (empty($s_password)) {
            $error_s_password = "Must be provided by your password.";
        } elseif (!$lowercase || !$number || strlen($log_Password) < 8) {
            $error_s_password = "You must use a strong password";
        } elseif (empty($scp_password)) {
            $error_scp_password = "Please enter your password again.";
        } elseif ($s_password !== $scp_password) {
            $error_scp_password = "Your password does not match";
        } else {
        }
    }
}
