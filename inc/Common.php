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
                '<i class="far fa-plus-square"></i>' => "./posts",
                '<i class="fas fa-sign-out-alt"></i>' => "./logout"
            ];
        } else {
            return [
                '<i class="fas fa-sign-in-alt"></i>' => "./login",
                '<i class="fas fa-user-plus"></i>' => "./signup"
            ];
        }
    }
}
