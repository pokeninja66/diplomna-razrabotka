<?php
// var_dump($GLOBALS);
// print_r($_REQUEST);
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (!isset($_REQUEST["action"])) {

    echo json_encode(["error" => "bad request data"]);
    die();
}
#
session_start();

require "vendor/autoload.php";
require "./inc/_Config.php";
require "./inc/_DB.php";
require "./inc/Common.php";

#set DB
DB::Init(Config::$server, Config::$username, Config::$password, Config::$database);

require "./inc/controllers/Users.php";
require "./inc/controllers/CustomCrypt.php";

if ($_REQUEST['action'] == "login") {

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    $requestData = $_REQUEST['data'];

    if (isset($_SESSION['User'])) {
        $res->msg = "error user is logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($requestData['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $requestData['csrf_token'])) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    //print_r($requestData);
    $res->status =  Users::login($requestData['username'], $requestData['password']);
    $res->msg = $res->status ? "Login complete!" : "Invalid username or password!";
    //print_r($res);

    echo json_encode($res);
    exit();
}

if ($_REQUEST['action'] == "signup") {

    // print_r($_REQUEST);
    // print_r($_SESSION);

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    $requestData = $_REQUEST['data'];
    $userInfo = $requestData['user'];

    if (isset($_SESSION['User'])) {
        $res->msg = "error user is logged!";
        echo json_encode($res);
        exit();
    }

    // check for valid token
    if (empty($requestData['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $requestData['csrf_token'])) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    // check for valid user information
    if (Users::checkForExistingUser($userInfo['username'])) {
        $res->msg =  "User exists!";
        //
        echo json_encode($res);
        exit();
    }

    // check for valid user information
    if (strlen($userInfo['username']) < 3) {
        $res->msg =  "Invalid username!";
        //
        echo json_encode($res);
        exit();
    }

    if (!filter_var($userInfo['email'], FILTER_VALIDATE_EMAIL)) {
        $res->msg =  "Invalid email!";
        //
        echo json_encode($res);
        exit();
    }

    if (!Users::checkPassword($userInfo['password1'])) {
        $res->msg =  "Invalid password!";
        //
        echo json_encode($res);
        exit();
    }

    if (strcmp($userInfo['password1'], $userInfo['password2']) !== 0) {
        $res->msg =  "Passwords do not match!";
        //
        echo json_encode($res);
        exit();
    }

    // register the user
    $res->status =  Users::signup($userInfo);
    if ($res->status) {
        $res->msg = "Signup complete!";
    }
    //print_r($res);

    echo json_encode($res);
    exit();
}

exit();
