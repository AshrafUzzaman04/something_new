<?php

include_once("./connection.php");
include_once("./includes/header.php");
?>
<section class="form_section">
    <div class="login_section">
        <!-- ================================================================ -->
        <!-- ======================= Recover Account =========================-->
        <!-- ================================================================ -->
        <div class="form_box login">
            <form action="<?= htmlentities(substr($_SERVER['PHP_SELF'], 0, -4)) ?>" method="POST">
                <h2>Recover Account</h2>
                <p class="text-center">Fill the data correctly.</p>

                <!-- email -->
                <div class="input_box <?= $error_email ? "invalid" : null ?>">
                    <input type="email" name="recov_Email" id="recov_email" placeholder="Email" class="<?= $error_email ? "invalid" : null ?>" value="">
                    <label for="recov_email"><i class='bx bxs-envelope'></i> Email</label>
                </div>

                <!-- submit -->
                <button class="btn" type="submit" name="recover123">Recover</button>

                <div class="create_account">
                    <p><a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i>back</a></p>
                    <p>Not have an Account? <a href="register" class="text-decoration-underline">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php

include_once("./includes/footer.php");
