<?php

class Users {

    public static function login($username,$password){

        $respObj = new stdClass();
        $respObj->user = $username;
        $respObj->pass = $password;


        return $respObj;
    }
}