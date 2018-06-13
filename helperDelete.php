<?php
// connect to the database
	$db = mysqli_connect('localhost', 'root', '', 'ehealth');
	

	if (isset($_POST['Id'])) {
        $idStr = $_POST['Id'];
        $id = $idStr[0];
        echo $id;
    	$res = mysqli_query($db,"DELETE FROM utilizatori WHERE Id='$id'");
    		if($res) {
    			echo 'Success';
                header("Refresh:0");
    		} else {
    			echo 'Err';
                header("Refresh:0");
    		}
	}
?>
