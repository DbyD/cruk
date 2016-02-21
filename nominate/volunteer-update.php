<?php
	include '../inc/config.php';
	if ($_GET['clear'] == "yes"){
		if(isset($_SESSION['nominee'])){
			$_SESSION['nominee']->Volunteer = "";
			unset($_SESSION['nominee']->Volunteer);
		}
		if(isset($_SESSION['teamnominee'])){
			$_SESSION['teamnominee']->Volunteer = "";
			unset($_SESSION['teamnominee']->Volunteer);
		}
		echo "removed";
	} else {
		if ($_POST['Volunteer']){
			if(isset($_SESSION['nominee'])){
				$_SESSION['nominee']->Volunteer = $_POST['Volunteer'];
				$_SESSION['nominee']->VolunteerDepartment = $_POST['VolunteerDepartment'];
				echo $_SESSION['nominee']->Volunteer;
			}
			if(isset($_SESSION['teamnominee'])){
				$_SESSION['teamnominee']->Volunteer = $_POST['Volunteer'];
				$_SESSION['teamnominee']->VolunteerDepartment = $_POST['VolunteerDepartment'];
				echo $_SESSION['teamnominee']->Volunteer;
			}
		}
	}
?>