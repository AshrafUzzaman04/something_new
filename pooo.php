<?php
if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $pass_error = '';
    $mail_error = '';

    if (empty($email)) {
        $mail_error = 'Please Input Email';
    }
    if (empty($password)) {
        $pass_error = 'Please Input password';
    }


    $response = array(
        'pass_error' => $pass_error,
        'mail_error' => $mail_error
    );

    exit(json_encode($response));
}
