<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = mysqli_connect($server, $username, $password, $database);

if(!$conn){
    die("Connection failed due to" . mysqli_connect_error());
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $Id = mysqli_fetch_assoc(mysqli_query($conn,"SELECT MAX(client_id) as client_id from `clients`"))['client_id'];
    $Id=$Id+1;
    $username = $_POST['name']; 
    $password = $_POST['password'];
    $email=$_POST['email'];
    $pannum=$_POST['pan'];
    $anum=$_POST['anumber'];
    $phoneno=$_POST['phoneno'];
    $gender=$_POST['gender'];
    
    $insertClient="insert into `clients` values('$Id','$username','$gender','$pannum','$anum','$email','$phoneno', '0')";
    $insertClientResult=mysqli_query($conn,$insertClient);
    $insertPassword="insert into `client_password` values('$Id','$password')";
    $result=mysqli_query($conn,$insertPassword);

    header("Location: login.php");

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
    <title>Sign-up</title>
    <script type="text/javascript">
    function signin() {
      var name = document.getElementById("name").value;
      var emails = document.getElementById("email");
      var anum = document.getElementById("anumber").value;
      var pannum = document.getElementById("pan").value;
      var pass = document.getElementById("password").value;
      var cpass = document.getElementById("cpassword").value;
      var phoneno = document.getElementById("phoneno").value;
      var Male = document.getElementById("male").value;
      var pin = /^[789][0-9]{9}$/;

      if (name == "" || pass == "" || anum == "" || pannum == "" || cpass == "" || emails.value == "" || phoneno == "") {
        alert("Mandatory to enter all the details");
        return false;
      }

      var mail = emails.value;
      atpos = mail.indexOf("@");
      dotpos = mail.lastIndexOf(".");

      if (atpos < 1 || (dotpos - atpos) < 2) {
        alert("Please enter correct email Id");
        return false;
      }


      if (anum.length<14) {
        alert("Enter Valid Adhar Number");
        return false;
      }

      if (pannum.length<10) {
        alert("Enter Valid PAN Number");
        return false;
      }

      if ((isNaN(phoneno))) {
        alert("Phone number should be numeric");
        return false;
      }
      if (phoneno.length != 10) {
        alert("The length of phone number should be 10");
        return false;
      }
      
      if ((pass.length < 8) || (pass.length > 15)) {
        alert("Password should have 8-15 characters");
        return false;
      }
      
      if (pass!=cpass) {
        alert("Please re-confirm the password");
        return false;
      }

      if (confirm("You want to register for sure?")) {
        return true;
      }
      return false;
    }
  </script>
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" style="margin-left: 16px;" href="#">Exact-tax</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./login.php">Log-in</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sign-up</a>
                </li>
            </ul>
        </div>
    </nav>



    <div class="box" style="margin: 5% 20%;">
        <h1 style="margin-bottom: 15px;">Sign-up</h1>
        <form action="#" method="POST">
            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;">Name</p>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
            </div>

            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;">Email Id</p>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>

            <div class="form-group mt-3 m-1">
                <p style="margin: 5px 0px 0px 0px;">Gender</p><br>

                <input class="form-check-input  m-2" type="radio" name="gender" id="male" value="M" checked>
                <label class="form-check-label" for="male"> Male</label>

                <input class="form-check-input  m-2" type="radio" name="gender" id="female" value="F">
                <label class="form-check-label" for="female"> Female </label>
            </div>

            <div class="form-group m-1">
                <p style="margin: 15px 0px 5px 0px;">Aadhar card number</p>
                <input type="text" class="form-control" id="anumber" name="anumber" placeholder="Enter Aadhar card number" required>
            </div>

            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;">PAN card number</p>
                <input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN card number" required>
            </div>

            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;">Phone number</p>
                <input type="text" class="form-control" id="phoneno" name="phoneno" placeholder="Enter Phone number" required>
            </div>

            <div class="form-group m-1">
                <p style="margin: 20px 0px 5px 0px;">Password</p>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group m-1">
                <p style="margin: 5px 0px 5px 0px;">Confirm Password</p>
                <input type="password" class="form-control" id="cpassword" placeholder="Re-enter Password" required>
            </div>

            <button onclick="return signin()" type="submit" class="btn btn-primary" style="margin-top: 10px;">Sign in</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>