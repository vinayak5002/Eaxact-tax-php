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

	$SOI = mysqli_query($conn, "SELECT * FROM `sources_of_income` WHERE client_id = '$clientID';");
	$prop = mysqli_query($conn, "SELECT * FROM `properties` WHERE client_id = '$clientID';");
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
		<div class="card1">
			<p id="title" style="font-weight: 700; font-size: 1.5em;">Press releases</p>
			<div class="news1">
				<p class="date">05-Dec-2021</p>
				<p class="headline">MoF advised Taxpayers to file ITRs for AY 21-22 at the earliest</p>
				<a target="_main"
					href="https://www.incometax.gov.in/iec/foportal/sites/default/files/2021-12/Refer%20Press%20Release.pdf"
					class="link">Refer Press Release</a>
			</div>

			<div class="news1">
				<p class="date">09-Sep-2021</p>
				<p class="headline">CBDT extends due dates for filing of Income Tax Returns.</p>
				<a target="_main"
					href="https://www.incometax.gov.in/iec/foportal/sites/default/files/2021-09/circular-no-17-of-2021.pdf"
					class="link">Refer Press Release</a>
			</div>
		</div>

		<div class="card2">
			<div class="c2-content">
				<h2 style="padding-bottom: 10px;">Overview</h2>

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


			</div>
		</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>
</body>

</html>