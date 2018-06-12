<?php
// connect to the database
	$db = mysqli_connect('localhost', 'root', '', 'ehealth');
	$tipAnaliza = $_POST['Tip'];

	$res = mysqli_query($db,"SELECT Descriere FROM tip_analize WHERE Nume='$tipAnaliza'");
	$row = mysqli_fetch_row($res);
	if($row != NULL) {
		echo $row[0];
	} else {
		echo 'ERR';
	}
	
?>