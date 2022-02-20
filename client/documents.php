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

	$displayFileError = false;
	$displayFileUploaded = false;
	$filesExists = false;

	$fetchFileDetails = "SELECT * FROM `documents` where client_id = '$clientID';";
	$fileDetails = mysqli_query($conn, $fetchFileDetails);

	$numFileDetails = mysqli_num_rows($fileDetails);

	if($numFileDetails != 0){
		$file_exists = true;
	}
	else{
		$file_exists = false;
	}
    
	if(isset($_POST['upload'])){
		$file = $_FILES['newFile'];

		$fileName = $_FILES['newFile']['name'];
		$fileTempName = $_FILES['newFile']['tmp_name'];
		$fileSize = $_FILES['newFile']['size'];
		$fileType = $_FILES['newFile']['type'];

		$fileExt = explode('.', $fileName);
		$fileExtension = strtolower(end($fileExt));

		if($fileExtension == 'pdf'){
			$fileNewName = uniqid('', true);
			$fileDestination = "C:\\xampp\\htdocs\\project\\Documents\\".$fileNewName.'.pdf';
			move_uploaded_file($fileTempName, $fileDestination);

			$displayFileUploaded = true;

			$insertFile = "INSERT INTO `documents` values('$clientID', '$fileName', '$fileNewName');";

			mysqli_query($conn, $insertFile);
		}
		header("Location: #");
	}

	if (isset($_GET['file_id'])) {
		$id = $_GET['file_id'];
	
		// fetch file to show from database
		$sql = "SELECT * FROM `documents` WHERE fileCode = '$id';";
	
		$file = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `documents` WHERE fileCode = '$id';"));
		$filepath = "C:\\xampp\\htdocs\\project\\Documents\\".$file['fileCode'].'.pdf';
		echo $filepath;
	
		if (file_exists($filepath)) {
			header("Content-type: application/pdf");
			header("Content-Length: " . filesize($filepath));
			readfile($filepath);
	
			exit;
			echo 'File exists';
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<title>Exact-tax</title>
</head>

<body>

	<?php
        include_once "./partials/nav.php";
    ?>

	<?php
		if($displayFileUploaded){
			echo '
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Sucess!</strong> You are loged in!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
			';
		}
	?>

	<div class="card1" style="width: auto; text-align: center;">
		<h2>Uploaded documents</h2><br><br>

		<?php
			if(!$file_exists){
				echo '<h3>No Files Uploaded yet</h3>';
			}
			else{
				
			}
		?>

		<table class="table table-striped" style="width: 60%; margin: auto;">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">File name</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$index = 1;
					while($row = mysqli_fetch_assoc($fileDetails)){
						$link = "documents.php?file_id=".$row['fileCode'];
						echo '
						<tr>
							<th scope="row">'.$index.'</th>
							<td><a href='.$link.'>'.$row['fileName'].'</a></td>
						</tr>
						';
						$index = $index+1;
					}
				?>
			</tbody>
		</table><br><br><br>

		<form  style="width: 60%; margin: auto;" action="#" method="POST" enctype="multipart/form-data">
			<div class="form-group m-1">
				<h3>Upload file:</h3>

				<div class="custom-file mb-3">
					<input type="file" class="custom-file-input" id="customFile" name="newFile">
					<h4>Only pdf files allowed</h4>
					<label class="custom-file-label" for="customFile">Choose file</label>
				</div>

				<button type="submit" name="upload" class="btn btn-primary" style="margin-top: 10px;">Upload</button>
			</div>
		</form>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>
</body>

<script>
	// Add the following code if you want the name of the file appear on select
	$(".custom-file-input").on("change", function () {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>

</html>