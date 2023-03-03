<header>
    <a href="./" class="logo"><img src="./assets/img/logo.png" alt=""></a>
    <div class="group">
        <ul class="navigation" id="nav_list">

            <li><a href="javascript:void(0)" class="<?= basename($_SERVER['PHP_SELF']) == "index.php" ? "active" : null ?>">Home </a></li>
            <li><a href="javascript:void(0)" class="<?= basename($_SERVER['PHP_SELF']) == "about.php" ? "active" : null ?>">About</a></li>
            <li><a href=" javascript:void(0)" class="<?= basename($_SERVER['PHP_SELF']) == "service.php" ? "active" : null ?>">Service</a></li>
            <li><a href=" javascript:void(0)" class="<?= basename($_SERVER['PHP_SELF']) == "blog.php" ? "active" : null ?>">Blog</a></li>
            <li><a href=" register"><img src="./assets/img/register.png" />Register</a></li>
        </ul>
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

<script>
    // navigation variables
    const search_btn = document.querySelector(".search_btn");
    const close_btn = document.querySelector(".close_btn");
    const search_box = document.querySelector(".search_box");
    const navigation = document.querySelector(".navigation");
    const manu_toggle = document.querySelector(".manu_toggle");
    const header = document.querySelector("header");
    const open_manu = document.querySelector(".open_manu");
    const colse_manu = document.querySelector(".colse_manu");


    search_btn.addEventListener("click", () => {
        search_box.classList.add("searchBox_active");
        close_btn.classList.add("search_btn_active");
        search_btn.classList.add("search_btn_active");
        manu_toggle.classList.add("hide");
        header.classList.remove("open");
    });
    close_btn.addEventListener("click", () => {
        search_box.classList.remove("searchBox_active");
        close_btn.classList.remove("search_btn_active");
        search_btn.classList.remove("search_btn_active");
        manu_toggle.classList.remove("hide");
    });
    open_manu.addEventListener("click", () => {
        header.classList.add("open");
        colse_manu.classList.remove("d-none");
        open_manu.classList.add("d-none");
    })
    colse_manu.addEventListener("click", () => {
        header.classList.remove("open");
        colse_manu.classList.add("d-none");
        open_manu.classList.remove("d-none");
    })
</script>