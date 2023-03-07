<?php

// sign in form validations
if (isset($_POST['register'])) {
    if (isset($_POST['r_email']) && isset($_POST['s_password']) && isset(['scp_password'])) {
        $r_email =    $_POST['r_email'];
        $s_password =  $_POST['s_password'];
        $scp_password =  $_POST['scp_password'];

        if (empty($r_email)) {
            $error_r_email = "Must be provided by your email.";
        } elseif (empty($s_password)) {
            $error_s_password = "Must be provided by your password.";
        } elseif (empty($scp_password)) {
            $error_scp_password = "Please enter your password again.";
        } else {
        }
    }
}
