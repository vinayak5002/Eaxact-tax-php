<?php
	$server = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn){
        die("Connection failed due to" . mysqli_connect_error());
    }

	session_start();

	if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header("location: login.php");
        exit;
	}

    $isButton = true;

	$clientName = $_SESSION['name'];
	$clientID = $_SESSION['id'];
?>