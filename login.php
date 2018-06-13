<?php
session_start();

// initializing variables
$cnp = "";
$parola = "";
$errors = array();
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'ehealth');
// REGISTER USER
if (isset($_POST['login_user'])) {
  // receive all input values from the form
  $cnp = mysqli_real_escape_string($db, $_POST['cnp']);
  $parola = mysqli_real_escape_string($db, $_POST['parola']);
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($cnp)) {
    array_push($errors, "CNP necompletat !");
  }
  if (empty($parola)) {
    array_push($errors, "Parola necompletata !");
  }
  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  if(count($errors) == 0){
    $user_check_query = "SELECT * FROM utilizatori WHERE Cnp='$cnp' and Parola='$parola'";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user != NULL) { // if user exists
      header('location: index.php');
    }
    else {
      array_push($errors, "CNP sau Parola invalide !");
    }
  }
}
?>

<html>
  <head>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">

    <script type="text/javascript"
            src="assets/js/libs/jquery-3.3.1.min.js"></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/custom/script.js"></script>

  </head>
  <body>
    <?php
      // Display the successfully register message and unset the variable
        if(!empty($_SESSION['messages'])){
          echo "<div class='message_wrapper'>";
          echo "<div class='alert alert-success alert-dismissible'>";
          echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
          echo "<strong>Inregistrare reusita !</strong>";
          echo "<div>".$_SESSION['messages']."</div>";
          echo "</div>";
          echo "</div>";
          unset($_SESSION['messages']);
        }
    ?>
    <?php
      if(count($errors) > 0){
        echo "<div class='message_wrapper'>";
        echo "<div class='alert alert-danger alert-dismissible'>";
        echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
        echo "<strong>Autentificare nereusita !</strong>";
        foreach ($errors as $err){
          echo "<div>".$err."</div>";
        }
        echo "</div>";
        echo "</div>";
      }
    ?>

    <div class="login-page">
      <div class="form">
        <h2> Autentificare </h2>
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