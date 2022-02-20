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
		<div class="card1" style="width: 70%; margin: auto; margin-top: 30px; text-align: center;">
			
            <div style="width: 70%; margin: auto;">
                <h3>Current tax rates</h3>
                <table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">Category</th>
							<th scope="col">Tax rate</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">is1</th>
							<td>2%</td>
						</tr>
						<tr>
							<th scope="row">is2</th>
							<td>3%</td>
						</tr>
						<tr>
							<th scope="row">is3</th>
							<td>4%</td>
						</tr>
                        <tr>
							<th scope="row">is4</th>
							<td>5%</td>
						</tr>
					</tbody>
				</table>
                <br><br>

                <h3>Update tax rates</h3>

                <div class="form-group m-1">
                    <p style="margin: 5px 0px 5px 0px;" >Category of income</p><br>
                    <select name="toi" id="toi" title="category" class="btn btn-secondary btn-sm">
                        <option value="volvo">is1</option>
                        <option value="saab">is2</option>
                        <option value="mercedes">is3</option>
                        <option value="audi">is4</option>
                    </select>
                </div>

                <div class="form-group m-1">
                    <p style="margin: 15px 0px 5px 0px;" >Updated value</p>
                    <input type="number" id="newrate" name="quantity" min="1" max="10">
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Update</button>
            </div>

		</div>
	</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>
</body>

</html>