<?php
  $login = false;
  $err = false;
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn){
        die("Connection failed due to" . mysqli_connect_error());
    }

    $clientEmail = $_POST['clientEmail']; 
    $clientPassword = $_POST['clientPassword'];

    $fetchCilentID = mysqli_query($conn, "SELECT client_id from `clients` where email = '$clientEmail';");
    $clientID = mysqli_fetch_assoc($fetchCilentID)['client_id'];
    
    $login = "SELECT * from `client_password` WHERE client_id = '$clientID' AND client_password = '$clientPassword';";
    
    $result = mysqli_query($conn, $login);

    $num = mysqli_num_rows($result);

    if($num == 1){
      $login = true;
	    $fetchClientName = mysqli_query($conn, "SELECT * FROM `clients` WHERE client_id = '$clientID';");
      
      session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['name'] = mysqli_fetch_assoc($fetchClientName)['name'];
      $_SESSION['id'] = $clientID;

      header("location: main.php");

    }
    else{
      $err = true;
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
  <title>Log-In</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" style="margin-left: 16px;" href="#">Exact-tax</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Log-in</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./signup.php">Sign-up</a>
        </li>
      </ul>
    </div>
  </nav>

  <?php
    if($err == true){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Invalid password or name.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
  ?>

  <div class="box">
    <h1 style="margin-bottom: 15px;">Login</h1>
    <form action="#" method="POST">
      <div class="form-group">
        <p style="margin: 5px 0px 5px 0px;">Email address</p>
        <input type="email" name="clientEmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
          placeholder="Enter email"  required>
      </div>

      <div class="form-group">
        <p style="margin: 5px 0px 5px 0px;">Password</p>
        <input type="password" name="clientPassword" class="form-control" id="exampleInputPassword1" placeholder="Password"  required>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Log in</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
</body>

</html>