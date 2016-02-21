<?php
	include '../inc/config.php';
	//echo $_POST['deleteTeamID']."<br>";
	//echo $_POST['teamid']."<br>";
	//echo $_POST['myTeamName']."<br>";
	if ($_POST['deleteTeamID'] != ""){
		$teamID = $_POST['deleteTeamID'];
		$stmt = $db->prepare("DELETE FROM tblteams WHERE id = :teamID");
		$stmt->bindParam(':teamID', $teamID);
		$stmt->execute();
	/*	$stmt = $db->prepare("DELETE FROM tblteamusers WHERE teamID = :teamID");
		$stmt->bindParam(':teamID', $teamID);
		$stmt->execute(); */
		echo "removed";
	} else {
		if ($_POST['myTeamName']){
			if (is_numeric($_POST['teamid'])) {
				$teamID = $_POST['teamid'];
				$stmt = $db->prepare("DELETE FROM tblteamusers WHERE teamID = :teamID");
				$stmt->bindParam(':teamID', $teamID);
				$stmt->execute();
				$stmt = $db->prepare("UPDATE tblteams SET myTeamName = :myTeamName WHERE id = :teamID");
				$stmt->bindParam(':myTeamName', $_POST['myTeamName']);
				$stmt->bindParam(':teamID', $teamID);
				$stmt->execute();
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
				$stmt->bindParam(':EmpNum', $list->EmpNum);
				$stmt->execute();
			}
			echo $teamID;
		}
	}
?>