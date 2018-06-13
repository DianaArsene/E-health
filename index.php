<?php

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
	<script type="text/javascript" src="assets/js/libs/jquery-3.3.1.min.js"></script>	

	<!-- BOOTSTRAP CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--END -->

</head>
<body>
	<div class="card">
		<img src="doctor.jpg" class="img-fluid imgBanner2">
		<div class="form paddingClassIndex">
			<form class="login-form" method="post">
				<table id="example" class="table table-striped" style="width:100%">
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
						$res = mysqli_query($db, "SELECT Id, Nume, Prenume, Telefon, CNP, Email, Varsta, Tip
							FROM utilizatori WHERE Status = 0");

						while($rows = mysqli_fetch_row($res)) {

							?> <tr>
							<?php

							foreach ($rows as $data){
				            				//$name2 = 'utilizator'.$i;
								?>
								<td><?php echo $data;  }?></td>
								<td>
									<button id='<?php echo $rows[0]; ?>' type='submit' class='btn btn-primary' onClick='allowAcc(this.id)'>Permite acces</button>
									<button id='<?php echo ($rows[0] . '1'); ?>' type='submit' class='btn btn-danger' onClick='deleteAcc(this.id)'>Elimina din lista</button>
								</td>
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
				alert('Utilizatorul a primit permisiunile necesare');

			}
		});
	}

	function deleteAcc(clicked_id)
	{
		//alert(clicked_id);
		$.ajax({
			type: 'POST',
			url: 'helperDelete.php',
			data: { Id:clicked_id},
			success: function(result){ 

				alert('Utilizator a fost sters');
				//location.reload();
				
			}
		});
	}
	</script>
</body>
</html>
