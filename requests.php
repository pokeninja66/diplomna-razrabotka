<?php
// var_dump($GLOBALS);
// print_r($_REQUEST);

header('Content-Type: application/json');

if (!isset($_REQUEST["action"])) {

    echo json_encode(["error" => "bad request data"]);
    die();
}

require "./inc/Common.php";
require "./inc/_DB.php";
require "./inc/controllers/Users.php";

if ($_REQUEST['action'] == "login") {
    $requestData = $_REQUEST['data'];
    //print_r($requestData);
    $res = Users::login($requestData['username'],$requestData['password']);
    //print_r($res);

    echo json_encode($res);
}
