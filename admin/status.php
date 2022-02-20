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

	$name = $_SESSION['name'];

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
				<form action="#" method="POST">
					<div class="form-group m-1">
						<h3 style="margin: 5px 0px 5px 0px;">Enter Client Id to view their status</h3>
						<input type="text" name="statusID" class="form-control" id="client_id" placeholder="Enter client id">
					</div>
	
					<button type="submit" class="btn btn-primary" style="margin-top: 10px;">View status</button>
				</form>
			</div>
            
            <div style="width: 70%; margin: 0px auto;" >
                <br><br><br>
                <h2 style="text-align: center;" >Payment staus of "client"</h2>

				<?php
					function fetch($conn, $clientID){
						$fetchStatus = mysqli_query($conn, "SELECT * FROM `status` WHERE client_id = '$clientID';");
						$satus = mysqli_fetch_assoc($fetchStatus);

						$setAmount = $satus['set_amount'];
						$setsOpted = $satus['sets_opted'];
						$setsCompleted = $satus['sets_completed'];

						if($setsCompleted >= $setsOpted){
							$isButton = false;
						}

						$totalAmount = $setAmount * $setsOpted;
						$remainingSets = $setsOpted - $setsCompleted;

						$percent = ($setsCompleted / $setsOpted)*100;

						display($totalAmount, $setsOpted, $setsCompleted, $remainingSets, $percent);
					}

					function display($totalAmount, $setsOpted, $setsCompleted, $remainingSets, $percent){
						echo '
						<h5>Net annual tax amount: '.$totalAmount.' Rs.</h5>
						<h5>Number of sets choosen: '.$setsOpted.'</h5>
						<h5>Number of sets completed: '.$setsCompleted.'</h5>
						<h5>Number of sets remaining sets : '.$remainingSets.'</h5>

						<br><br><br>
						<div class="progress">
							<div class="progress-bar bg-success" role="progressbar" style="width: '.$percent.'%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5"></div>
						</div>
						<br> <br> <br>
						';
					}

					
					if($_SERVER['REQUEST_METHOD'] == "POST") {
						$clientID = $_POST['statusID'];
						fetch($conn, $clientID);
						// header("Location: #");
					}
				?>
            </div>

		</div>
	</div>



	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>
</body>

</html>