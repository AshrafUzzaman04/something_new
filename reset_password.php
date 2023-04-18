<?php
include_once("./connection.php");
include_once("./includes/header.php");

(((!isset($_SESSION['activation_msg'])) || (!isset($_GET['email'])) || ($_GET['email'] !== $_SESSION['get_recover_email'])) && ((!isset($_GET['confirm_t'])) || ($_GET['confirm_t'] == ''))) ? header("location: ./") : null;

// when user click the update button then include the validation page
// ($_SERVER['REQUEST_METHOD'] === "POST" ||  isset($_POST['updatepass123'])) ? include_once("./validation.php") : null;

// update password setup
if (isset($_GET['confirm_t'])) {
    // reverse the get request
    $confirm_t = strrev($_GET['confirm_t']);

    $search_token = $conn->query("SELECT * FROM `students` WHERE `token` = '$confirm_t'");

    if ($search_token->num_rows !== 1 || $search_token->num_rows == 0) {

        $_SESSION['activation_msg'] = "Can't find your email address!";
        header("location: ./");
    } else {
        unset($_SESSION['get_recover_email']);

        $fetch_email = $search_token->fetch_assoc();
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
                        header("location: register");
                        unset($_SESSION['activation_msg']);
                    } else {
                        $error_verify = "Something Went Wrong!";
                    }
                }
            }
        }
    }
} else {
    $error_verify = "Verify your email address!";
}
?>

<section class="form_section">
    <div class="alert alert-success alert-dismissible fade show w-25 position-fixed bottom-0 end-0 p-4 pe-5 m-4" role="alert">
        <strong><?= $_SESSION['activation_msg'] ?? null ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="login_section">
        <!-- ================================================================ -->
        <!-- ======================= sign up section =========================-->
        <!-- ================================================================ -->
        <div class="form_box log-in">
            <form action="" method="POST">
                <h4 class="text-center">Create New Password</h4>

                <!-- password -->
                <div class="input_box i-two">
                    <span class="icon">
                        <ion-icon name="eye-off-outline" id="new_pass_show" onclick="new_pass_toggle()"></ion-icon>
                        <ion-icon name="eye-outline" id="new_pass_hide" onclick="new_pass_toggle()"></ion-icon>
                    </span>
                    <input type="password" name="new_pass" placeholder="Password" id="new_pass" value="<?= $new_pass ?? null ?>">
                    <label for="new_pass"><i class='bx bxs-lock'></i> New Password</label>
                </div>

                <!-- Confirm New Password -->
                <div class="input_box i-three">
                    <span class="icon">
                        <ion-icon name="eye-off-outline" id="c_new_pass_show" onclick="c_new_pass_toggle()"></ion-icon>
                        <ion-icon name="eye-outline" id="c_new_pass_hide" onclick="c_new_pass_toggle()"></ion-icon>
                    </span>
                    <input type="password" name="c_new_pass" placeholder="Confirm New Password" id="c_new_pass" value="<?= $c_new_pass ?? null ?>">
                    <label for="c_new_pass"><i class='bx bxs-lock'></i> Confirm New Password</label>
                </div>

                <!-- all error msg -->
                <div class="error_messege mb-3">
                    <strong class="text-danger" id="error-msg"><?= $error_new_pass ?? $error_c_new_pass  ?? $error_verify ?? null ?></strong>
                </div>

                <button class="btn" type="submit" id="updatepass123">Update Password</button>

                <div class="create_account">
                    <p><a href="javascript:history.back()"><i class='bx bx-arrow-back'></i>back</a></p>
                    <p>Have an Account? <a href="register" class="text-decoration-underline">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
include_once("./includes/footer.php");
?>