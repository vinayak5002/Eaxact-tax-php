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

	<div id="main">
		<div class="card1" style="width: 80%; margin: auto; margin-top: 30px; text-align: center;">
			<div style="width: 70%; margin: auto;" >
				<form>
					<div class="form-group m-1">
						<p style="margin: 5px 0px 5px 0px;">Client Id</p>
						<input type="text" class="form-control" id="client_id" placeholder="Enter client id">
					</div>
	
					<div class="form-group m-1">
						<p style="margin: 5px 0px 5px 0px;">Value</p>
						<input type="email" class="form-control" id="value" placeholder="Enter value pf property">
					</div>
	
					<div class="form-group m-1">
						<p style="margin: 5px 0px 5px 0px;">Property Tax Rate</p>
						<input type="email" class="form-control" id="p_tax_rate" placeholder="Enter property tax rate">
					</div>
	
					<button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit</button>
				</form>
			</div>
			
		</div>
	</div>



	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>
</body>

</html>