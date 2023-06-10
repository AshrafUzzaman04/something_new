<?php
include_once('./connection.php');
include_once('./includes/header.php');

isset($_SESSION['student_login']) ? header("location: ./") : null;

function sefuda($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);

    return $data;
}

// login form validation rules
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login123'])) {
    $log_Email = sefuda($_POST['log_Email']);
    $log_Password = sefuda($_POST['log_Password']);
    $remember_me = sefuda(($_POST['remember_me']) ?? null);

    // email is required
    if (empty($log_Email)) {
        $error_email = "Enter your email address";
    } elseif (!filter_var($log_Email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "Invalid email address";
    } else {
        $verify_data = $conn->query("SELECT * FROM `students` WHERE `student_email` = '$log_Email'");
        if ($verify_data->num_rows !== 1) {
            $error_email = "Email can't exist!";
        } else {
            $correct_email = mysqli_real_escape_string($conn, $log_Email);
        }
    }

    // password validation
    if (empty($log_Password)) {
        $error_pass = "Enter your password";
    } else {
        // fetch pass
        $fetch_hash_pass = $verify_data->fetch_assoc();
        $hash_pass = $fetch_hash_pass['student_pass'] ?? null;

        // decode and verify password
        $password_decode = password_verify($log_Password, $hash_pass);
        if ($password_decode) {
            $verify_data = $conn->query("SELECT * FROM `students` WHERE `student_pass` = '$hash_pass';");

            // active student 
            $verify_status = $conn->query("SELECT * FROM `students` WHERE `student_email` = '$log_Email' AND `student_status` = 'active';");
            if ($verify_data->num_rows !== 1) {
                $error_pass = "Incorrect password!";
            } elseif ($verify_status->num_rows !== 1) {
                $error_email = "Activate ID through the link sent in Gmail!";
            } else {
                $correct_pass = mysqli_real_escape_string($conn, $log_Password);
            }
        } else {
            $error_pass = "Incorrect password!";
        }
    }


    if (isset($correct_email) && isset($correct_pass)) {
        $select_for_session = $conn->query("SELECT * FROM `students` WHERE  `student_email` = '$correct_email'");

        $fetch_this = mysqli_fetch_assoc($select_for_session);
        $student_email = $fetch_this['student_email'];
        $student_gender = $fetch_this['student_gender'];
        $student_img = $fetch_this['img'] ?? null;

        if (isset($remember_me)) {
            // setcookie
            setcookie('emailcookie', $correct_email, time() + 86400);
            setcookie('passwordcookie', $correct_pass, time() + 86400);
            $_SESSION['student_login'] = ["student_email" => $student_email, "student_gender" => $student_gender, "img" => $student_img];

            $log_Email = $log_Password = null;
            header("location:./");
            exit($mailSender);
        } else {
            $_SESSION['student_login'] = ["student_email" => $student_email, "student_gender" => $student_gender, "img" => $student_img];
            $log_Email = $log_Password = null;
            header("location:./");
        }
    }
}

// include_once("./includes/loadingp.php");
?>

