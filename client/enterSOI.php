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
    $is;
	$clientName = $_SESSION['name'];
	$clientID = $_SESSION['id'];

	$SOI = mysqli_query($conn, "SELECT * FROM `sources_of_income` WHERE client_id = '$clientID';");
	$prop = mysqli_query($conn, "SELECT * FROM `properties` WHERE client_id = '$clientID';");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $Income = $_POST['Income'];
        $occurances=$_POST['quantity'];
        if($Income<=100000){
            $is='is1';
        }
        elseif($Income<=150000){
            $is='is2';
        }
        elseif($Income<=200000){
            $is='is3';
        }
        else{
            $is='is4';
        }
        $sql="insert into `sources_of_income` values('$clientID','$is','$occurances','$Income')";
        $result=mysqli_query($conn,$sql);
        
    }
    
    $SOI = mysqli_query($conn, "SELECT * FROM `sources_of_income` WHERE client_id = '$clientID';");

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
        <h1 style="margin-bottom: 15px;" >Income</h1>
        <form action="#" method="POST">
            <h2>Enterd details: </h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Monthly income amount</th>
                        <th scope="col">Income catogory</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                    ?>
                </tbody>
            </table>

            <div class="form-group m-1">
                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;" >Montly Income</p>
                    <input type="text" class="form-control" id="Income" name="Income" placeholder="Montly Income">
                </div>
                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;" >Collection count</p>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="12">
                </div>
                
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>