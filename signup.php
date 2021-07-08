<?php
#
$_HAS_PAGE_ACCESS = true;
require "./config.php";
//
if (isset($_SESSION['User'])) {
    header("Location: ./");
    exit();
}

$page_title = "Diplomna Signup";
$page_description = "Here we signup";
$page_extra_css = "login";
$page_main_script = "signup";

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<?php require "./inc/partials/head.php"; ?>


<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div id="app-signup">

    <?php require "./inc/partials/header.php"; ?>

        <div class="main-content">


            <div class="login-container">
                <input type="hidden" v-model.trim='csrf_token' value="<?php echo $_SESSION['csrf_token']; ?>" />

                <label for="hashText">Username</label>
                <input id="Username" v-model.trim="user.username" type="text" @blur="validateUsername" @input="validateUsername">

                <span class="error-text" v-if="!valid_username">
                    Please enter a valid username! Must be atleas 3 characters!
                </span>

                <label for="hashText">Email</label>
                <input id="email" v-model.trim="user.email" type="email" @blur="validateEmail" @input="validateEmail">

                <span class="error-text" v-if="!valid_email">
                    Please enter a valid email address!
                </span>

                <label for="hashText">Password</label>
                <input id="Password" v-model.trim="user.password1" type="password" @input="validatePassword" @blur="validatePassword" autocomplete="new-password">

                <ul v-if="user.password1!==''" class="pass-requirements">
                    <li :class="{ is_valid: contains_eight_characters }">Contains 6 Characters</li>
                    <li :class="{ is_valid: contains_number }">Contains Number</li>
                    <li :class="{ is_valid: contains_uppercase }">Contains Uppercase</li>
                    <li :class="{ is_valid: contains_special_character }">Contains Special Character</li>
                </ul>

                <label for="hashText">Repeat Password</label>
                <input id="password_repeat" v-model.trim="user.password2" type="password" autocomplete="new-password" @input="validateSecondPassword" @blur="validateSecondPassword">

                <span class="error-text" v-if="!valid_password2">
                    The repeated password must match!
                </span>

                <a class="btn" @click="sendRequest()">signup</a>
            </div>

        </div>

    </div>
    <?php require "./inc/partials/scripts.php"; ?>
</body>

</html>