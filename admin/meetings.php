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
	error_reporting(0);
	$adminID = $_SESSION['id'];
	$fetchFileDetails = "SELECT * FROM `meetings` where admin_id = '$adminID';";
    $fileDetails = mysqli_query($conn, $fetchFileDetails);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
		$adminID = $_SESSION['id'];
		$fetchFileDetails = "SELECT * FROM `meetings` where admin_id = '$adminID';";
    	$fileDetails = mysqli_query($conn, $fetchFileDetails);

		if (isset($_POST['client_id'])){
			$adminID = $_SESSION['id'];
			$clientID = $_POST['client_id'];
			$meetingID = mysqli_fetch_assoc(mysqli_query($conn,"SELECT MAX(meeting_id) as meeting_id from `meetings`"))['meeting_id'];
			$meetingID=$meetingID+1;
			$date = $_POST['date'];
			$time = $_POST['time'];
			$sql="insert into `meetings` values($meetingID,$adminID,$clientID,'$date ','$time')";
        	$result=mysqli_query($conn,$sql);
			header("Location: #");
		}
		
		if (isset($_POST['mid'])){
			$mid = $_POST['mid'];
			$sql="delete from `meetings` where meeting_id=$mid";
			$result=mysqli_query($conn,$sql);
			header("Location: #");
			// break;
		}

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
		<div class="card1" style="width: 40%; text-align: center;">
			<h2>Enter new meeting</h2>
			<form action="#" method="POST">

				<div class="form-group m-1">
					<p style="margin: 5px 0px 5px 0px;">Client Id</p>
					<input type="text" class="form-control" id="client_id" name="client_id" placeholder="Enter client id">
				</div>

				<div class="form-group m-1">
					<p style="margin: 15px 0px 5px 0px;">Date</p>
					<input type="text" class="form-control" id="date" name="date" placeholder="Enter date">
				</div>

				<div class="form-group m-1">
					<p style="margin: 5px 0px 5px 0px;">Time</p>
					<input type="text" class="form-control" id="time" name="time" placeholder="Enter time">
				</div>

				<button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit</button>
			</form>
		</div>

		<div class="card2" style="width: 60%;">
			<div class="c2-content">
				<h2 style="padding-bottom: 10px;">Overview</h2>

				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">Meeting Id</th>
							<th scope="col">Admin Id</th>
							<th scope="col">Client Id</th>
							<th scope="col">Date</th>
							<th scope="col">Time</th>
						</tr>
					</thead>
					<tbody>
						<?php
							//$index=1;
							while($row = mysqli_fetch_assoc($fileDetails)){
						?>
								
								<tr>
									
									<td><?php echo $row['meeting_id'];?></td>
									<td><?php echo $row['admin_id'];?></td>
									<td><?php echo $row['client_id'];?></td>
									<td><?php echo $row['date_'];?></td>
									<td><?php echo $row['time'];?></td>
								</tr>
								
						<?php		
							}
						?>

					</tbody>
				</table>

				<h3>Remove meeting</h3>
				<form action="#" method="POST">
					<div class="form-group">
						<p style="margin: 5px 0px 5px 0px;">Meeting id</p>
						<input type="text" class="form-control" id="mid" name="mid" placeholder="meeting id">
					</div>
					<button type="submit" class="btn btn-primary" style="margin-top: 10px;">remove</button>
				</form>

			</div>

		</div>

	</div>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>
</body>

</html>