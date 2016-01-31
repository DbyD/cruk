<?php
	include '../inc/config.php';
	if ($_GET['clear'] == "yes"){
		$_SESSION['nominee']->Reason = "";
		$_SESSION['nominee']->littleExtra = 'No';
		$_SESSION['nominee']->workAward = "";
		echo "removed";
	} else {
		if ($_POST['Reason']){
			if(($_SESSION['nominee']->AppEmpNum == $_SESSION['user']->EmpNum)){
				$workAward = new StdClass();
				foreach ($_POST as $key => $value){
				   if (strstr($key, 'workAward')){
						$workAward->$key = $value;
				   }
				}
				$_SESSION['nominee']->workAward = $workAward;
			}
			$_SESSION['nominee']->Reason = $_POST['Reason'];
			$_SESSION['nominee']->littleExtra = 'Yes';
			echo $_POST['Reason'];
		}
	}
?>