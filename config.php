<?php

if(!isset($_HAS_PAGE_ACCESS)){
    header("Location: ./");
}

require "./inc/_Config.php";
require "./inc/_DB.php";
require "./inc/Common.php";
require "./inc/controllers/Posts.php";

#set DB
DB::Init(Config::$server, Config::$username, Config::$password, Config::$database);
#
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 7);// one week
session_start();

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = Common::generateToken();
}

#print_r($_SESSION);

# db test
//  $query = "SHOW TABLES";
//  Common::prettyPrint(DB::fetchObjectSet(DB::query($query)));
