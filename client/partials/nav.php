<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" style="margin-left: 16px;" href="./main.php">Exact-tax</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./documents.php">Upload documents</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./payment.php">Payment section</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./summary.php">Tax summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./enterSOI.php">Enter income details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./enterProperties.php">Enter property details</a>
                </li>
            </ul>
        </div>
        <div style=" margin-left: auto; margin-right: 0px;">
            <a class="nav-link" style="color: aliceblue;" href="#">Welcome <?php echo $clientName; ?></a>
        </div>
		<a href="./login.php"><button type="button" class="btn btn-light" style="padding: 4px; margin-right: 5px">Log out</button></a>
    </nav>