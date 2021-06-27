<?php
#
$_HAS_PAGE_ACCESS = true;
require "./config.php";

$page_title = "Diplomna Home";
$page_description = "Well this is some not so coll shit!";
$page_extra_css = "";
$page_main_script = "main";

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

    <div id="app">

        <?php require "./inc/partials/header.php"; ?>

        <div class="main-content" v-if="posts.length">
            <div class="oneItem" :id="post.post_id" v-for="post in posts" :key="post.post_id">
                <span v-if="post.can_edit" class="options">
                    <i @click="editPost(post.post_id)" class="far fa-edit"></i>
                    <i @click="deletePost(post.post_id)" class="fas fa-trash"></i>
                </span>
                <div class="title">{{post.title}}</div>
                <span class="post-date">{{post.created_at}}</span>
                <img class="post-image" :src="post.image_base64" />
                <div class="description">{{post.description}}</div>

            </div>
        </div>

    </div>
    <?php require "./inc/partials/scripts.php"; ?>
</body>

</html>