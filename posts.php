<?php
#
$_HAS_PAGE_ACCESS = true;
require "./config.php";
//
if (!isset($_SESSION['User'])) {
    header("Location: ./");
    exit();
}

$page_title = "Diplomna Posts";
$page_description = "We create posts here!";
$page_extra_css = "posts";
$page_main_script = "posts";

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


            <div class="container">
                <input type="hidden" v-model.trim='csrf_token' value="<?php echo $_SESSION['csrf_token']; ?>" />

                <label for="Title">Title</label>
                <input id="Title" v-model.trim="title" type="text">

                <label for="Description">Description</label>
                <textarea id="Description" v-model.trim="description"></textarea>

                <input type="file" id="file" name="file" @change="checkFileType" name="mellicode_front_url" />
                <div class='preview' v-if="image_src!=''">
                    <img :src="image_src" id="img" width="100" height="100">
                </div>

                <a class="btn" @click="sendRequest()">
                    <span v-if='action=="create-post"'>Create post</span>
                    <span v-else>Edit post</span>
                </a>
            </div>

        </div>

    </div>
    <?php require "./inc/partials/scripts.php"; ?>
</body>

</html>