<?php
session_start();

if (!isset($_SESSION["User"]) || $_SESSION["User"]->user_type != 2) {
    header("Location: /");
}
require "../vendor/autoload.php";
#
require "../inc/configs/_config_admin.php";
#
require "../inc/_DB.php";
require "../inc/Common.php";
#
require "../inc/controllers/Posts.php";
require "../inc/controllers/Users.php";
require "../inc/controllers/CustomCrypt.php";

CustomCrypt::$key_path = "../CustomKey.txt";

#set DB
DB::Init(Config::$server, Config::$username, Config::$password, Config::$database);
#
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 7); // one week
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = Common::generateToken();
}
