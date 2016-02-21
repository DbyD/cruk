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
			if(isset($_POST['includeMe']) && $_POST['includeMe'] == 'includeMe'){
				$_SESSION['teamnominee']->includeMe = $_POST['includeMe'];
			} else {
				$_SESSION['teamnominee']->includeMe = 'excludeMe';
			}
			echo $_SESSION['teamnominee']->Reason;
		}
	}
?>