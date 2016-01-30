<?php
	include '../inc/config.php';
	if ($_GET['clear'] == "yes"){
		$_SESSION['nominee']->Volunteer = "";
		unset($_SESSION['nominee']->Volunteer);
		echo "removed";
	} else {
		if ($_POST['Reason']){
			$_SESSION['nominee']->Reason = $_POST['Reason'];
			echo "added";
		}
	}
?>