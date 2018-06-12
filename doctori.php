<?php
	// connect to the database
	$db = mysqli_connect('localhost', 'root', '', 'ehealth');
?>

<html>
<head>
	<title>Doctori</title>
	<link rel="stylesheet" href="assets/css/styleAsistenti.css" type="text/css">
	<script type="text/javascript" src="assets/js/libs/jquery-3.3.1.min.js"></script>	

	<!-- BOOTSTRAP CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--END -->
</head>
<body>
	<div class="card">
		<img src="doctor.jpg" class="img-fluid imgBanner2">
		<div class="form paddingClass">
		
			<h2 class="col-sm-3"><span class="label label-info">Pacienti tratati: 57</span></h2>
			<h2 class="col-sm-3"><span class="label label-warning">Paicenti programati: 12</span></h2>
			<h2 class="col-sm-3"></h2>
			<h2 class="col-sm-3"></h2>
		
			<div class="col-sm-12">
			<h3>Pacientii mei:</h3>
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Pacient</th>
						<th>Telefon</th>
						<th>Cnp</th>
						<th>Email</th>
						<th>Varsta</th>
						<th>Analiza</th>
						<th>Descriere</th>
						<th>Data</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$query = mysqli_query($db, "
							SELECT 	
								programari.Id, 
								utilizatori.Nume,
								utilizatori.Prenume,
								utilizatori.Telefon,
								utilizatori.Cnp,
								utilizatori.Email,
								utilizatori.Varsta,
								tip_analize.Nume,
								tip_analize.Descriere,
								programari.Data
							FROM programari 
							left join utilizatori on programari.Id_pacient = utilizatori.Id 
							left join tip_analize on programari.Id_tip_analiza = tip_analize.Id");
							while ($programare = mysqli_fetch_row($query)) {
								echo '<tr>';
									echo '<td>'.$programare[0].'</td>';
									echo '<td>'.$programare[1].' '.$programare[2].'</td>';
									echo '<td>'.$programare[3].'</td>';
									echo '<td>'.$programare[4].'</td>';
									echo '<td>'.$programare[5].'</td>';
									echo '<td>'.$programare[6].'</td>';
									echo '<td>'.$programare[7].'</td>';
									echo '<td>'.$programare[8].'</td>';
									echo '<td>'.$programare[9].'</td>';
								echo '<tr>';
							}
					?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>
