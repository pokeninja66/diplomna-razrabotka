<?php
// var_dump($GLOBALS);
// print_r($_REQUEST);

header('Content-Type: application/json');

if (!isset($_REQUEST["action"])) {

    echo json_encode(["error" => "bad request data"]);
    die();
}
#
session_start();
require "./inc/Common.php";
require "./inc/_DB.php";
require "./inc/controllers/Users.php";

if ($_REQUEST['action'] == "login") {

    $res = new stdClass();
    $res->status = false;
    $res->msg = "error";
    #
    $requestData = $_REQUEST['data'];
    
    // check for valid token
    if (empty($requestData['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $res->msg =  "access denied!";
        // change token
        $_SESSION['csrf_token'] = Common::generateToken();
        //
        echo json_encode($res);
        exit();
    }

    //print_r($requestData);
    $res->data =  Users::login($requestData['username'], $requestData['password']);
    //print_r($res);

    echo json_encode($res);
    exit();
}
exit();
