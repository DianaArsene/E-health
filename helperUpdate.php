<?php
// connect to the database
	$db = mysqli_connect('localhost', 'root', '', 'ehealth');
	$id = $_POST['Id'];

	$res = mysqli_query($db,"UPDATE utilizatori SET Status=1 WHERE Id='$id'");
  if($res == true) {
		echo 'Success';
	} else {
		echo 'Err';
	}
?>