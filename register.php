<?php
include_once('./includes/header.php')
?>
<section class="form_section">
    <div class="login_section">
        <!-- sign in section -->
        <div class="form_box login">
            <form action="">
                <h2>Sign In</h2>
                <!-- email -->
                <div class="input_box">
                    <span class="icon">
                        <i class='bx bxs-envelope'></i>
                    </span>
                    <input type="email" name="" id="email" required>
                    <label for="email">Email</label>
                </div>
                <!-- password -->
                <div class="input_box">
                    <span class="icon">
                        <i class='bx bxs-lock'></i>
                    </span>
                    <input type="password" name="" id="password" required>
                    <label for="password">Password</label>
                </div>
                <div class="remmember_password">
                    <label for="checkbox"><input type="checkbox" id="checkbox">Remmember Me</label>
                    <a href="#">Forget Password</a>
                </div>
                <button class="btn">Log In</button>
                <div class="create_account">
                    <p><a href="./"><i class='bx bx-arrow-back'></i>back</a></p>
                    <p>Create an Account? <a href="javascript:void(0)" class="sign_up">Sign Up</a></p>
                </div>
            </form>
        </div>
        <!-- sign up section -->
        <div class="form_box register">
            <form action="">
                <h2>Sign Up</h2>
                <!-- email -->
                <div class="input_box">
                    <span class="icon">
                        <i class='bx bxs-envelope'></i>
                    </span>
                    <input type="email" name="" id="r_email" required>
                    <label for="r_email">Email</label>
                </div>
                <!-- password -->
                <div class="input_box">
                    <span class="icon">
                        <i class='bx bxs-lock'></i>
                    </span>
                    <input type="password" name="" id="r_password" required>
                    <label for="r_password">Password</label>
                </div>
                <!-- confirm password -->
                <div class="input_box">
                    <span class="icon">
                        <i class='bx bxs-lock'></i>
                    </span>
                    <input type="password" name="" id="c_password" required>
                    <label for="c_password">Confirm Password</label>
                </div>
                <button class="btn">Sign Up</button>
                <div class="create_account">
                    <p><a href="./"><i class='bx bx-arrow-back'></i>back</a></p>
                    <p>Already have an Account? <a href="javascript:void(0)" class="sign_in">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
<?php
include_once('./includes/footer.php')
?>