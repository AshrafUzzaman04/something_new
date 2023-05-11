<?php
include_once("./includes/header.php");
include_once("./includes/nav.php");
(!isset($_SESSION['student_login'])) ? header("location: ./register") : null;

function sefuda($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST['updatePro123'])) {
    $pp_img = sefuda(mysqli_real_escape_string($conn, $_FILES['profile_img']));
    $studentName = sefuda(mysqli_real_escape_string($conn, $_POST['studentName']));
    $studentMobileNo = sefuda(mysqli_real_escape_string($conn, $_POST['studentMobileNo']));
    $studentEmail = sefuda(mysqli_real_escape_string($conn, $_POST['studentEmail']));
    $studentPassword = sefuda(mysqli_real_escape_string($conn, $_POST['studentPassword']));
    $studentGender = sefuda(mysqli_real_escape_string($conn, ($_POST['studentGender'] ?? null)));
    $studentSubject = sefuda(mysqli_real_escape_string($conn, ($_POST['studentSubject'] ?? null)));
    // location information
    $divisionSelect = sefuda(mysqli_real_escape_string($conn, ($_POST['divisionSelect']) ?? null));
    $districtSelect = sefuda(mysqli_real_escape_string($conn, ($_POST['districtSelect']) ?? null));


    $gender_array = array("Male", "Female", "Other");
    $divisionSelect_array = ["Barisal", "Chattogram", "Dhaka", "Khulna", "Mymensingh", "Rajshahi", "Rangpur", "Sylhet"];
    $districtSelect_array = ['Pirojpur', 'Jhalakati', 'Barishal', 'Bhola', 'Patuakhali', 'Barguna', 'Brahmanbaria', 'Cumilla', 'Chandpur', 'Lakshmipur', 'Noakhali', 'Feni', 'Chattogram', 'Cox’s Bazar', 'Khagrachhari', 'Rangamati', 'Bandarban', 'Tangail', 'Kishoreganj', 'Manikganj', 'Dhaka', 'Noakhali', 'Gazipur', 'Narsinghdi', 'Narayanganj', 'Munshiganj', 'Faridpur', 'Rajbari', 'Gopalganj', 'Madaripur', 'Shariatpur', 'Kushtia', 'Meherpur', 'Chuadanga', 'Jhenaidah', 'Magura', 'Narail', 'Jashore', 'Satkhira', 'Khulna', 'Bagerhat', 'Netrokona', 'Mymensingh', 'Sherpur', 'Jamalpur', 'Joypurhat', 'Bogura', 'Naogaon', 'Natore', 'Nawabganj', 'Rajshahi', 'Sirajganj', 'Pabna', 'Panchagar', 'Thakurgaon', 'Dinajpur', 'Nilphamari', 'Lalmonirhat', 'Rangpur', 'Kurigram', 'Gaibandha', 'Sunamganj', 'Sylhet', 'Moulvibazar', 'Habiganj'];
    $studentSubject_array = ["Web Design", "Web Development"];


    // name validation
    if (!preg_match('/^[A-Za-z. ]*$/', $studentName)) {
        $error_studentName = "Invalid username!";
    } else {
        $correct_studentName = mysqli_real_escape_string($conn, $studentName);
    }

    // mobile number validation
    if (!preg_match('/^[0-9]{11}+$/', $studentMobileNo)) {
        $error_studentMobileNo = "Invalid mobile number!";
    } elseif (!is_int($studentMobileNo)) {
        $error_studentMobileNo = "Invalid mobile number!";
    } else {
        $correct_studentMobileNo = mysqli_real_escape_string($conn, $studentMobileNo);
    }

    // email validation
    if (!preg_match($studentEmail, FILTER_VALIDATE_EMAIL)) {
        $error_studentEmail = "Invalid Email Address!";
    } else {
        $correct_studentEmail = mysqli_real_escape_string($conn, $studentEmail);
    }


    // password validation
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    if (empty($studentPassword)) {
        $error_studentPassword = "Password Field can't empty!";
    } elseif ($studentPassword < 8) {
        $error_studentPassword = "Your password must be 8 characters long!";
    } elseif (!$uppercase || !$lowercase) {
        $error_studentPassword =  "Password selection by combining uppercase and lowercase letters!";
    } elseif ($number) {
        $error_studentPassword =  "There must be a number on the lower side";
    } else {
        $correct_studentPassword = mysqli_real_escape_string($conn, $studentPassword);
    }

    // gender validation
    if (empty($studentGender)) {
        $error_studentGender = "Fill the gender field!";
    } elseif (!in_array($studentGender, $gender_array)) {
        $error_studentGender = "Gender can't find!";
    } elseif ($studentGender !== "Male" && $studentGender !== "Female" && $studentGender !== "Other") {
        $error_studentGender = "Gender can't find!";
    } else {
        $correct_studentGender = mysqli_real_escape_string($conn, $studentGender);
    }


    // location validation
    if (empty($divisionSelect)) {
        $error_divisionSelect = "Please select a your Division!";
    } elseif (!in_array($divisionSelect, $divisionSelect_array)) {
        $error_divisionSelect = "Your Division can't find! try again.";
    } elseif (empty($districtSelect)) {
        $error_districtSelect = "Please select a your District after selecting Division!";
    } elseif (!in_array($districtSelect, $districtSelect_array)) {
        $error_districtSelect = "Your District can't find! try again.";
    } else {
        $correct_divisionSelect = mysqli_real_escape_string($conn, $divisionSelect);
        $correct_districtSelect = mysqli_real_escape_string($conn, $districtSelect);
    }


    // student subject validation
    if (empty($studentSubject)) {
        $error_studentSubject = "Select your subject!";
    } elseif (!in_array($studentSubject, $studentSubject_array)) {
        $error_studentSubject = "Your Selected subject can't find! try again.";
    } else {
        $correct_studentSubject = mysqli_real_escape_string($conn, $studentSubject);
    }


    if ((isset($correct_studentName) && isset($correct_studentMobileNo) && isset($correct_studentEmail) && isset($correct_studentPassword) && isset($correct_studentGender) && isset($correct_divisionSelect) && isset($correct_districtSelect) && isset($correct_studentSubject))) {
    }
}

