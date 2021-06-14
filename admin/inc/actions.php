<?php

// echo "<pre>";
// var_dump($_GLOBALS);
// echo "</pre>";
$message = "";
//
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "delete-user") {
    // check token
    if (hash_equals($_SESSION['csrf_token'], $_REQUEST['csrf_token'])) {
        //
        if ($_REQUEST['value'] != "b520040e-c6f7-11eb-aca6-0800274911c6") {
            $message = Users::deleteUser($_REQUEST['value']) ? "User deleted!" : "Error deleting user!";
        }
    } else {
        $_SESSION['csrf_token'] = Common::generateToken();
    }
}
//
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "delete-post") {
    // check token
    if (hash_equals($_SESSION['csrf_token'], $_REQUEST['csrf_token'])) {
        //
        $message = Posts::deletePost($_REQUEST['value']) ? "Post deleted!" : "Error deleting post!";
    } else {
        $_SESSION['csrf_token'] = Common::generateToken();
    }
}
