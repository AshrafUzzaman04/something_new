<?php
include_once("./connection.php");
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

// image upload validation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['file_email'])) {
    $file_email =  $_POST['file_email'];
    $file_name =  $_FILES['profile_img']['name'];
    $tmp_name =  $_FILES['profile_img']['tmp_name'];

    $alph = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $session_email =  $_SESSION['student_login']['student_email'];
    $selectPreUserData = $conn->query("SELECT * FROM `students` WHERE `student_email` = '$session_email'");
    $fetch =  $selectPreUserData->fetch_object();
    $user_id = $fetch->student_id;
    $user_img = $fetch->img;
    $uniqeName = substr(str_shuffle($alph), 0, 8) . uniqid() . rand(100000, 999999) . date("YmdHis") . "." . $ext;
    $destination = "./assets/img/users/$user_id/$uniqeName";
    $path = "./assets/img/users/" . $user_id . "/" . $user_img;

    if (empty($tmp_name)) {
        $err_img = "Please upload an image.";
    } elseif (!getimagesize($tmp_name)) {
        $err_img = "Select a valid image file!";
    } else {
        if ($selectPreUserData->num_rows != 1) {
            $err_img = "User Data not found!";
        } else {
            if ($user_img != null && $user_img != "") {
                unlink($path);
            }
            (!is_dir("./assets/img/users/$user_id")) ? mkdir("./assets/img/users/$user_id") : null;
            $move =  move_uploaded_file($tmp_name, $destination);
            if (!$move) {
                $err_img = "Images uploaded failed.";
            } else {
                $update_img = $conn->query("UPDATE `students` SET `img` = '$uniqeName' WHERE  `student_id` = '$user_id'");

                if ($update_img) {
                    $success_img = "Images uploaded successfully.";
                    $_SESSION['student_login']['img'] = $uniqeName;
                    echo "<script>
                    setTimeout(function() {
                        window.location.href = './updateProfile';
                      }, 4000);
                    </script>";
                } else {
                    $err_img = "Images uploaded failed.";
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatePro123'])) {
    $studentName = mysqli_real_escape_string($conn, sefuda($_POST['studentName']));
    $studentMobileNo = mysqli_real_escape_string($conn, sefuda($_POST['studentMobileNo']));
    $studentEmail = mysqli_real_escape_string($conn, sefuda($_POST['studentEmail']));
    $studentPassword = mysqli_real_escape_string($conn, sefuda($_POST['studentPassword']));
    $studentGender = mysqli_real_escape_string($conn, sefuda(($_POST['studentGender'] ?? null)));
    $studentSubject = mysqli_real_escape_string($conn, sefuda(($_POST['studentSubject'] ?? null)));
    // location information
    $divisionSelect = mysqli_real_escape_string($conn, sefuda(($_POST['divisionSelect']) ?? null));
    $districtSelect = mysqli_real_escape_string($conn, sefuda(($_POST['districtSelect']) ?? null));


    $gender_array = array("Male", "Female", "Other");
    $divisionSelect_array = ["Barisal", "Chattogram", "Dhaka", "Khulna", "Mymensingh", "Rajshahi", "Rangpur", "Sylhet"];
    $districtSelect_array = ['Pirojpur', 'Jhalakati', 'Barishal', 'Bhola', 'Patuakhali', 'Barguna', 'Brahmanbaria', 'Cumilla', 'Chandpur', 'Lakshmipur', 'Noakhali', 'Feni', 'Chattogram', 'Cox’s Bazar', 'Khagrachhari', 'Rangamati', 'Bandarban', 'Tangail', 'Kishoreganj', 'Manikganj', 'Dhaka', 'Noakhali', 'Gazipur', 'Narsinghdi', 'Narayanganj', 'Munshiganj', 'Faridpur', 'Rajbari', 'Gopalganj', 'Madaripur', 'Shariatpur', 'Kushtia', 'Meherpur', 'Chuadanga', 'Jhenaidah', 'Magura', 'Narail', 'Jashore', 'Satkhira', 'Khulna', 'Bagerhat', 'Netrokona', 'Mymensingh', 'Sherpur', 'Jamalpur', 'Joypurhat', 'Bogura', 'Naogaon', 'Natore', 'Nawabganj', 'Rajshahi', 'Sirajganj', 'Pabna', 'Panchagar', 'Thakurgaon', 'Dinajpur', 'Nilphamari', 'Lalmonirhat', 'Rangpur', 'Kurigram', 'Gaibandha', 'Sunamganj', 'Sylhet', 'Moulvibazar', 'Habiganj'];
    $studentSubject_array = ["Web Design", "Web Development"];


    // name validation
    if (empty($studentName)) {
        $error_studentName = "The name field cannot be empty!";
    } elseif (!preg_match('/^[A-Za-z. ]*$/', $studentName)) {
        $error_studentName = "Invalid username!";
    } else {
        $correct_studentName = mysqli_real_escape_string($conn, $studentName);
    }

    // mobile number validation
    if (empty($studentMobileNo)) {
        $error_studentMobileNo = "Enter your mobile number!";
    } elseif (!preg_match('/^[0-9]{11}+$/', $studentMobileNo)) {
        $error_studentMobileNo = "Invalid mobile number!";
    } elseif (!filter_var($studentMobileNo, FILTER_VALIDATE_INT)) {
        $error_studentMobileNo = "Invalid mobile number!";
    } elseif (!is_int($studentMobileNo)) {
        $error_studentMobileNo = "Invalid mobile number!";
    } elseif ($studentMobileNo < 11) {
        $error_studentMobileNo = "Your mobile number must be 11 characters long!";
    } else {
        $correct_studentMobileNo = mysqli_real_escape_string($conn, $studentMobileNo);
    }

    // email validation
    if (empty($studentEmail)) {
        $error_studentEmail = "The email field cannot be empty!";
    } elseif (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
        $error_studentEmail = "Invalid Email Address!";
    } else {
        $correct_studentEmail = mysqli_real_escape_string($conn, $studentEmail);
    }


    // password validation
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    if (isset($studentPassword) && !empty($studentPassword)) {
        if (!$uppercase || !$lowercase) {
            $error_studentPassword =  "Password selection by combining uppercase and lowercase letters!";
        } elseif (!$number) {
            $error_studentPassword =  "Your password must contain a number";
        } elseif ($studentPassword < 8) {
            $error_studentPassword = "Your password must be 8 characters long!";
        } else {
            $correct_studentPassword = mysqli_real_escape_string($conn, $studentPassword);
        }
    }

    // gender validation
    if (!in_array($studentGender, $gender_array)) {
        $error_studentGender = "Gender can't find!";
    } elseif ($studentGender != "Male" && $studentGender != "Female" && $studentGender != "Other") {
        $error_studentGender = "Gender can't find!";
    } else {
        $correct_studentGender = mysqli_real_escape_string($conn, $studentGender);
    }


    // location validation
    if (!in_array($divisionSelect, $divisionSelect_array)) {
        $error_divisionSelect = "Your Division can't find! try again.";
    } elseif (isset($divisionSelect)) {
        if (empty($districtSelect)) {
            $error_districtSelect = "Please select a your District afters electing Division!";
        } elseif (!in_array($districtSelect, $districtSelect_array)) {
            $error_districtSelect = "Your District can't find! try again.";
        } else {
            $correct_divisionSelect = mysqli_real_escape_string($conn, $divisionSelect);
            $correct_districtSelect = mysqli_real_escape_string($conn, $districtSelect);
        }
    }


    // student subject validation
    if (!in_array($studentSubject, $studentSubject_array)) {
        $error_studentSubject = "Your Selected subject can't find! try again.";
    } else {
        $correct_studentSubject = mysqli_real_escape_string($conn, $studentSubject);
    }


    if ((isset($correct_studentName) || isset($correct_studentMobileNo) || isset($correct_studentPassword) || isset($correct_studentGender) || isset($correct_studentSubject)) || (isset($correct_divisionSelect) && isset($correct_districtSelect))  && (isset($correct_studentEmail))) {
        $pre_email = $_SESSION['student_login']['student_email'];
        $query = "SELECT * FROM `students` WHERE `student_email` = '$pre_email'";
        $fetch_email_query = $conn->query($query);

        if ($fetch_email_query->num_rows > 0 && $fetch_email_query->num_rows == 1) {
        }
    }
}

?>
<!-- update body section started here -->
<section class="update_yourSelf">
    <div class="update_form">
        <form method="POST" enctype="multipart/form-data" id="imgUploadForm">
            <!-- profile picture section -->
            <div class="blur_image_bg mx-auto">
                <div class="inner">
                    <input type="hidden" name="file_email" value="<?= $_SESSION['student_login']['student_email'] ?>">
                    <?php
                    $session_email =   $_SESSION['student_login']['student_email'];
                    $session_img = $_SESSION['student_login']['img'];
                    $selectPreUserData = $conn->query("SELECT * FROM `students` WHERE `student_email` = '$session_email'");
                    $fetch = $selectPreUserData->fetch_object();
                    $user_id = $fetch->student_id;
                    ?>
                    <img src="./assets/img/users/<?php
                                                    if (isset($session_img) &&  $session_img != null && $session_img != "") {
                                                        echo $user_id . "/" .  $session_img;
                                                    } else {
                                                        echo "blank_pic.png";
                                                    } ?>" alt="" id="previewImage">
                    <input type="file" id="pp_img" name="profile_img" class="d-none">
                    <button type="button"><label for="pp_img"><i class="fa-regular fa-image"></i></label></button>
                </div>
                <div class="bg"></div>
            </div>
        </form>
        <div class="text-center mt-3">
            <span class="text-danger"><?= $err_img ?? null ?></span>
            <span class="text-success"><?= $success_img ?? null ?></span>
        </div>


        <form method="POST">

            <!-- other input section started here -->
            <div class="form_body_input">

                <!-- student name -->
                <div class="grid">
                    <div class="wave-group">
                        <input value="<?= $studentName ?? $_SESSION['student_login']['student_name'] ??  null ?>" type="text" name="studentName" placeholder="Name" class="input">
                        <span class="bar"></span>
                        <span class="text-danger"><?= $error_studentName ?? null ?></span>
                    </div>

                    <!-- student mobile -->
                    <div class="wave-group">
                        <input type="text" value="<?= $studentMobileNo ?? $_SESSION['student_login']['student_mobile'] ??  null ?>" name="studentMobileNo" class="input" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="11" placeholder="Mobile">
                        <span class="bar"></span>
                        <span class="text-danger"><?= $error_studentMobileNo ?? null ?></span>
                    </div>

                    <!-- student email -->
                    <div class="wave-group">
                        <input required="" type="email" name="studentEmail" class="input" value="<?= $studentEmail  ?? $_SESSION['student_login']['student_email'] ??  null ?>">
                        <span class="bar"></span>
                        <label class="label">
                            <span class="label-char" style="--index: 0">E</span>
                            <span class="label-char" style="--index: 1">m</span>
                            <span class="label-char" style="--index: 2">a</span>
                            <span class="label-char" style="--index: 3">i</span>
                            <span class="label-char" style="--index: 4">l</span>
                        </label>
                        <span class="text-danger"><?= $error_studentEmail ?? null ?></span>
                    </div>

                    <!-- student password -->
                    <div class="wave-group">
                        <input type="password" placeholder="New Password" value="<?= $studentPassword ?? null ?>" name=" studentPassword" class="input">
                        <span class="bar"></span>
                        <span class="text-danger"><?= $error_studentPassword ?? null ?></span>
                    </div>
                </div>


                <div class="grid_2">
                    <!-- student gender -->
                    <div class="radio_gender mt-3 mb-1">
                        <div class="radio-container">
                            <h3 class="text-secondary">Gender</h3>
                            <div class="radio-wrapper">
                                <label class="radio-button">
                                    <input <?= (isset($studentGender) && $studentGender == "Male") ? "checked" : null ?> <?= (!isset($studentGender) && $_SESSION['student_login']['student_gender'] == "Male") ? "checked" : null ?> type="radio" name="studentGender" id="option1" value="Male">
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Male</span>
                                </label>
                            </div>

                            <div class="radio-wrapper">
                                <label class="radio-button">
                                    <input type="radio" <?= (isset($studentGender) && $correct_studentGender == "Female") ? "checked" : null ?> <?= !isset($studentGender) && $_SESSION['student_login']['student_gender'] == "Female" ? "checked" : null ?> name="studentGender" id="option2" value="Female">
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Female</span>
                                </label>
                            </div>

                            <div class="radio-wrapper">
                                <label class="radio-button">
                                    <input <?= (isset($studentGender) && $correct_studentGender == "Other") ? "checked" : null ?> <?= !isset($studentGender) && $_SESSION['student_login']['student_gender'] == "Other" ? "checked" : null ?> type="radio" name="studentGender" id="option3" value="Other">
                                    <span class="radio-checkmark"></span>
                                    <span class="radio-label">Other</span>
                                </label>
                            </div>
                        </div>
                        <span class="text-danger"><?= $error_studentGender ?? null ?></span>

                    </div>


                    <!-- student location -->
                    <div class="your_location">
                        <h3 class="text-secondary">Location</h3>
                        <select name="divisionSelect" class="form-select" aria-label="Default select example" onchange="myDivision(this.value)">
                            <?php
                            $division = $_SESSION['student_login']['student_division'] ?? null;
                            $district = $_SESSION['student_login']['student_district'] ?? null;
                            ?>
                            <option selected> -- Division -- </option>

                            <option value="Barisal" <?= isset($divisionSelect) && $divisionSelect == "Barisal" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Barisal") ? "selected" : null ?>>Barisal</option>

                            <option value="Chattogram" <?= isset($divisionSelect) && $divisionSelect == "Chattogram" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Chattogram") ? "selected" : null ?>>Chattogram</option>

                            <option value="Dhaka" <?= isset($divisionSelect) && $divisionSelect == "Dhaka" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Dhaka") ? "selected" : null ?>>Dhaka</option>

                            <option value="Khulna" <?= isset($divisionSelect) && $divisionSelect == "Khulna" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Khulna") ? "selected" : null ?>>Khulna</option>

                            <option value="Mymensingh" <?= isset($divisionSelect) && $divisionSelect == "Mymensingh" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Mymensingh") ? "selected" : null ?>>Mymensingh</option>

                            <option value="Rajshahi" <?= isset($divisionSelect) && $divisionSelect == "Rajshahi" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Rajshahi") ? "selected" : null ?>>Rajshahi</option>

                            <option value="Rangpur" <?= isset($divisionSelect) && $divisionSelect == "Rangpur" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Rangpur") ? "selected" : null ?>>Rangpur</option>

                            <option value="Sylhet" <?= isset($divisionSelect) && $divisionSelect == "Sylhet" ? "selected" : null ?> <?= ((!isset($divisionSelect)) && $division == "Sylhet") ? "selected" : null ?>>Sylhet</option>

                        </select>
                        <select name="districtSelect" class="form-select" aria-label="Default select example" id="showingDistrict">
                            <option selected> -- District -- </option>
                        </select>
                        <br>
                        <span class="text-danger"><?= $error_divisionSelect ?? $error_districtSelect ?? null ?></span>
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
                    <span class="text-danger"><?= $error_studentSubject ?? null ?></span>
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

<script>
    const pp_img = document.getElementById("pp_img");
    const imgUploadForm = document.getElementById("imgUploadForm");

    pp_img.addEventListener("change", () => {
        imgUploadForm.submit();
    });
</script>
<?php
include_once("./includes/footer.php");
