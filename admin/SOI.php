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

    $adminName = $_SESSION['name'];
	$adminID = $_SESSION['id'];

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Sources of Income</title>
  </head>
  <body>

    <?php 
        include_once "./partials/nav.php";
    ?>

    <div class="box" style="margin: 5% 20%;" >
        <h2>Enter client id for correcting the Sources of Income details</h2>
        <form action="#" method = "POST"></form>
        <h1 style="margin-bottom: 15px;" >Sources of Income</h1>
        <form action="#" method = "POST">
            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;" >Client ID</p>
                <input type="text" class="form-control" id="client_id" placeholder="Enter Client ID">
            </div>

            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;" >Category of income</p><br>
                <select name="toi" id="toi" title="category" class="btn btn-secondary btn-sm">
                    <option value="volvo">is1</option>
                    <option value="saab">is2</option>
                    <option value="mercedes">is3</option>
                    <option value="audi">is4</option>
                </select>
            </div>
            

            <div class="form-group m-1">
                <p style="margin: 15px 0px 5px 0px;" >Collection count</p>
                <input type="number" class="form-control" id="cc" placeholder="Enter collection count">
            </div>

            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;" >Monthly Income</p>
                <input type="number" class="form-control" id="mi" placeholder="Enter Monthly Income">
            </div>


            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>