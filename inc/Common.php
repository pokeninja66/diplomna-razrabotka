<?php

class Common extends stdClass
{

    public static function prettyPrint($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public static function generateToken(){
        return bin2hex(random_bytes(32));
    }
}
