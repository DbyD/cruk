<?php
	include '../inc/dbconn.php';
	if($_POST['formName'] == 'nominateColleague'){
		createNominee($_POST['EmpNum']);
	}
	if($_POST['formName'] == 'nominateColleague2'){
		$_SESSION['nominee']->BeliefID = $_POST['BeliefID'];
		$_SESSION['nominee']->personalMessage = $_POST['personalMessage'];
		if($_POST['littleExtra']){
			$_SESSION['nominee']->littleExtra = 'Yes';
		} else {
			$_SESSION['nominee']->littleExtra = 'No';
		}
		if($_POST['awardPrivate']){
			$_SESSION['nominee']->awardPrivate = 'Yes';
		} else {
			$_SESSION['nominee']->awardPrivate = 'No';
		}
	}
?>