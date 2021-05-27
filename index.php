<?php

//echo "Well now it's the HTTPS is woking...";

$server="localhost";
$username="admin";
$password="1q2w3e";
$database = "testing_mysql";

// init DB
$conn=new mysqli($servername,$username,$password,$database);

/* Check the connection is created properly or not */
if($conn->connect_error)
    echo "Connection error:" .$conn->connect_error;
else
    echo "Connection is created successfully";  


$query = "SELECT * FROM `users`";

$res = $conn->query($query);
echo "<pre>";
print_r($res->fetch_all());