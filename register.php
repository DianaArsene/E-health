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

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($nume)) { array_push($errors, "Nume necompletat!"); }
  if (empty($prenume)) { array_push($errors, "Prenume necompletat!"); }
  if (empty($telefon)) { array_push($errors, "Telefon necompletat!"); }
  if (empty($varsta)) { array_push($errors, "Varsta necompletata!"); }
  if (empty($email)) { array_push($errors, "Email necompletat!"); }
  if (empty($parola)) { array_push($errors, "Parola necompletata!"); }
  if ($parola != $confirm_parola) {
	array_push($errors, "Cele 2 parole nu corespund!");
  }
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM utilizatori WHERE Nume='$nume' and Email='$email' and Prenume='$prenume' and Telefon='$telefon' and CNP='$cnp' and Varsta='$varsta' and Parola='$parola'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['nume'] === $nume) {
      array_push($errors, "Nume deja existent");
    }
    if ($user['prenume'] === $prenume) {
      array_push($errors, "Prenume deja existent");
    }
	   if ($user['email'] === $email) {
      array_push($errors, "Email deja existent");
    }
	  if ($user['telefon'] === $telefon) {
      array_push($errors, "Telefon deja existent");
    }
	 if ($user['varsta'] === $varsta) {
      array_push($errors, "Varsta deja existenta");
    }
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
  	$_SESSION['nume'] = $nume;
  	$_SESSION['success'] = "Sunteti logat acum";
  	header('location: index.php');
  }
}
?>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/style.css" type="text/css">
		<script src="node_modules/jquery-captcha/dist/jquery-captcha.min.js"></script>
		<script type="text/javascript" src="assets/js/libs/jquery-3.3.1.min.js"></script>	
		<script type="text/javascript" src="assets/js/custom/script.js"></script>	
	</head>
	<body>
		<div class="login-page">
		  <div class="form">
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
			  <button type="submit" class="btn" name="create_user">create</button>
			  <p class="message">Aveti cont? <a href="#">Logare</a></p>
			</form method="post">
		  </div>
		</div>
	</body>
</html>