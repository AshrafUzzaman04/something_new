<?php
include_once("./connection.php");


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function mailsender($recipient_email, $mailbody, $sub)
{
    //Load Composer's autoloader
    require './PHPMailer/Exception.php';
    require './PHPMailer/PHPMailer.php';
    require './PHPMailer/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'ashraf.uzzaman04082004@gmail.com';                     //SMTP username
        $mail->Password   = 'hkythzeirkteovuz';                            //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ashraf.uzzaman04082004@gmail.com', 'WebcoderAshraf');
        $mail->addAddress($recipient_email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $sub;
        $mail->Body    = $mailbody;

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


function sefuda($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);

    return $data;
}

// sign up form validations for ajax request
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register'])) {
    if (isset($_POST['r_email'], $_POST['s_password'], $_POST['scp_password'])) {
        $r_email =  mysqli_real_escape_string($conn, (sefuda($_POST['r_email'])));
        $s_password = mysqli_real_escape_string($conn, sefuda($_POST['s_password']));
        $scp_password = mysqli_real_escape_string($conn, sefuda($_POST['scp_password']));

        $token = bin2hex(random_bytes(10));


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
            // php password bcrypt formate 
            $s_password = password_hash($s_password, PASSWORD_BCRYPT);
            $student_data_insert = $conn->query("INSERT INTO `students`(`student_email`, `student_pass` , `token`, `student_status`) VALUES ('$r_email','$s_password','$token','inactive')");

            // email subject
            $sub = "Your Activation Code!";

            // mail body
            $mailbody = "<div style='text-align:center;'><h2 style='margin:0px'>Your Activation Code!</h2> <br> <h4 style='margin:0px;'>Click the button below to activate the account👇</h4> <br> <a href='http://localhost/something_new/activate?token=$token' style='
                line-height: 16px;
                color: #ffffff;
                font-weight: 400;
                text-decoration: none;
                font-size: 14px;
                display: inline-block;
                padding: 10px 24px;
                background-color: #4184f3;
                border-radius: 5px;
                min-width: 90px;'>Activate account</span></a></div>";

            $mailSender = mailSender($r_email, $mailbody, $sub);
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


// recoveryemail validations
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['recover_email123'])) {
    $recov_Email = mysqli_real_escape_string($conn, sefuda($_POST['recov_Email']));

    // validation recovery email address
    if (empty($recov_Email)) {
        $error_recov_email = 'Please your email address';
    } elseif (!filter_var($recov_Email, FILTER_VALIDATE_EMAIL)) {
        $error_recov_email = 'Invalid email format!';
    } else {
        $search_email = $conn->query("SELECT * FROM `students` WHERE `student_email` = '$recov_Email'");

        if ($search_email->num_rows == 1) {
            $fetch_this_email_data  = mysqli_fetch_assoc($search_email);
            $token = $fetch_this_email_data['token'];
            $token = strrev($token);

            // mail subject
            $sub = "Verify your email address!";

            // mail body
            $mailbody = "<div style='text-align:center;'><h2 style='margin:0px'>Verify it's you!</h2> <br> <h4 style='margin:0px;'>Click the button below to verify it's you👇</h4> <br> <a href='http://localhost/something_new/reset_password?confirm_t=$token' style='
            line-height: 16px;
            color: #ffffff;
            font-weight: 400;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            padding: 10px 24px;
            background-color: #4184f3;
            border-radius: 5px;
            min-width: 90px;'>Yes it's me</span></a></div>";

            $_SESSION['activation_msg'] = "Click on the email message to verify that the email is yours!";
            $mailSender = mailSender($recov_Email, $mailbody, $sub);
            $recov_Email = null;
            header("location: reset_password");
        } else {
            $error_recov_email = "Email does not exist!";
        }
    }
}



// update password setup
if (isset($_GET['confirm_t'])) {
    // reverse the get request
    $confirm_t = strrev($_GET['confirm_t']);

    $search_token = $conn->query("SELECT * FROM `students` WHERE `token` = '$confirm_t'");

    if ($search_token->num_rows !== 1 || $search_token->num_rows == 0) {
        $_SESSION['activation_msg'] = "Please Verify your email address!";
        header("location: reset_password");
    } else {
        $fetch_email = mysqli_fetch_assoc($search_token);
        $student_email = $fetch_email['student_email'];

        $_SESSION['activation_msg'] = $student_email  . " has been verified";

        if ($_SERVER['REQUEST_METHOD'] === "POST" || isset($_POST['updatepass123'])) {
            $new_pass = mysqli_real_escape_string($conn, sefuda($_POST['new_pass']));
            $c_new_pass = mysqli_real_escape_string($conn, sefuda($_POST['c_new_pass']));

            $lowercase = preg_match('@[a-z]@', $new_pass);
            $number    = preg_match('@[0-9]@', $new_pass);

            if ($search_token->num_rows !== 0 || $search_token->num_rows == 1) {

                if (empty($new_pass)) {
                    $error_new_pass = "Enter your new password!";
                } elseif ($lowercase || $number) {
                    $error_new_pass = "You must use a strong password!";
                } elseif (strlen($new_pass) < 6) {
                    $error_new_pass = "Your password must be at least 6 digits long!";
                } else {
                    $correct_new_pass  = $conn->real_escape_string($new_pass);
                }

                if (empty($c_new_pass)) {
                    $error_c_new_pass = "Enter your password again!";
                } elseif ($new_pass !== $c_new_pass) {
                    $error_c_new_pass = "Both passwords must be the same!";
                } else {
                    $correct_c_new_pass =  $conn->real_escape_string($c_new_pass);
                }

                if (isset($correct_c_new_pass) || isset($correct_new_pass)) {
                    $has_pass = password_hash($c_new_pass, PASSWORD_BCRYPT);

                    $token = bin2hex(random_bytes(14));

                    $update_query = $conn->query("UPDATE `students` SET `student_pass`= '$has_pass' , `token` = '$token' WHERE `token` = '$confirm_t'");
                    if ($update_query) {
                        $_SESSION['activation_msg'] = "Password Updated Successfully!";
                        $new_pass = $c_new_pass = null;
?>
                        <script>
                            setInterval(function() {

                                <?php
                                header("location: register");
                                unset($_SESSION['activation_msg']);
                                ?>

                            })
                        </script>


<?php
                    } else {
                        $error_verify = "Something Went Wrong!";
                    }
                }
            }
        }
    }
}
