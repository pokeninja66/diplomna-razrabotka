<?php

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class CustomCrypt
{

    private static $key = null;
    private static $key_path = "./CustomKey.txt";

    private static function generateNewKey()
    {
        self::$key = Key::createNewRandomKey();
        if (self::$key) {
            file_put_contents(self::$key_path, serialize(self::$key));
        }
    }

    private static function getKey()
    {
        if (!file_exists(self::$key_path)) {
            self::generateNewKey();
        }

        self::$key = unserialize(file_get_contents(self::$key_path));
    }

    public static function encrypt($val)
    {
        if(!self::$key){
            self::getKey();
        }

        return Crypto::encrypt($val, self::$key);
    }

    public static function decrypt($val)
    {
        if(!self::$key){
            self::getKey();
        }

        return Crypto::decrypt($val, self::$key);
    }

}
