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
        $name = $_POST['propertyName'];
        $value=$_POST['propertyValue'];
        $taxrate=$_POST['tax'];
        
        $sql="insert into `properties` values('$clientID','$name','$value','$taxrate')";
        $result=mysqli_query($conn,$sql);

        header("location: #");
        
    }
    

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
        <h1 style="margin-bottom: 15px;" >Property Income</h1>

        <h3>Properties</h3>
        <h2>Enterd details: </h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name of property</th>
                    <th scope="col">value</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
                ?>
            </tbody>
        </table>


        <form action="#" method="POST">
            <div class="form-group m-1">
                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;" >Property Name</p>
                    <input type="text" class="form-control" id="propertyName" name="propertyName" placeholder="Property Name">
                </div>
                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;" >Property Value</p>
                    <input type="number" class="form-control" id="propertyValue" name="propertyValue" placeholder="Property Value">
                </div>
                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;" >Tax Rate Mentioned in the document</p>
                    <input type="number" class="form-control" id="tax" name="tax" placeholder="Tax Rate">
                </div>
                
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>