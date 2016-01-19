<?php
	include '../inc/dbconn.php';
	if ($_GET['clear'] == "yes"){
		$_SESSION['nominee']->Volunteer = "";
		unset($_SESSION['nominee']->Volunteer);
		echo "removed";
	} else {
		if ($_POST['volunteer']){
			$_SESSION['nominee']->Volunteer = $_POST['volunteer'];
			echo $_SESSION['nominee']->Volunteer;
		}
	}
?>