<section class="form_section">
    <div class="login_section">
        <!-- ================================================================ -->
        <!-- ======================= sign in section =========================-->
        <!-- ================================================================ -->
        <div class="form_box login">
            <form action="<?= htmlentities(substr($_SERVER['PHP_SELF'], 0, -4)) ?>" method="POST">
                <h2>Sign In</h2>
                <!-- email -->
                <div class="input_box <?= $error_email ? "invalid" : null ?>">
                    <input type="email" name="log_Email" id="email" placeholder="Email" class="<?= $error_email ? "invalid" : null ?>" value="<?php

                                                                                                                                                if (isset($log_Email)) {
                                                                                                                                                    echo $log_Email;
                                                                                                                                                } else {
                                                                                                                                                    if (isset($_COOKIE['emailcookie'])) {
                                                                                                                                                        echo $_COOKIE['emailcookie'];
                                                                                                                                                    }
                                                                                                                                                } ?>">
                    <label for="email"><i class='bx bxs-envelope'></i> Email</label>
                </div>

                <!-- password -->
                <div class="input_box <?= $error_pass ? "invalid" : null ?>">
                    <span class="icon">
                        <ion-icon name="eye-off-outline" id="show" onclick="toggle()"></ion-icon>
                        <ion-icon name="eye-outline" id="hide" onclick="toggle()"></ion-icon>
                    </span>
                    <input type="password" name="log_Password" id="password" placeholder="Password" class="<?= $error_pass ? "invalid" : null ?>" value="<?php
                                                                                                                                                            if (isset($log_Password)) {
                                                                                                                                                                echo $log_Password;
                                                                                                                                                            } else {
                                                                                                                                                                if (isset($_COOKIE['passwordcookie'])) {
                                                                                                                                                                    echo $_COOKIE['passwordcookie'];
                                                                                                                                                                }
                                                                                                                                                            } ?>">
                    <label for="password"><i class='bx bxs-lock'></i> Password</label>
                </div>
                <div class="remmember_password">
                    <label for="checkbox"><input type="checkbox" id="checkbox" name="remember_me">Remmember Me</label>
                    <?php
                    $forget = "ABCDEFFGHIJKLMOPQRSTUVWXYZabcdefghijklmmnopqrstuvwxyz0123456789";
                    $forget = str_shuffle($forget);
                    $forget = strrev($forget);
                    $forget = rand() . $forget . str_shuffle(date("FdYDlhisHaA"));
                    ?>
                    <a href="recoveremail?forget_pass=<?= $forget ?>">Forget Password</a>
                </div>

                <!-- all error msg -->
                <div class="error_messege mb-3">
                    <strong class="text-danger"><?= ($error_email ?? $error_pass ?? null) ?></strong>
                </div>

                <!-- submit -->
                <button class="btn" type="submit" name="login123">Log In</button>

                <div class="create_account">
                    <p><a href="./"><i class='bx bx-arrow-back'></i>back</a></p>
                    <p>Create an Account? <a href="javascript:void(0)" class="sign_up">Sign Up</a></p>
                </div>
            </form>
        </div>
        <!-- ================================================================ -->
        <!-- ======================= sign up section =========================-->
        <!-- ================================================================ -->
        <div class="form_box register">
            <form action="" method="POST">
                <h2>Sign Up</h2>

                <!-- email -->
                <div class="input_box i-one">
                    <input type="email" name="register_email" placeholder="Email" id="r_email">
                    <label for="r_email"> <i class='bx bxs-envelope'></i> Email</label>
                </div>

                <!-- password -->
                <div class="input_box i-two">
                    <span class="icon">
                        <ion-icon name="eye-off-outline" id="s_show" onclick="s_toggle()"></ion-icon>
                        <ion-icon name="eye-outline" id="s_hide" onclick="s_toggle()"></ion-icon>
                    </span>
                    <input type="password" name="register_password" placeholder="Password" id="s_password">
                    <label for="s_password"><i class='bx bxs-lock'></i> Password</label>
                </div>

                <!-- confirm password -->
                <div class="input_box i-three">
                    <span class="icon">
                        <ion-icon name="eye-off-outline" id="scp_show" onclick="scp_toggle()"></ion-icon>
                        <ion-icon name="eye-outline" id="scp_hide" onclick="scp_toggle()"></ion-icon>
                    </span>
                    <input type="password" name="register_c_password" placeholder="Confirm Password" id="scp_password">
                    <label for="scp_password"><i class='bx bxs-lock'></i> Confirm Password</label>
                </div>

                <!-- all error msg -->
                <div class="error_messege mb-3">
                    <strong class="text-danger" id="error-msg"></strong>
                </div>
                <div class="success_msg mb-3">
                    <strong class="text-success" id="success-msg"></strong>
                </div>

                <button class="btn" type="button" id="register123">Sign Up</button>

                <div class="create_account">
                    <p><a href="./"><i class='bx bx-arrow-back'></i>back</a></p>
                    <p>Already have an Account? <a href="javascript:void(0)" class="sign_in" style="font-size: 20px;">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- jquery cdn -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#register123').click(function() {
        $('#register123').html('Sign Up <i style="font-size:20px;" class="fa-solid fa-spinner fa-spin"></i>');
        setTimeout(function() {
            $('#register123').html('Sign Up');
        }, 3000);
        var r_email = $('#r_email').val();
        var s_password = $('#s_password').val();
        var scp_password = $('#scp_password').val();
        $.ajax({
            type: "POST",
            url: "validation.php",
            data: {
                "register": "register",
                "r_email": r_email,
                "s_password": s_password,
                "scp_password": scp_password
            },
            success: function(data) {
                var data = JSON.parse(data);

                var error_for = data.error_for;
                var error_msg = data.msg;

                if (error_for === 1) {
                    $('.i-one').addClass('invalid');
                    $('#r_email').addClass('invalid');
                    $('#error-msg').html(error_msg);
                } else if (error_for === 2) {
                    $('.i-one').removeClass('invalid');
                    $('#r_email').removeClass('invalid');
                    $('.i-two').addClass('invalid');
                    $('#s_password').addClass('invalid');
                    $('#error-msg').html(error_msg);
                } else if (error_for === 3) {
                    $('.i-two').removeClass('invalid');
                    $('#s_password').removeClass('invalid');
                    $('.i-three').addClass('invalid');
                    $('#scp_password').addClass('invalid');
                    $('#error-msg').html(error_msg);
                } else {
                    $('.input_box').removeClass('invalid');
                    $('.input_box').children('input').removeClass('invalid');
                    $('#error-msg').remove();
                    $('#success-msg').html(error_msg);
                    setInterval(() => {
                        location.href = "./register";
                    }, 2500)
                }
            }
        });
    });
</script>
<?php
include_once('./includes/footer.php')
?>