<?php

class Users {

    public static function login($username,$password){

        $respObj = new stdClass();
        $respObj->user = $username;
        $respObj->pass = $password;


        return $respObj;
    }

    public static function signup($userInfo)
    {
        if(!is_array($userInfo)){
            return false;
        }
        // escape the string
        $userInfo = DB::mysqliRealEscapeStringOnArray($userInfo);

        $query = "INSERT INTO `users` VALUES(uuid(),'{$userInfo['username']}','')";

       


    }

    public static function checkPassword($pass)
    {
        if (strlen($pass) < 6 ) {
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