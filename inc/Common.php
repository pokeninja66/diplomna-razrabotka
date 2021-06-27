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
                '<i title="Create a post" class="far fa-plus-square"></i>' => "./posts",
                '<i title="Logout" class="fas fa-sign-out-alt"></i>' => "./logout"
            ];
        } else {
            return [
                '<i title="Login" class="fas fa-sign-in-alt"></i>' => "./login",
                '<i title="Signup" class="fas fa-user-plus"></i>' => "./signup"
            ];
        }
    }

    public static function selectConfig(){
     
        // if user is logged
        if(isset($_SESSION['User']) && $_SESSION['User']->user_type==1){
            require "./inc/configs/_config_standard.php";
            return;
        }

        if(isset($_SESSION['User']) && $_SESSION['User']->user_type==2){
            require "./inc/configs/_config_admin.php";
            return;
        }
        // only for when there is no user and we need to login/signup one
        if(!isset($_SESSION["User"]) && strpos($_SERVER['HTTP_REFERER'],'signup')){
            require "./inc/configs/_config_read_only.php";
            return;
        }
        if(!isset($_SESSION["User"]) && strpos($_SERVER['HTTP_REFERER'],'login')){
            require "./inc/configs/_config_read_only.php";
            return;
        }

        // default
        if(!isset($_SESSION['User'])){
            require "./inc/configs/_config_read_only.php";
            return;
        }

    }
}
