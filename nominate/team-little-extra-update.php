<?php
	include '../inc/config.php';
	if ($_GET['clear'] == "yes"){
		$_SESSION['teamnominee']->Reason = "";
		$_SESSION['teamnominee']->littleExtra = 'No';
		$_SESSION['teamnominee']->workAward = "";
		echo "removed";
	} else {
		if ($_POST['Reason']){
			$_SESSION['teamnominee']->workAward = $_POST['workAward'];
			$_SESSION['teamnominee']->Reason = $_POST['Reason'];
			$_SESSION['teamnominee']->littleExtra = 'Yes';
			return $_SESSION['teamnominee']->workAward;
		}
	}
?>