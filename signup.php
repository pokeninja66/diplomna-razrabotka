<?php
#
$_HAS_PAGE_ACCESS = true;
require "./config.php";
//
if(isset($_SESSION['User'])){
    header("Location: ./");
    exit();
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Diplomna login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="./">

    <!-- css -->
    <link rel="stylesheet" href="./public/css/reset.css">
    <link rel="stylesheet" href="./public/css/main.css">
    <link rel="stylesheet" href="./public/css/login.css">
    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div id="app-signup">

        <header>
            <nav id="navigation">
                <ul>
                    <li><a href="/">Home</a></li>
                </ul>
            </nav>
        </header>

        <div class="main-content">


            <div class="login-container">
                <input type="hidden" v-model.trim='csrf_token' value="<?php echo $_SESSION['csrf_token']; ?>" />

                <label for="hashText">Username</label>
                <input id="Username" v-model.trim="user.username" type="text"  @blur="validateUsername" @input="validateUsername">

                <span class="error-text" v-if="!valid_username">
                    Please enter a valid username! Must be atleas 3 charackters!
                </span>

                <label for="hashText">Email</label>
                <input id="email" v-model.trim="user.email" type="email" @blur="validateEmail" @input="validateEmail">

                <span class="error-text" v-if="!valid_email">
                    Please enter a valid email address!
                </span>

                <label for="hashText">Password</label>
                <input id="Password" v-model.trim="user.password1" type="password"  @input="validatePassword" @blur="validatePassword" autocomplete="new-password">

                <ul v-if="user.password1!==''">
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
    <script>
        const csrf = '<?php echo $_SESSION['csrf_token']; ?>';
    </script>
    <script src="./public/scripts/signup.js" async defer></script>
</body>

</html>