?>
<!-- update body section started here -->
<section class="update_yourSelf">
    <div class="update_form">
        <form action="" method="POST" enctype="multipart/form-data">

            <!-- profile picture section -->
            <div class="blur_image_bg mx-auto" data-tilt>
                <div class="inner">
                    <img src="./assets/img/blank_pic.png" alt="">
                    <input type="file" id="pp_img" name="profile_img" class="d-none">
                    <label for="pp_img"><i class="fa-regular fa-image"></i></label>
                </div>
                <div class="bg"></div>
            </div>

            <!-- other input section started here -->
            <div class="form_body_input">

                <!-- student name -->
                <div class="grid">
                    <div class="wave-group">
                        <input required="" type="text" name="studentName" class="input">
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
                        <input required="" type="text" name="studentMobileNo" class="input" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="11">
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
                        <input required="" type="email" name="studentEmail" class="input" value="<?= $_SESSION['student_login']['student_email'] ?>">
                        <span class="bar"></span>
                        <label class="label">
                            <span class="label-char" style="--index: 0">E</span>
                            <span class="label-char" style="--index: 1">m</span>
                            <span class="label-char" style="--index: 2">a</span>
                            <span class="label-char" style="--index: 3">i</span>
                            <span class="label-char" style="--index: 4">l</span>
                        </label>
                    </div>

                    <!-- student password -->
                    <div class="wave-group">
                        <input required="" type="password" name="studentPassword" class="input">
                        <span class="bar"></span>
                        <label class="label">
                            <span class="label-char" style="--index: 0">P</span>
                            <span class="label-char" style="--index: 1">a</span>
                            <span class="label-char" style="--index: 2">s</span>
                            <span class="label-char" style="--index: 3">s</span>
                            <span class="label-char" style="--index: 4">w</span>
                            <span class="label-char" style="--index: 5">o</span>
                            <span class="label-char" style="--index: 6">r</span>
                            <span class="label-char" style="--index: 7">d</span>
                        </label>
                    </div>
                </div>


                <div class="grid_2">
                    <!-- student gender -->
                    <div class="radio_gender mt-3 mb-1">
                        <div class="radio-container">
                            <h3 class="text-secondary">Gender</h3>
                            <div class="radio-wrapper">
                                <label class="radio-button">
                                    <input type="radio" name="studentGender" id="option1" value="Male" <?= $_SESSION['student_login']['student_gender'] == "Male" ? "checked" : null ?>>
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Male</span>
                                </label>
                            </div>

                            <div class="radio-wrapper">
                                <label class="radio-button">
                                    <input type="radio" name="studentGender" id="option2" value="Female" <?= $_SESSION['student_login']['student_gender'] == "Female" ? "checked" : null ?>>
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Female</span>
                                </label>
                            </div>

                            <div class="radio-wrapper">
                                <label class="radio-button">
                                    <input type="radio" name="studentGender" id="option3" value="Other" <?= $_SESSION['student_login']['student_gender'] == "Other" ? "checked" : null ?>>
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Other</span>
                                </label>
                            </div>
                        </div>

                    </div>


                    <!-- student location -->
                    <div class="your_location">
                        <h3 class="text-secondary">Location</h3>
                        <select name="divisionSelect" class="form-select" aria-label="Default select example" onchange="myDivision(this.value)">
                            <option selected> -- Division -- </option>
                            <option value="Barisal">Barisal</option>
                            <option value="Chattogram">Chattogram</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Khulna">Khulna</option>
                            <option value="Mymensingh">Mymensingh</option>
                            <option value="Rajshahi">Rajshahi</option>
                            <option value="Rangpur">Rangpur</option>
                            <option value="Sylhet">Sylhet</option>
                        </select>
                        <select name="districtSelect" class="form-select" aria-label="Default select example" id="showingDistrict">
                            <option selected> -- District -- </option>
                        </select>
                    </div>
                </div>

                <!-- student subject -->
                <div class="subject_check mt-1">
                    <h3 class="text-secondary">Your Subject</h3>

                    <!-- checkbox one -->
                    <div class="checkbox-wrapper-12">
                        <div class="cbx">
                            <input id="cbx-12" type="checkbox" value="Web Design" name="studentSubject">
                            <label for=" cbx-12"></label>
                            <svg width="13" height="12" viewBox="0 0 15 14" fill="none">
                                <path d="M2 8.36364L6.23077 12L13 2"></path>
                            </svg>
                            <span class="sub_name">Web Design</span>
                        </div>
                    </div>

                    <!-- checkbox 2 -->
                    <div class="checkbox-wrapper-12">
                        <div class="cbx">
                            <input id="cbx-12" type="checkbox" value="Web Development" name="studentSubject">
                            <label for="cbx-12"></label>
                            <svg width="13" height="12" viewBox="0 0 15 14" fill="none">
                                <path d="M2 8.36364L6.23077 12L13 2"></path>
                            </svg>
                            <span class="sub_name">Web Development</span>
                        </div>
                    </div>
                </div>
                <!-- button for update -->
                <div class="update_btn">
                    <button type="submit" name="updatePro123">Update</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- ajax cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- vanilla tilt js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js" integrity="sha512-RX/OFugt/bkgwRQg4B22KYE79dQhwaPp2IZaA/YyU3GMo/qY7GrXkiG6Dvvwnds6/DefCfwPTgCXnaC6nAgVYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    VanillaTilt.init(document.querySelector(".blur_image_bg"), {
        max: 25,
        speed: 400
    });
</script>


<!-- select location using ajax javascript -->
<script>
    function myDivision(data) {

        const ajaxrequest = new XMLHttpRequest();
        ajaxrequest.open('GET', 'http://localhost/something_new/validation?selectDistrict=' + data, 'TRUE');
        ajaxrequest.send();

        ajaxrequest.onreadystatechange = function() {
            if (ajaxrequest.readyState == 4 && ajaxrequest.status == 200) {
                document.getElementById("showingDistrict").innerHTML = ajaxrequest.responseText;
            }
        }
    }
</script>
<?php
include_once("./includes/footer.php");
