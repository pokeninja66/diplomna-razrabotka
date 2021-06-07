<?php

class Common extends stdClass
{

    public static function prettyPrint($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public static function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    public static function setMenuArr()
    {
        if (isset($_SESSION['User'])) {
            return [
                "Create Post" => "./posts",
                "Logout" => "./logout"
            ];
        } else {
            return [
                "Login" => "./login",
                "Signup" => "./signup"
            ];
        }
    }
}
