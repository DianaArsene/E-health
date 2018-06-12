<?php

// initializing variables
$cnp = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'ehealth');
// REGISTER USER
if (isset($_POST['upload_data'])) {
	// receive all input values from the form
	$tip_analiza = $_POST['tipAnaliza'];
	$descriere_analiza = $_POST['descriere'];
	$cnp = $_POST['cnp'];
	echo  $tip_analiza . ' ' . $descriere_analiza . ' ' . $cnp . '<br />';

	$query = "INSERT INTO tip_analize (nume, descriere) 
			  VALUES('$tip_analiza', '$descriere_analiza')";
	$result = mysqli_query($db, $query);
	


	$res = mysqli_query($db, "SELECT Id_tip_analiza, Status
							  FROM programari 
								WHERE Id_pacient IN (SELECT Id FROM utilizatori WHERE Cnp = '$cnp')");
	while($rows = mysqli_fetch_row($res)) {
		//$rows[0] = '1';
		$res2 = mysqli_query($db,"UPDATE programari SET Status='1' WHERE id='$rows[0]'");
		if($res2) echo "ok < br />";
		else echo 'fail :( < br />';
	}

	//print_r(expression)
	if($res)
		echo "Success2";
	else
		echo "Error2";
}
?>

<html>
<head>
	<link rel="stylesheet" href="assets/css/styleAsistenti.css" type="text/css">
	<script type="text/javascript" src="assets/js/libs/jquery-3.3.1.min.js"></script>	
	<!--<script type="text/javascript" src="assets/js/custom/script.js"></script>	-->

	<!-- BOOTSTRAP CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--END -->
</head>
<body>
	<div class="card">
		<img src="analize2.jpg" class="img-fluid imgBanner">
		<div class="form paddingClass">
			<form class="login-form" method="post">
				<div class="row">
					<div class="col-sm-6">
						<label>Tip Analiza:</label>
						<input type="text" class="form-control" name="tipAnaliza">
						<label>Descriere:</label>
						<input type="text" class="form-control" name="descriere">
						
					</div>
					<div class="col-sm-6">
						<label>CNP Pacient:</label>
						<input type="number" class="form-control" name="cnp">
						
						<button type="submit" class="btn btn-primary btnIncarcaAnalize" name="upload_data">Incarca Detalii Analize</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>