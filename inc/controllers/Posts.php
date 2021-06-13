<?php

class Posts
{

    public static function createPost($post)
    {
        // convert it to array so that we cam escape it
        if (!is_array($post)) {
            $post =  (array) $post;
        }

        // escape the array
        DB::mysqliRealEscapeStringOnArray($post);

        $user_id = $_SESSION['User']->id;
        $title = trim($post['title']);
        $description = $post['description'] ? trim($post['description']) : "";
        $image = trim($post['image']);

        $query = "INSERT INTO `user_posts` VALUES(uuid(),'$user_id','$title','$description','$image',now())";


        return DB::query($query);
    }

    public static function fetchPosts($where = " 1 ", $order = "", $limit = "")
    {
        $query = "SELECT * FROM `user_posts` WHERE $where $order $limit";

        $posts = DB::fetchObjectSet(DB::query($query));
        // yeah this is kinda shitty coded?
        foreach ($posts as $key => $onePost) {
            $posts[$key]->can_edit = Users::checkForEditPermissions($onePost->post_id);
        }

        return $posts;
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

    public static function getPostById($id)
    {
        $query = "SELECT * FROM `user_posts` WHERE `post_id`='$id'";

        return DB::fetchObject(DB::query($query));
    }

    public static function updatePost($post)
    {
        // convert it to array so that we cam escape it
        if (!is_array($post)) {
            $userInfo =  (array) $post;
        }

        // escape the array
        DB::mysqliRealEscapeStringOnArray($post);

        $title = trim($post['title']);
        $description = $post['description'] ? trim($post['description']) : "";
        $image = trim($post['image']);

        $query = "UPDATE `user_posts` SET 
                    `title`='$title',
                    `description`='$description',
                    `image_base64`='$image'
                    WHERE `post_id` = '{$post['post_id']}'";

        //echo $query;
        return DB::query($query);
    }

    public static function deletePost($id)
    {
        $query = "DELETE FROM `user_posts` WHERE `post_id`='$id'";
        return DB::query($query);
    }
}
