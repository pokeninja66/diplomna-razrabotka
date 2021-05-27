<?php

require "./inc/_Config.php";
require "./inc/_DB.php";

#set DB
DB::Init(Config::$server,Config::$username,Config::$password,Config::$database);

