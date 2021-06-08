<?php

class Posts
{

    public static function createPost($info)
    {
        if (!is_array($info)) {
            return false;
        }
        // escape the array
        DB::mysqliRealEscapeStringOnArray($info);

        $user_id = $_SESSION['User']->id;
        $title = trim($info['title']);
        $description = $info['description'] ? trim($info['description']) : "";
        $image = trim($info['image']);

        $query = "INSERT INTO `user_posts` VALUES(uuid(),'$user_id','$title','$description','$image',now())";


        return DB::query($query);
    }

    public static function fetchPosts($where = " 1 ", $limit = "")
    {
        $query = "SELECT * FROM `user_posts` WHERE $where $limit";

        return DB::fetchObjectSet(DB::query($query));
    }

    public static function checkIfValidImage($base64Image)
    {
        $imageInfo = getimagesize($base64Image);
        //print_r($imageInfo);
        if (!$imageInfo) {
            return false;
        }
        $allowedFiles = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        return in_array($imageInfo['mime'], $allowedFiles);
    }
}
