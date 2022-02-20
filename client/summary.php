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
    
    $clientName = $_SESSION['name'];
    $clientID = $_SESSION['id'];
    
    $fetchApproval = mysqli_query($conn, "SELECT * FROM `clients` where client_id = '$clientID' AND approval = 1;");

    $isApproved = mysqli_num_rows($fetchApproval);

    if($isApproved == 1){
        $incomeSummary = mysqli_query($conn, "SELECT * FROM `tax_return` where client_id = '$clientID';");
        $propertySummary = mysqli_query($conn, "SELECT * FROM `property_tax_return` where client_id = '$clientID';");
    }

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Exact-tax</title>
</head>

<body>

    <?php
        include_once "./partials/nav.php";
    ?>

    <div id="main">
        <div class="card1" style="width: 100%; padding: 40px;">

            <h2 style="text-align: center;">Tax Summary</h2>

            <?php

                if($isApproved == 1){
                    echo '
                    <div style="width: 70%; margin: auto;">
                        <h3>For incomes</h3>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Annual income</th>
                                    <th scope="col">Tax amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                ';$index = 1;
                                    while($row = mysqli_fetch_assoc($incomeSummary)){
                                        echo '
                                            <tr>
                                                <th scope="row">'.$index.'</th>
                                                <td>'.$row['annual_income'].'</td>
                                                <td>'.$row['income_tax_amount'].'</td>
                                            </tr>
                                        ';
                                        $index = $index+1;
                                    }
                                echo '

                            </tbody>

                        </table>

                        <h3>For Properties</h3>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Tax amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            ';
                                $index = 1;
                                while($row = mysqli_fetch_assoc($propertySummary)){
                                    echo '
                                    <tr>
                                        <th scope="row">'.$index.'</th>
                                        <td>'.$row['annual_value'].'</td>
                                        <td>'.$row['tax_amount'].'</td>
                                    </tr>
                                    ';
                                    $index = $index+1;
                                }
                                echo '
                            </tbody>
                    </div>
                    ';
                }

                else{
                    echo'
                    <br><br><br>
                    <h3 style="text-align: center;">Waiting for approval</h3>
                    <h4 style="text-align: center;">Your entered details verification is pending, </h4>
                    ';
                }

            ?>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>