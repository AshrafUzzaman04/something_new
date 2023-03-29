<?php
include_once('./includes/header.php');

$conn = mysqli_connect("localhost", "root", "", "something_new");

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

    // email is required
    if (empty($log_Email)) {
        $error_email = "Enter your email address";
    } elseif (!filter_var($log_Email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "Invalid email address";
    } else {
        $correct_email = $log_Email;
    }


    // password validation
    if (empty($log_Password)) {
        $error_pass = "Enter your password";
    } else {
        $correct_pass = $log_Password;
    }


    if (isset($correct_email) && isset($correct_pass)) {
        $verify_data = $conn->query("SELECT * FROM `students` WHERE `student_email` = '$correct_email' AND `student_pass` = '$correct_pass';");

        if ($verify_data->num_rows !== 1) {
            echo "<script>alert('fuck you')</script>";
        } else {
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
            <form action="<?= substr($_SERVER['PHP_SELF'], 0, -4) ?>" method="POST">
                <h2>Sign In</h2>

                <!-- email -->
                <div class="input_box <?= $error_email ? "invalid" : null ?>">
                    <input type="email" name="log_Email" id="email" placeholder="Email" class="<?= $error_email ? "invalid" : null ?>" value="<?= $log_Email ?? null ?>">
                    <label for="email"><i class='bx bxs-envelope'></i> Email</label>
                </div>

                <!-- password -->
                <div class="input_box <?= $error_pass ? "invalid" : null ?>">
                    <span class="icon">
                        <ion-icon name="eye-off-outline" id="show" onclick="toggle()"></ion-icon>
                        <ion-icon name="eye-outline" id="hide" onclick="toggle()"></ion-icon>
                    </span>
                    <input type="password" name="log_Password" id="password" placeholder="Password" class="<?= $error_pass ? "invalid" : null ?>" value="<?= $log_Password ?? null ?>">
                    <label for="password"><i class='bx bxs-lock'></i> Password</label>
                </div>
                <div class="remmember_password">
                    <label for="checkbox"><input type="checkbox" id="checkbox">Remmember Me</label>
                    <a href="#">Forget Password</a>
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
                    <p>Already have an Account? <a href="javascript:void(0)" class="sign_in">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- jquery cdn -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#register123').click(function() {
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
                        location.href = "./";
                    }, 1000)
                }
            }
        });
    });
</script>
<?php
include_once('./includes/footer.php')
?>