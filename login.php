<?php
session_start();

// initializing variables
$cnp = "";
$parola  = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'ehealth');
// REGISTER USER
if (isset($_POST['login_user'])) {
	//print_r($_POST);die();
  // receive all input values from the form
  $cnp = mysqli_real_escape_string($db, $_POST['cnp']);
  $parola = mysqli_real_escape_string($db, $_POST['parola']);
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($cnp)) { array_push($errors, "CNP necompletat!"); }
  if (empty($parola)) { array_push($errors, "Parola necompletata!"); }
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM utilizatori WHERE Cnp='$cnp' and Parola='$parola'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  if ($user != null) { // if user exists
      header('location: index.php');
  }else{
	  echo "invalid data";
  }
}
?>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/style.css" type="text/css">
		<script type="text/javascript" src="assets/js/libs/jquery-3.3.1.min.js"></script>	
		<script type="text/javascript" src="assets/js/custom/script.js"></script>	
	</head>
	<body>
		<div class="login-page">
		  <div class="form">
			<form class="login-form" method="post">
			  <input type="text" name="cnp" placeholder="CNP"/>
			  <input type="password" name="parola" placeholder="Parola"/>
			  <button type="submit" class="btn" name="login_user">login</button>
			  <p class="message">Nu aveti cont? <a href="register.php">Creare cont</a></p>
			</form>
		  </div>
		</div>
	</body>
</html>