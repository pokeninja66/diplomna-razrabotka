<?php

if(!isset($_HAS_PAGE_ACCESS)){
    header("Location: ./");
}

require "./inc/_Config.php";
require "./inc/_DB.php";
require "./inc/Common.php";

#set DB
DB::Init(Config::$server, Config::$username, Config::$password, Config::$database);
#
session_start();

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = Common::generateToken();
}

//print_r($_SESSION);

# db test
// $query = "SELECT * FROM `users`";
// Common::prettyPrint(DB::fetchObjectSet(DB::query($query)));
