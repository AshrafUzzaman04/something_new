<?php
include_once("./includes/header.php");
include_once("./includes/nav.php");
?>
<!-- update body section started here -->
<section class="update_yourSelf">
    <div class="update_form">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="blur_image_bg mx-auto" data-tilt>
                <div class="inner">
                    <img src="./assets/img/blank_pic.png" alt="">
                    <input type="file" id="pp_img" name="pp_img" class="d-none">
                    <label for="pp_img"><i class="fa-regular fa-image"></i></label>
                </div>
                <div class="bg"></div>
            </div>
            <div class="form_body_input">

                <!-- student name -->
                <div class="grid">
                    <div class="wave-group">
                        <input required="" type="text" class="input">
                        <span class="bar"></span>
                        <label class="label">
                            <span class="label-char" style="--index: 0">N</span>
                            <span class="label-char" style="--index: 1">a</span>
                            <span class="label-char" style="--index: 2">m</span>
                            <span class="label-char" style="--index: 3">e</span>
                        </label>
                    </div>

                    <!-- student mobile -->
                    <div class="wave-group">
                        <input required="" type="text" class="input">
                        <span class="bar"></span>
                        <label class="label">
                            <span class="label-char" style="--index: 0">M</span>
                            <span class="label-char" style="--index: 1">o</span>
                            <span class="label-char" style="--index: 2">b</span>
                            <span class="label-char" style="--index: 3">i</span>
                            <span class="label-char" style="--index: 4">l</span>
                            <span class="label-char" style="--index: 5">e</span>
                        </label>
                    </div>

                    <!-- student email -->
                    <div class="wave-group">
                        <input required="" type="text" class="input">
                        <span class="bar"></span>
                        <label class="label">
                            <span class="label-char" style="--index: 0">E</span>
                            <span class="label-char" style="--index: 1">m</span>
                            <span class="label-char" style="--index: 2">a</span>
                            <span class="label-char" style="--index: 3">i</span>
                            <span class="label-char" style="--index: 4">l</span>
                        </label>
                    </div>
                </div>


                <!-- student gender -->
                <div class="radio_gender mt-3 mb-1">
                    <div class="radio-container">
                        <h3 class="text-secondary">Gender</h3>
                        <div class="radio-wrapper">
                            <label class="radio-button">
                                <input type="radio" name="gender" value="Male">
                                <span class="radio-checkmark"></span>
                                <span class="radio-label">Male</span>
                            </label>
                        </div>

                        <div class="radio-wrapper">
                            <label class="radio-button">
                                <input type="radio" name="gender" id="option2" value="Female">
                                <span class="radio-checkmark"></span>
                                <span class="radio-label">Female</span>
                            </label>
                        </div>

                        <div class="radio-wrapper">
                            <label class="radio-button">
                                <input type="radio" name="gender" id="option3" value="Other">
                                <span class="radio-checkmark"></span>
                                <span class="radio-label">Other</span>
                            </label>
                        </div>
                    </div>

                </div>


                <!-- student location -->
                <div class="your_location">
                    <h3 class="text-secondary">Location</h3>
                    <select class="form-select" aria-label="Default select example">
                        <option selected> -- Division -- </option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <select class="form-select" aria-label="Default select example">
                        <option selected> -- District -- </option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>

                <!-- student subject -->
                <div class="subject_check mt-1">
                    <h3 class="text-secondary">Your Subject</h3>

                    <!-- checkbox one -->
                    <div class="checkbox-wrapper-12">
                        <div class="cbx">
                            <input id="cbx-12" type="checkbox">
                            <label for="cbx-12"></label>
                            <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                <path d="M2 8.36364L6.23077 12L13 2"></path>
                            </svg>
                            <span>Web Development</span>
                        </div>
                    </div>

                    <!-- checkbox 2 -->
                    <div class="checkbox-wrapper-12">
                        <div class="cbx">
                            <input id="cbx-12" type="checkbox">
                            <label for="cbx-12"></label>
                            <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                <path d="M2 8.36364L6.23077 12L13 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <button>Update</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- vanilla tilt js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js" integrity="sha512-RX/OFugt/bkgwRQg4B22KYE79dQhwaPp2IZaA/YyU3GMo/qY7GrXkiG6Dvvwnds6/DefCfwPTgCXnaC6nAgVYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    VanillaTilt.init(document.querySelector(".blur_image_bg"), {
        max: 25,
        speed: 400
    });
</script>
<?php
include_once("./includes/footer.php");
