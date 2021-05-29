<?php

class Common extends stdClass
{

    public static function prettyPrint($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
