<?php
#
$_HAS_PAGE_ACCESS = true;
require "./config.php";
//
if(isset($_SESSION['User'])){
    header("Location: ./");
    exit();
}

$page_title = "Diplomna Login";
$page_description = "Here we login";
$page_extra_css = "login";
$page_main_script = "login";

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

    <div id="app-login">

        <?php require "./inc/partials/header.php"; ?>

        <div class="main-content">


            <div class="login-container">
                <input type="hidden" v-model.trim='csrf_token' value="<?php echo $_SESSION['csrf_token']; ?>" />

                <label for="hashText">Username</label>
                <input id="Username" v-model.trim="username" type="text">
                <label for="hashText">Password</label>
                <input id="Password" v-model.trim="password" type="password">

                <a class="btn" @click="sendRequest()">login</a>
            </div>

        </div>

    </div>
    <?php require "./inc/partials/scripts.php"; ?>
</body>

</html>