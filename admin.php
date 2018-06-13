<?php
session_start();
if(empty($_SESSION["user"])){
	$_SESSION["login_messages"] = "Va rugam sa va autentificati!";
	header('location: index.php');

}
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'ehealth');
//permite acces => Schimba status in 1
/*if (isset($_POST['allowAcc'])) {
	///$utilizator = $_POST['utilizator1'];
	///echo ($utilizator);
	
} else if (isset($_POST['delete'])) {

}*/

?>

<html>
<head>
	<title>Admin Page</title>
	<link rel="stylesheet" href="assets/css/styleAsistenti.css" type="text/css">

	<!-- BOOTSTRAP CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
	<!-- Latest compiled JavaScript -->
	<script type="text/javascript" src="assets/js/libs/jquery-3.3.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--END -->

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
		<img src="doctor.jpg" class="img-fluid imgBanner2">
		<div class="form paddingClassIndex">
			<form class="login-form" method="post">
				<table id="example" class="table table-bordered table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Id</th>
							<th>Nume</th>
							<th>Prenume</th>
							<th>Telefon</th>
							<th>CNP</th>
							<th>Email</th>
							<th>Varsta</th>
							<th>Tip</th>
							<th>Validare</th>
						</tr>
					</thead>
					<tbody>

						<?php 
						$res = mysqli_query($db, "SELECT Id, Nume, Prenume, Telefon, CNP, Email, Varsta, Tip	FROM utilizatori WHERE Status = 0 AND Tip != 0");
						$num_rows = mysqli_num_rows($res);
						if($num_rows > 0){
							while($rows = mysqli_fetch_row($res)) {

								?> <tr>
								<?php

								foreach ($rows as $key => $data ){
									?>
									<td><?php
										if($key == 7){
											if($data == 1){
												echo "Pacient";
											}elseif ($data == 3){
												echo "Doctor";
											}elseif ($data == 2){
												echo "Asistent";
											}else{
												echo $data;
											}
										}else{
											echo $data;
										}

									}?></td>
									<td>
										<button id='<?php echo $rows[0]; ?>' type='button' class='btn btn-primary' onClick='allowAcc(this.id)'>Permite acces</button>
										<button id='<?php echo $rows[0]; ?>' type='button' class='btn btn-danger' onClick='deleteAcc(this.id)'>Elimina din lista</button>
									</td>
									<?php }
						}else{?>
						<tr><td colspan="9" style="text-align: center; font-weight: bold"> Momentan nu exista utilizatori de aprobat !</td></tr>
									<?php } ?>
							</tr>				           
						</tbody>
					</table>
				</form>

			</div>
		</div>
	</div>

	<script type="text/javascript">
	function allowAcc(clicked_id)
	{
		$.ajax({
			type: 'POST',
			url: 'helperUpdate.php',
			data: { Id:clicked_id},
			success: function(result){
				if(result == 'Success')
					alert('Utilizatorul a primit permisiunile necesare !');
				else
					alert('Permisiunile nu au fost acordate !');
				location.reload();
			},
			error: function() {
				alert('A aparut o eroare !');
				location.reload();
			}
		});
	}

	function deleteAcc(clicked_id)
	{
		$.ajax({
			type: 'POST',
			url: 'helperDelete.php',
			data: { id: clicked_id},
			success: function(result){
				if(result == 'Success') {
					alert('Utilizator a fost sters din sistem!');
				}
				else {
					alert('Stergerea nu a putut fi efectuata! Este posibil ca utilizatorul sa fie deja asociat unei programari sau sa figureze in baza de date cu analize.');
				}
				location.reload();
			},
			error: function() {
				alert('A aparut o eroare !');
				location.reload();
			}
		});
	}
	</script>
</body>
</html>
