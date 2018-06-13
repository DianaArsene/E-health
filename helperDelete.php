<?php
// connect to the database
	$db = mysqli_connect('localhost', 'root', '', 'ehealth');
	$id = $_POST['id'];

	$res = mysqli_query($db,"DELETE FROM utilizatori WHERE Id = $id");

	if($res) {
		echo 'Success';
	} else {
		echo 'Err';
	}

?>