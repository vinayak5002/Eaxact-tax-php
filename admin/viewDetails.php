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

            <h2>Client details:</h2>

                    <?php
                        function display($SOI, $prop){
                            
                            echo '
                            <h3>Sources of income</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Monthly income amount</th>
                                        <th scope="col">Income catogory</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ';
                                        $index = 1;
                                        while($row = mysqli_fetch_assoc($SOI)){
                                            $cat = " ";
                                            if($row['category'] == 'is1'){
                                                $cat = "income slab 1";
                                            }
                                            else if ($row['category'] == 'is2'){
                                                $cat = "income slab 2";
                                            }
                                            else if ($row['category'] == 'is3'){
                                                $cat = "income slab 3";
                                            }
                                            else{
                                                $cat = "income slab 4";
                                            }
                                            echo '
                                            <tr>
                                                <th scope="row">'.$index.'</th>
                                                <td>'.$row['monthly_income'].'</td>
                                                <td>'.$cat.'</td>
                                            </tr>
                                            ';
                                            $index = $index+1;
                                        }
                                    echo '
                                </tbody>
                            </table>
                
                            <h3>Properties</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name of property</th>
                                        <th scope="col">value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ';
                                        $index = 1;
                                        while($row = mysqli_fetch_assoc($prop)){
                                            echo '
                                            <tr>
                                                <th scope="row">'.$index.'</th>
                                                <td>'.$row['name'].'</td>
                                                <td>'.$row['value'].'</td>
                                            </tr>
                                            ';
                                            $index = $index+1;
                                        }
                                    echo '
                                </tbody>
                            </table>
                            ';

                        }
                    ?>
                    <?php
                        function fetch($conn, $clientID){
                            
                            $SOI = mysqli_query($conn, "SELECT * FROM `sources_of_income` WHERE client_id = '$clientID';");
	                        $prop = mysqli_query($conn, "SELECT * FROM `properties` WHERE client_id = '$clientID';");
                            display($SOI, $prop);
                        }

                        if($_SERVER['REQUEST_METHOD'] == "POST") {
                            $clientID = $_POST['viewID'];
                            fetch($conn, $clientID);
                            // header("Location: #");
                        }
                    ?>
                </tbody>
            </table>

            <h2>Enter id to view documents</h2>
            <form action="#" method="POST">
                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;">Client Id</p>
                    <input type="text" class="form-control" name="viewID" id="meeting_id" placeholder="Enter client id">
                </div>

                <button type="submit" name="view" class="btn btn-primary" style="padding: 10px; margin-right: 5px;" >View</button>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>