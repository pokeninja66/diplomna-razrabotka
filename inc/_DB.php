<?php

class DB extends stdClass
{
    private static $conn = null;

    public static function Init($server, $username, $password, $database)
    {

        self::$conn = new mysqli($server, $username, $password, $database);

        if (self::$conn->connect_error) {
            die("Error: Can't connect to the database!");
        }
    }
}
