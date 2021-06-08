<?php

class Users
{

    public static function login($username, $password)
    {
        // escape the string
        $username = DB::mysqliRealEscapeString($username); //CustomCrypt::encrypt();
        //$password = password_hash(DB::mysqliRealEscapeString($password), PASSWORD_DEFAULT);

        $query = "SELECT `password` FROM `users` WHERE `username`='$username';";
        //echo $query;
        $checkObj = DB::fetchObject(DB::query($query));

        // verify password
        if (password_verify($password, $checkObj->password)) {
            $query = "SELECT `id`, `email`, `created_at`,`user_type` FROM `users` WHERE `username`='$username' AND `password`='$checkObj->password';";
            $dbUser = DB::fetchObject(DB::query($query));
            //print_r($dbUser);
            // set user
            if ($dbUser) {
                $_SESSION['User'] = new stdClass();
                $_SESSION['User']->id = $dbUser->id;
                $_SESSION['User']->username = $username;
                $_SESSION['User']->email = CustomCrypt::decrypt($dbUser->email);
                $_SESSION['User']->user_type = $dbUser->user_type;
                $_SESSION['User']->created_at = $dbUser->created_at;
            }
        }
        //print_r($_SESSION);
        return isset($_SESSION['User']);
    }

    public static function signup($userInfo)
    {
       
        if (!is_array($userInfo)) {
            return false;
        }
        // escape the array
        DB::mysqliRealEscapeStringOnArray($userInfo);

        $username = $userInfo['username']; //CustomCrypt::encrypt($userInfo['username']);
        $email = CustomCrypt::encrypt($userInfo['email']);
        $password = password_hash($userInfo['password1'], PASSWORD_DEFAULT);

        $query = "INSERT INTO `users` VALUES(uuid(),'$username','$password','$email',1,now());";

        if (DB::query($query)) {
            return self::login($userInfo['username'], $userInfo['password1']);
        }

        return false;
    }

    public static function checkForExistingUser($username){
        $username = DB::mysqliRealEscapeString($username);
        $query = "SELECT id FROM `users` WHERE `username`='$username'";
        return DB::numRows(DB::query($query));
    }

    public static function checkPassword($pass)
    {
        if (strlen($pass) < 6) {
            //Password should be min 6 characters
            return false;
        }
        if (!preg_match("/\d/", $pass)) {
            //Password should contain at least one digit
            return false;
        }
        if (!preg_match("/[A-Z]/", $pass)) {
            //Password should contain at least one Capital Letter
            return false;
        }
        if (!preg_match("/[a-z]/", $pass)) {
            //Password should contain at least one small Letter
            return false;
        }
        if (!preg_match("/\W/", $pass)) {
            //Password should contain at least one special character
            return false;
        }
        if (preg_match("/\s/", $pass)) {
            //Password should not contain any white space
            return false;
        }
        return true;
    }
}
