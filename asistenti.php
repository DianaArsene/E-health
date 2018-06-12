<?php

// initializing variables
$cnp = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'ehealth');
// UPLOAD DATA
if (isset($_POST['upload_data'])) {
	// receive all input values from the form
	$tip_analiza = $_POST['tipAnaliza'];
	$valoare = $_POST['valoare'];
	$cnp = $_POST['cnp'];
	//echo  $tip_analiza . ' ' . $descriere_analiza . ' ' . $cnp . '<br />';

	$res = mysqli_query($db, "SELECT Id, Id_tip_analiza, Id_medic
							  FROM programari 
								WHERE Id_pacient IN (SELECT Id FROM utilizatori WHERE Cnp = '$cnp')");
	if($res) {
		$type = "success";
		$text = "Detaliile au fost introduse in baza de date!";
	} else {
		$type = "danger";
      	$text = "Datele nu au fost introduse.";
	}
	echo "<div class=\"alert alert-".$type."\" role=\"alert\">
        					<p>".$text."</p>
      					</div>";
	
	while($rows = mysqli_fetch_row($res)) {
		//$rows[0] = '1';
		$res2 = mysqli_query($db,"UPDATE programari SET Status='1' WHERE id='$rows[1]'");
		$res3 = mysqli_query($db,
			"INSERT INTO rezultate_analize (Id_programare,Rezultat_analize,Interpretare,Observatii) 
			 VALUES('$rows[0]', '$valoare', '', '')");
		/*if($res3) {
			echo "Succes"; 
      	} else {
      		echo "Error2"; 
		}*/
		
	}

}
?>

<html>
<head>
	<title>Asistenti</title>
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
					</div>
					<div class="col-sm-6">
						<label>CNP Pacient:</label>
						<input type="number" class="form-control" name="cnp">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<label>Valoare Proba Colectata:</label>
						<input type="text" class="form-control" name="valoare">
					</div>
					<div class="col-sm-6">
						<button type="submit" class="btn btn-primary btnIncarcaAnalize" name="upload_data">Incarca Detalii Analize</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
