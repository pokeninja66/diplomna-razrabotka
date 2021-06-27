<?php
// using fetch bracks for some reason the session_start
// and having the session Id in the cookie does not work...
// ...
// Well it was the session cookie that fucked me up. It was set to 0 so when the request was send it expired when you used it in an fetch requets...
//var_dump($_COOKIE);
//session_id($_COOKIE["PHPSESSID"]);


session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);


// kek | so you need to decode the payload using fetch... but not jquery
$payload = file_get_contents('php://input');
$RequestInfo = json_decode($payload);
//print_r($RequestInfo);

// print_r($GLOBALS);
// print_r($_REQUEST);

header('Content-Type: application/json');

if (!isset($RequestInfo->action)) { //!isset($RequestInfo->action) !isset($_REQUEST["action"])

    echo json_encode(["status" => false, "msg" => "bad request data"]);
    die();
}
#

require "vendor/autoload.php";
require "./inc/_DB.php";
require "./inc/Common.php";

#
Common::selectConfig();

#set DB
DB::Init(Config::$server, Config::$username, Config::$password, Config::$database);

require "./inc/controllers/Users.php";
require "./inc/controllers/CustomCrypt.php";
require "./inc/controllers/Posts.php";

if ($RequestInfo->action == "login") {

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #

    if (isset($_SESSION['User'])) {
        $res->msg = "error user is logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($RequestInfo->csrf_token) || !hash_equals($_SESSION['csrf_token'], $RequestInfo->csrf_token)) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    $res->status =  Users::login($RequestInfo->username, $RequestInfo->password);
    $res->msg = $res->status ? "Login complete!" : "Invalid username or password!";
    //print_r($res);

    echo json_encode($res);
    exit();
}

if ($RequestInfo->action == "signup") {

    // print_r($_REQUEST);
    // print_r($_SESSION);

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    if (isset($_SESSION['User'])) {
        $res->msg = "error user is logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($RequestInfo->csrf_token) || !hash_equals($_SESSION['csrf_token'], $RequestInfo->csrf_token)) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    // check for valid user information
    if (Users::checkForExistingUser($RequestInfo->user->username)) {
        $res->msg =  "User exists!";
        //
        echo json_encode($res);
        exit();
    }

    // check for valid user information
    if (strlen($RequestInfo->user->username) < 3) {
        $res->msg =  "Invalid username!";
        //
        echo json_encode($res);
        exit();
    }

    if (!filter_var($RequestInfo->user->email, FILTER_VALIDATE_EMAIL)) {
        $res->msg =  "Invalid email!";
        //
        echo json_encode($res);
        exit();
    }

    if (!Users::checkPassword($RequestInfo->user->password1)) {
        $res->msg =  "Invalid password!";
        //
        echo json_encode($res);
        exit();
    }

    if (strcmp($RequestInfo->user->password1, $RequestInfo->user->password2) !== 0) {
        $res->msg =  "Passwords do not match!";
        //
        echo json_encode($res);
        exit();
    }

    // register the user
    $res->status =  Users::signup($RequestInfo->user);
    if ($res->status) {
        $res->msg = "Signup complete!";
    }
    
    echo json_encode($res);
    exit();
}


if ($RequestInfo->action == "create-post") {

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    if (!isset($_SESSION['User'])) {
        $res->msg = "user is not logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($RequestInfo->csrf_token) || !hash_equals($_SESSION['csrf_token'], $RequestInfo->csrf_token)) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    if (empty($RequestInfo->post->title)) {
        $res->msg =  "You need a title!";
        //
        echo json_encode($res);
        exit();
    }

    if (empty($RequestInfo->post->image) || !Posts::checkIfValidImage($RequestInfo->post->image)) {
        $res->msg =  "You need an image!";
        //
        echo json_encode($res);
        exit();
    }

    $res->status = Posts::createPost((array)$RequestInfo->post);
    $res->msg = $res->status ? "Post created!" : "Error during creation!";

    echo json_encode($res);
    exit();
}

if ($RequestInfo->action == "fetchPosts") { //$Request->action

    $res = new stdClass();
    $res->posts = [];
    #
    $res->posts = Posts::fetchPosts(" 1 ", " ORDER BY `created_at` DESC ");

    echo json_encode($res);
    exit();
}

if ($RequestInfo->action == "get-post") {

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    if (!isset($_SESSION['User'])) {
        $res->msg = "user is not logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($RequestInfo->csrf_token) || !hash_equals($_SESSION['csrf_token'], $RequestInfo->csrf_token)) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    if (!Users::checkForEditPermissions($RequestInfo->post_id)) {
        $res->msg = "this user can't edit this post!";
        echo json_encode($res);
        exit();
    }

    $res->post = Posts::getPostById($RequestInfo->post_id);
    $res->status = true;
    $res->msg = "post loaded";

    echo json_encode($res);
    exit();
}

if ($RequestInfo->action == "update-post") {

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    if (!isset($_SESSION['User'])) {
        $res->msg = "user is not logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($RequestInfo->csrf_token) || !hash_equals($_SESSION['csrf_token'], $RequestInfo->csrf_token)) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    if (!Users::checkForEditPermissions($RequestInfo->post->post_id)) {
        $res->msg = "this user can't edit this post!";
        echo json_encode($res);
        exit();
    }

    $res->status = Posts::updatePost((array)$RequestInfo->post);
    $res->msg = $res->status ? "Post updated!" : "Error during edit!";

    echo json_encode($res);
    exit();
}

if ($RequestInfo->action == "delete-post") {

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    if (!isset($_SESSION['User'])) {
        $res->msg = "user is not logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($RequestInfo->csrf_token) || !hash_equals($_SESSION['csrf_token'], $RequestInfo->csrf_token)) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    if (!Users::checkForEditPermissions($RequestInfo->post_id)) {
        $res->msg = "this user can't delete this post!";
        echo json_encode($res);
        exit();
    }

    $res->status = Posts::deletePost($RequestInfo->post_id);
    $res->msg = $res->status ? "Post deleted!" : "Error during deletion!";

    echo json_encode($res);
    exit();
}

exit("kek");
