<?php
	include '../inc/config.php';
	if ($_GET['clear'] == "yes"){
		$_SESSION['nominee']->Volunteer = "";
		unset($_SESSION['nominee']->Volunteer);
		echo "removed";
	} else {
		if ($_POST['Volunteer']){
			$_SESSION['nominee']->Volunteer = $_POST['Volunteer'];
			echo $_SESSION['nominee']->Volunteer;
		}
	}
?>