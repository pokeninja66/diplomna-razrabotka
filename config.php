<?php

if(!isset($_HAS_PAGE_ACCESS)){
    header("Location: ./");
}

#
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 1);// one day
session_start();

require "./inc/_DB.php";
require "./inc/Common.php";
require "./inc/controllers/Posts.php";

# config
Common::selectConfig();
#set DB
DB::Init(Config::$server, Config::$username, Config::$password, Config::$database);


if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = Common::generateToken();
}

#print_r($_SESSION);

# db test
//  $query = "SHOW TABLES";
//  Common::prettyPrint(DB::fetchObjectSet(DB::query($query)));
