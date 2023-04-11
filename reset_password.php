<?php
include_once("./connection.php");
include_once("./includes/header.php");

((!isset($_SESSION['activation_msg'])) && ((!isset($_GET['confirm_t'])) || ($_GET['confirm_t'] == ''))) ? header("location:javascript://history.go(-1)") : null;

// when user click the update button then include the validation page
($_SERVER['REQUEST_METHOD'] === "POST" ||  isset($_POST['updatepass123'])) ? include_once("./validation.php") : null;
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
                    <input type="password" name="new_pass" placeholder="Password" id="new_pass">
                    <label for="new_pass"><i class='bx bxs-lock'></i> New Password</label>
                </div>

                <!-- Confirm New Password -->
                <div class="input_box i-three">
                    <span class="icon">
                        <ion-icon name="eye-off-outline" id="c_new_pass_show" onclick="c_new_pass_toggle()"></ion-icon>
                        <ion-icon name="eye-outline" id="c_new_pass_hide" onclick="c_new_pass_toggle()"></ion-icon>
                    </span>
                    <input type="password" name="c_new_pass" placeholder="Confirm New Password" id="c_new_pass">
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