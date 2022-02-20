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
	
			// Now update downloads count
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
    <title>Exact-tax</title>
</head>

<body>

    <?php 
        include_once "./partials/nav.php";
    ?>

    <div class="box" style="margin: 2% 25%;">
        <div class="card1" style="width: 100%; padding: 40px; margin: 0px;">

            <h2>Uploaded documents:</h2>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
					<th scope="col">File name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        function display($fileDetails){
                            $index = 1;
                            while($row = mysqli_fetch_assoc($fileDetails)){
                                $link = "viewDocuments.php?file_id=".$row['fileCode'];
                                echo '
                                <tr>
                                    <th scope="row">'.$index.'</th>
                                    <td><a href='.$link.'>'.$row['fileName'].'</a></td>
                                </tr>
                                ';
                                $index = $index+1;
                            }
                        }
                    ?>
                    <?php
                        function fetch($conn, $clientID){
                            
                            $fetchFileDetails = "SELECT * FROM `documents` where client_id = '$clientID';";
                            $fileDetails = mysqli_query($conn, $fetchFileDetails);
                            display($fileDetails);
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