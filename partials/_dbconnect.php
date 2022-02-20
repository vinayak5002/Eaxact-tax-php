<?php
    // error_reporting(0);

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn){
        die("Connection failed due to" . mysqli_connect_error());
    }
    // else{
    //     echo "Connection sucessful";
    // }
?>