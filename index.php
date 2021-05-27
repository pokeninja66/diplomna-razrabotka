<?php

require "./config.php";

//echo "Well now it's the HTTPS is woking...";

// $server = "localhost";
// $username = "admin";
// $password = "1q2w3e";
// $database = "testing_mysql";

// // init DB
// $conn = new mysqli($servername, $username, $password, $database);

// /* Check the connection is created properly or not */
// if ($conn->connect_error)
//     echo "Connection error:" . $conn->connect_error;
// else
//     echo "Connection is created successfully";


// $query = "SELECT * FROM `users`";

// $res = $conn->query($query);
// echo "<pre>";
// print_r($res->fetch_all());
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
    <title>Diplomna</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <!-- add VUE -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div id="app">
        {{ message }}
    </div>

    <script src="./scripts/main.js" async defer></script>
</body>

</html>