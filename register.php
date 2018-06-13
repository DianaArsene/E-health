<?php
session_start();

// initializing variables
$cnp = "";
$parola  = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'ehealth');
// REGISTER USER
if (isset($_POST['create_user'])) {
  // receive all input values from the form
  $nume = mysqli_real_escape_string($db, $_POST['nume']);
  $prenume = mysqli_real_escape_string($db, $_POST['prenume']);
  $telefon = mysqli_real_escape_string($db, $_POST['telefon']);
  $cnp = mysqli_real_escape_string($db, $_POST['cnp']);
  $varsta = mysqli_real_escape_string($db, $_POST['varsta']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $parola = mysqli_real_escape_string($db, $_POST['parola']);
  $confirm_parola = mysqli_real_escape_string($db, $_POST['confirm_parola']);
  $usertype = mysqli_real_escape_string($db, $_POST['usertype']);
  $captchaResult = mysqli_real_escape_string($db, $_POST['captchaResult']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($nume)) { array_push($errors, "Nume necompletat!"); }
  if (empty($prenume)) { array_push($errors, "Prenume necompletat!"); }
  if (empty($telefon)) { array_push($errors, "Telefon necompletat!"); }
  if (empty($varsta)) { array_push($errors, "Varsta necompletata!"); }
  if (empty($email)) { array_push($errors, "Email necompletat!"); }
  if (empty($parola)) { array_push($errors, "Parola necompletata!"); }
  if (empty($parola)) { array_push($errors, "Confirmare parola necompletata!"); }
  if ($parola != $confirm_parola) {
		array_push($errors, "Cele 2 parole nu corespund!");
  }

  if($captchaResult != $_SESSION["custom_captcha"]){
		array_push($errors, "Captcha invalid!");
	}
  if(count($errors) == 0) {
    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM utilizatori WHERE CNP='$cnp'";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['cnp'] === $cnp) {
        array_push($errors, "CNP deja existent");
      }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
      $parola = md5($confirm_parola);//encrypt the password before saving in the database
      $query = "INSERT INTO utilizatori (nume, prenume, telefon, cnp, email, varsta, parola, tip) 
  			  VALUES('$nume', '$prenume', '$telefon','$cnp','$email','$varsta','$parola' ,'$usertype')";
      mysqli_query($db, $query);
      $_SESSION['messages'] = "Contul a fost creat cu succes !";
      header('location: login.php');
    }
  }
}
?>
<html>
	<head>
		<link rel="stylesheet"
					href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">

		<script
			src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/libs/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="assets/js/custom/script.js"></script>
	</head>
	<body>
	<?php
			if(count($errors) > 0){
				echo "<div class='error_wrapper'>";
				echo "<div class='alert alert-danger alert-dismissible'>";
				echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
				echo "<strong>Inregistrare nereusita !</strong>";
				foreach ($errors as $err){
					echo "<div>".$err."</div>";
				}
				echo "</div>";
				echo "</div>";
			}
			?>
		<div class="login-page">
		  <div class="form">
				<h2> Inregistrare </h2>
				<form class="login-form" method="post">
					<input type="text"  name ="nume" placeholder="Nume"/>
					<input type="text" name ="prenume" placeholder="Prenume"/>
					<input type="text" name ="telefon" placeholder="Telefon"/>
					<input type="text" name ="cnp" placeholder="CNP"/>
					<input type="text" name ="email" placeholder="Email"/>
					<input type="text" name ="varsta" placeholder="Varsta"/>
					<input type="password" name ="parola" placeholder="Parola"/>
					<input type="password" name ="confirm_parola" placeholder="Confirmare parola"/>
					<select name="usertype">
						<option value="">Alegeti tipul utilizatorului:</option>
						<option value="1">Pacient</option>
						<option value="2">Asistent medical</option>
						<option value="3">Medic</option>
					</select>
					<?php
						$val1 = rand(1,9); $val2 = rand(1,9);
						$_SESSION['custom_captcha'] = $val1 + $val2;
						echo "<div class='captcha_wrapper'> Rezultatul calculului: ".$val1 . "+". $val2 ."</div>";
					?>
					<input type="text" name ="captchaResult" placeholder="Rezultat"/>
					<button type="submit" class="btn" name="create_user">create</button>
					<p class="message">Aveti cont? <a href="#">Logare</a></p>
				</form method="post">
			</div>
		</div>
	</body>
</html>