<?php
	include '../inc/config.php';
	if ($_GET['clear'] == "yes"){
		$_SESSION['nominee']->Volunteer = "";
		unset($_SESSION['nominee']->Volunteer);
		echo "removed";
	} else {
		if ($_POST['myTeamName']){
			echo 'id='.$_POST['teamid'].'=<br>';
			if($_POST['teamid'] != ""){
				$teamID = $_POST['teamid'];
				$stmt = $db->prepare("DELETE FROM tblteamusers WHERE teamID = :teamID");
				$stmt->bindParam(':teamID', $teamID);
				$teamID = $stmt->execute();
			} else {
				$stmt = $db->prepare("INSERT INTO tblteams (EmpNum, myTeamName) VALUES (:EmpNum, :myTeamName)");
				$stmt->bindParam(':EmpNum', $_SESSION['user']->EmpNum);
				$stmt->bindParam(':myTeamName', $_POST['myTeamName']);
				$stmt->execute();
				$teamID = $db->lastInsertId();
			}
			foreach ($_SESSION['TeamMembers'] as $list){
				$stmt = $db->prepare("INSERT INTO tblteamusers (teamID, EmpNum) VALUES (:teamID, :EmpNum)");
				$stmt->bindParam(':teamID', $teamID);
				$stmt->bindParam(':EmpNum', $list['EmpNum']);
				$stmt->execute();
			}
			echo "created";
		}
	}
?>