<?php
	include_once "./partials/_dbconnect.php";

	$fetchStatus = mysqli_query($conn, "SELECT * FROM `status` WHERE client_id = '$clientID';");
    $satus = mysqli_fetch_assoc($fetchStatus);

    $valid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `status` WHERE client_id = '$clientID';"));
    $chooseSets = false;

    if($valid == 1){
        $setAmount = $satus['set_amount'];
        $setsOpted = $satus['sets_opted'];
        $setsCompleted = $satus['sets_completed'];

        if($setsCompleted >= $setsOpted){
            $isButton = false;
        }

        $totalAmount = $setAmount * $setsOpted;
        $remainingSets = $setsOpted - $setsCompleted;

        $percent = ($setsCompleted / $setsOpted)*100;
    }
    else{
        $net_annual_tax = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from `net_annual_tax` where client_id = '$clientID';"))['net_tax_amount'];
        $chooseSets = true;
    }

    $fetchApproval = mysqli_query($conn, "SELECT * FROM `clients` where client_id = '$clientID' AND approval = 1;");

    $isApproved = mysqli_num_rows($fetchApproval);
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

            <?php
                if($isApproved == 1){
                    if($chooseSets == false){
                        function payNext($conn, $clientID){
                            mysqli_query($conn, "UPDATE `status` SET sets_completed = sets_completed + 1 WHERE client_id = '$clientID';");
                        }
        
                        if($_SERVER['REQUEST_METHOD'] == "POST") {
                            echo "BUTTON CLICKED";
                            payNext($conn, $clientID);
                            header("Location: #");
                        }
                        echo '
                            <h5>Net annual tax amount: '.$totalAmount.' Rs.</h5>
                            <h5>Number of sets choosen: '.$setsOpted.'</h5>
                            <h5>Number of sets completed: '.$setsCompleted.'</h5>
                            <h5>Number of sets remaining sets : '.$remainingSets.'</h5>
                            <h5>Amount to be paid in one set : '.$totalAmount / $setsOpted.'</h5>
    
                            <br><br><br>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: '.$percent.'%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5"></div>
                            </div>
                            <br> <br> <br>
                        ';
                        if($isButton){
                            echo '
                            <div style="text-align: center;">
                                <h3 style="text-align: center;">Proceed to pay next set</h3><br>
                                <form action="payment.php" method="POST">
                                    <button type="submit" name="pay" class="btn btn-primary" style="padding: 10px; margin-right: 5px;" >Proceed to payment</button>
                                </form>
                            </div>
                            ';
                        }
                        else{
                            echo '
                            <div style="text-align: center;">
                                <h3 style="text-align: center;">Payment completed</h3><br>  
                            </div>
                            ';
                        }
                    }
                    else{
    
                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            if(isset($_POST['sets'])){
                                $sets = $_POST['sets'];
                                $setAmount = (int)$net_annual_tax/(int)$sets;
                                $setsOpted = $_POST['sets'];
                                $setsCompleted = 0;
    
                                mysqli_query($conn, "INSERT into `status` values($clientID, '$setAmount', '$setsOpted', 0);");
                                
                                header("Location: #");
                            }
                        }
    
                        echo'
                        <h2>Enter The number of sets you want to pay in:</h2>
    
                        <form action="#" method="POST">
                            <input type="number" id="sets" name="sets" min="1" max="5">
                            <button type="submit" name="select" class="btn btn-primary" style="padding: 10px; margin-right: 5px;" >select</button>
                        </form>
                        ';
                    }
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