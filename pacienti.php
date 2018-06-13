<?php
session_start();
if(empty($_SESSION["user"])){
	$_SESSION["login_messages"] = "Va rugam sa va autentificati!";
	header('location: index.php');
}

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'ehealth');

//SET AN APPOINTMENT
if (isset($_POST['upload_data'])) {
	$tip = $_POST['tip_analize'];
	$numeDoctor = explode(" ", $_POST['numeDoctor']);
	$nume = $numeDoctor[0];
	$prenume = $numeDoctor[1];
	$data = $_POST['data'];
	$dateTime = new DateTime($data);
	$formatted_date=date_format ( $dateTime, 'Y-m-d' );
	//echo $formatted_date;
	$ora = $_POST['ora'];

	//echo 'tip: '. $tip . ' nume: '. $nume . ' prenume: ' . $prenume . ' data: ' . $data . ' ora: ' . $ora;
	$medic = mysqli_query($db, "SELECT Id FROM utilizatori 
								WHERE Nume = '$nume' AND Prenume = '$prenume'");
	$medicId = mysqli_fetch_row($medic);
	$medicIdInt = (int)$medicId[0];
	//echo ' medicId: ' . $medicIdInt;
	$tipAnaliza = mysqli_query($db, "SELECT Id FROM tip_analize 
								WHERE Nume='$tip'");
	$tipAnalizaId = mysqli_fetch_row($tipAnaliza);
	$tipAnalizaIdInt = (int)$tipAnalizaId[0];
	//echo ' tipAnalizaId: ' . $tipAnalizaIdInt;
	$user_id = $_SESSION['user']['Id'];
	$programare = mysqli_query($db,
			"INSERT INTO programari (Id_pacient,Id_tip_analiza,Data, Id_medic, Status) 
			 VALUES($user_id, $tipAnalizaIdInt, '$formatted_date', $medicIdInt, 0)");
	if($programare) {
		$type = "success";
		$text = "Programarea dumneavoastra a fost inregistrata cu succes!";
	} else {
		$type = "danger";
		$text = "Programarea dumneavoastra nu a fost salvata.";
		//echo("Error description: " . mysqli_error($db));
	}
	echo "<div class=\"alert alert-".$type."\" role=\"alert\">
       					<p>".$text."</p>
      					</div>";
}
?>

<html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="assets/css/styleAsistenti.css" type="text/css">

	<!--<script type="text/javascript" src="datepicker-ro.js"></script> -->	
	<!-- JQUERY--> 

	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.js"></script>
	<!-- END JQ -->


	<!-- BOOTSTRAP CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	
	<!--END -->

	<script>
	  $( function() {
	    $( "#datepicker" ).datepicker();
	  } );

		$('input.timepicker').timepicker();
	</script>
</head>
<body>
	<div class="page_menu">
	  <div class="salut" >
		  Salut ! 
		  <?php 
		  echo $_SESSION["user"]["Nume"] . " " . $_SESSION["user"]["Prenume"];?>
	  </div>
	  <div class="logout">
	  	<button type="button" class="btn btn-primary" name="logout"><a href="logout.php">Logout</a></button>
	  </div>
	</div>
	<div class="card">
		<img src="pacienti2.jpg" class="img-fluid imgBanner2">
		<h2 style="margin: 0 auto;text-align:center;margin-top:20px;">Programare</h2>
		<div class="form paddingClass2">
			<form class="login-form" method="post">
				<div class="row">
					<div class="col-sm-6">
						<label for="sel1">Tip de analiza:</label>
						<select class="form-control" id="sel1" name="tip_analize">
							<option> -- Selectati -- </option>
							<?php
								$res = mysqli_query($db, "SELECT Nume
						  								FROM tip_analize");
								while($rows = mysqli_fetch_row($res)){ ?>
									<option> <?php echo ($rows[0]); ?> </option>
							<?php }
							?>
						</select>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
			                <label for="sel1">Data programare:</label>
			                <input type="text" id="datepicker" name="data" class="form-control"></p>
			            </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<label for="sel1">Doctor:</label>
						<select class="form-control" id="sel" name="numeDoctor">
							<option> -- Selectati -- </option>
							<?php
								$res = mysqli_query($db, "SELECT Nume, Prenume
						  								FROM utilizatori 
														WHERE Tip='3'");
								while($rows = mysqli_fetch_row($res)){
									$numeDoctor = $rows[0].' '. $rows[1];
								?>
									<option> <?php echo ($numeDoctor); ?> </option>
								<?php }
							?>


						</select>
					</div>
					<div class="col-sm-6">
						<label for="sel1">Ora:</label>
						<input type="text" class="form-control" name="ora"/>
					</div>

				</div>
				<div class="row">
					<br />
					<button type="submit" class="center-block btn btn-primary btnIncarcaAnalize" name="upload_data">Programeaza-ma</button>
				</div>
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />

				
			</form>
		</div>
	</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>
