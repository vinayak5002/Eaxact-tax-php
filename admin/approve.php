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

    $approvedClients = mysqli_query($conn, "SELECT * FROM `clients` WHERE approval = '0';");

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

    <div class="box" style="margin: 2% 25%;">
        <div class="card1" style="width: 100%; padding: 40px; margin: 0px;">

            <h2>Pending approvals:</h2>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Client ID</th>
                        <th scope="col">Client name</th>
                        <th scope="col">Client phone number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        while($row = mysqli_fetch_assoc($approvedClients)){
                            echo '
                            <tr>
                                <th scope="row">'.$index.'</th>
                                <td>'.$row['client_id'].'</td>
                                <td>'.$row['name'].'</td>
                                <td>'.$row['phone'].'</td>
                            </tr>
                            ';
                            $index = $index+1;
                        }
                    ?>
                </tbody>
            </table>

            <?php
                function approve($conn, $clientID){
                    mysqli_query($conn, "UPDATE `clients` SET approval = 1 WHERE client_id = '$clientID';");

                    $calculateTR = "INSERT INTO `tax_return` Select client_id, collection_count * monthly_income annual_income, collection_count * monthly_income * (income_tax_rate/100) tax_amounts
                    from (Select * from `sources_of_income` where client_id = '$clientID') salary, income_tax_rates IT where
                    salary.category = IT.category;";

                    $calculatePTR = "INSERT INTO `property_tax_return` SELECT client_id, value, value*(property_tax_rate/100) tax_amount from properties where client_id = '$clientID';";

                    mysqli_query($conn, $calculateTR);
                    mysqli_query($conn, $calculatePTR);

                    $calNITquery = "SELECT SUM(income_tax_amount) as net_annual_income_tax FROM `tax_return` where client_id = '$clientID';";

                    $calNPTquery = "SELECT SUM(tax_amount) as net_annual_property_tax FROM `property_tax_return` where client_id = '$clientID';";
                    
                    $NIT = mysqli_fetch_assoc(mysqli_query($conn, $calNITquery));
                    $NPT = mysqli_fetch_assoc(mysqli_query($conn, $calNPTquery));

                    $netTax =  (int)$NIT['net_annual_income_tax'] + (int)$NPT['net_annual_property_tax'];

                    // echo $NIT['net_annual_income_tax'];
                    // echo $NPT['net_annual_property_tax'];
                    // echo " ";
                    // echo $netTax;

                    mysqli_query($conn, "INSERT into `net_annual_tax` values ('$clientID', '$netTax');");

                }

                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    echo "BUTTON CLICKED";
                    $clientID = $_POST['approveID'];
                    approve($conn, $clientID);
                    header("Location: #");
                }
            ?>

            <h2>Approve a client</h2>
            <form action="#" method="POST">
                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;">Client Id</p>
                    <input type="text" class="form-control" name="approveID" id="meeting_id" placeholder="Enter client id">
                </div>

                <button type="submit" name="approve" class="btn btn-primary" style="padding: 10px; margin-right: 5px;" >Approve</button>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>