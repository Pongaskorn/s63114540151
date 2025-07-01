<?php

$host = "db";
$user = "MYSQL_USER";
$pass = "MYSQL_PASSWORD";
$db = "MYSQL_DATABASE";


// Create connection
$con = mysqli_connect($host, $user, $pass,$db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


?>