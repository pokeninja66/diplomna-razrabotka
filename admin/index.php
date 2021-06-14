<?php
require "./inc/config.php";
require "./inc/actions.php";

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Page</title>
    <meta name="description" content="View the admin stuff">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../public/css/font-awsome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" integrity="sha512-EZLkOqwILORob+p0BXZc+Vm3RgJBOe1Iq/0fiI7r/wJgzOFZMlsqTa29UEl6v6U6gsV4uIpsNZoV32YZqrCRCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/admin.css">

</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <form id="action-form" method="POST" action="" style="display: none;">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>" />
        <input type="hidden" id="action" name="action" value="" />
        <input type="hidden" id="value" name="value" value="" />
    </form>
    <div class="row">
        <div></div>
        <div class="content">
            <h2>Users</h2>
            <table class="u-full-width">
                <div class="six columns">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User type</th>
                            <th>Created</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (Users::getAdminUsersList() as $oneUser) { ?>
                            <tr>
                                <td><?php echo $oneUser->id; ?></td>
                                <td><?php echo $oneUser->username; ?></td>
                                <td><?php echo CustomCrypt::decrypt($oneUser->email); ?></td>
                                <td><?php echo $oneUser->user_type; ?></td>
                                <td><?php echo $oneUser->created_at; ?></td>
                                <td><i onclick="deleteUser('<?php echo $oneUser->id; ?>');" class="fas fa-trash"></i></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </div>
            </table>

            <br>

            <h2>Posts</h2>
            <table class="u-full-width">
                <div class="six columns">
                    <thead>
                        <tr>
                            <th>Post ID</th>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (Posts::fetchPosts() as $onePost) { ?>
                            <tr>
                                <td><?php echo $onePost->post_id; ?></td>
                                <td><?php echo $onePost->title; ?></td>
                                <td><i onclick="editPost('<?php echo $onePost->post_id; ?>');" class="fas fa-edit"></i></td>
                                <td><i onclick="deletePost('<?php echo $onePost->post_id; ?>');" class="fas fa-trash"></i></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </div>
            </table>

        </div>
        <div></div>
    </div>


    <?php if ($message != '') {
        echo "<script>alert('$message')</script>";
    } ?>


    <script src="./js/admin.js" async defer></script>
</body>

</html>