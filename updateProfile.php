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
            <div class="form_body_input bg-danger">
                <input type="text">
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
