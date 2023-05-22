<?php
// session_start();
?>
<header id="navbar">
    <a href="./" class="logo"><img src="./assets/img/logo.png" alt=""></a>
    <div class="group">
        <ul class="navigation" id="nav_list">
            <li><a href="./" class="<?= basename($_SERVER['PHP_SELF']) == "index.php" ? "active" : null ?>">Home </a></li>
            <li><a href="javascript:void(0)" class="<?= basename($_SERVER['PHP_SELF']) == "about.php" ? "active" : null ?>">About</a></li>
            <li><a href=" javascript:void(0)" class="<?= basename($_SERVER['PHP_SELF']) == "service.php" ? "active" : null ?>">Service</a></li>
            <li><a href=" javascript:void(0)" class="<?= basename($_SERVER['PHP_SELF']) == "blog.php" ? "active" : null ?>">Blog</a></li>
            <li class="d-md-none"><a href="updateProfile" class="<?= basename($_SERVER['PHP_SELF']) == "updateProfile.php" ? "active" : null ?>">Update Profile</a></li>
            <?php
            if (isset($_SESSION['student_login'])) {
            ?>
                <li><a href="destroy"><img src="./assets/img/logout.png" />Log Out</a></li>
            <?php
            }
            ?>
        </ul>

        <!-- profile picture -->
        <div class="profile_pic">
            <a href="updateProfile" class="ms-3 <?= basename($_SERVER['PHP_SELF']) == "updateProfile.php" ? "active" : null ?>"> <img src="assets/img/blank_pic.png" alt="profile_picture" class="rounded-circle pointer "></a>
        </div>

        <!-- search icon -->
        <div class="search">
            <div class="icon text-white">
                <i class='bx bx-search-alt-2 search_btn'></i>
                <i class='bx bx-x close_btn'></i>
            </div>
        </div>
        <div class="manu_toggle">
            <span class="text-white">
                <i class='bx bx-list-ul open_manu'></i>
                <i class='bx bx-message-square-x colse_manu d-none'></i>
            </span>
        </div>
    </div>
    <div class="search_box">
        <input type="text" placeholder="Search here . . . .">
    </div>

</header>