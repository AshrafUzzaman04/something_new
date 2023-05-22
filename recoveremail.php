<?php

include_once("./connection.php");

(!isset($_GET['forget_pass']) || $_GET['forget_pass'] == '') ? header("location: register") : null;
($_SERVER['REQUEST_METHOD'] === "POST" &&  isset($_POST['recover_email123'])) ? include_once("./validation.php") : null;
include_once("./includes/header.php");
?>
<section class="form_section">
    <div class="login_section">
        <!-- ================================================================ -->
        <!-- ======================= Recover email =========================-->
        <!-- ================================================================ -->
        <div class="form_box login">
            <form action="" method="POST">
                <h2>Recover Account</h2>
                <p class="text-center">Please fill email id properly.</p>

                <!-- email -->
                <div class="input_box <?= $error_recov_email ? "invalid" : null ?>">
                    <input type="email" name="recov_Email" id="recov_Email" placeholder="Email Address" class="<?= $error_recov_email ? "invalid" : null ?>" value="<?= $recov_Email ?? null ?>">
                    <label for="recov_Email"><i class='bx bxs-envelope'></i> Email Address</label>
                </div>

                <!-- all error msg -->
                <div class="error_messege mb-3">
                    <strong class="text-danger"><?= $error_recov_email ?? null ?></strong>
                </div>

                <!-- submit -->
                <button class="btn" type="submit" id="submit_recover_email123" name="recover_email123">Send Mail</button>

                <div class="create_account">
                    <p><a href="register"><i class='bx bx-arrow-back'></i>back</a></p>
                    <p>Have an Account? <a href="register" class="text-decoration-underline">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- jquery cdn -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    // on click the recover password button then added a new spinner font in html
    $('#submit_recover_email123').click(function() {
        $('#submit_recover_email123').html('Send Mail <i style="font-size:20px;" class="fa-solid fa-spinner fa-spin"></i>');
        setTimeout(function() {
            $('#submit_recover_email123').html('Send Mail');
        }, 3000);
    })
</script>

<?php

include_once("./includes/footer.php");
