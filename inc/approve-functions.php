<?php
////////////////////////////////////////////////////////////////////////////////////
function getWorkAwards(){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblworkawards');
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function workAwardType($id){
	global $db;
	$stmt = $db->prepare('SELECT type FROM tblworkawards WHERE id = :id');
	$stmt->execute(array('id' => $id));
	return $stmt->fetch(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function getMyWorkAwards($nominationID){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblworknominations wn INNER JOIN tblworkawards wa ON wn.workawardsID = wa.id WHERE nominationID = :nominationID');
	$stmt->execute(array('nominationID' => $nominationID));
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function getNomination($ID){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE ID = :ID');
	$stmt->execute(array('ID' => $ID));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Award');
	return $stmt->fetch();
}
////////////////////////////////////////////////////////////////////////////////////
function getAllMyApprovalsList($EmpNum) {
	global $db;
	$littleExtra = 'Yes';
	$sql = 'SELECT X.* FROM (SELECT
				ID					AS ID,
				""					AS teamID,
				NominatorEmpNum		AS NominatorEmpNum,
				NominatedEmpNum		AS NominatedEmpNum,
				Volunteer			AS Volunteer,
				""					AS Team,
				NomDate				AS NomDate
			FROM tblnominations
			WHERE ApproverEmpNum = :EmpNum AND AprStatus=0 AND littleExtra= :littleExtra
			UNION
			SELECT
				""					AS ID,
				ID					AS teamID,
				NominatorEmpNum		AS NominatorEmpNum,
				""					AS NominatedEmpNum,
				Volunteer			AS Volunteer,
				Team				AS Team,
				NomDate				AS NomDate
			FROM tblnominations_team
			WHERE ApproverEmpNum = :EmpNum AND AprStatus=0 AND littleExtra= :littleExtra) X
			ORDER BY NomDate DESC';
	$stmt = $db->prepare($sql);
	$stmt->execute(array('EmpNum' => $EmpNum,'littleExtra' => $littleExtra));
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function getTeamNomination($ID){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations_team WHERE ID = :ID');
	$stmt->execute(array('ID' => $ID));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'teamAward');
	return $stmt->fetch();
}
////////////////////////////////////////////////////////////////////////////////////
function getAllApprovalsList() {
	global $db;
	$littleExtra = 'Yes';
	$sql = 'SELECT X.* FROM (SELECT
				ID					AS ID,
				""					AS teamID,
				NominatorEmpNum		AS NominatorEmpNum,
				NominatedEmpNum		AS NominatedEmpNum,
				Volunteer			AS Volunteer,
				""					AS Team,
				NomDate				AS NomDate,
				ApproverEmpNum		AS ApproverEmpNum
			FROM tblnominations
			WHERE AprStatus=0 AND littleExtra= :littleExtra
			UNION
			SELECT
				""					AS ID,
				ID					AS teamID,
				NominatorEmpNum		AS NominatorEmpNum,
				""					AS NominatedEmpNum,
				Volunteer			AS Volunteer,
				Team				AS Team,
				NomDate				AS NomDate,
				ApproverEmpNum		AS ApproverEmpNum
			FROM tblnominations_team
			WHERE AprStatus=0 AND littleExtra= :littleExtra) X
			ORDER BY NomDate DESC';
	$stmt = $db->prepare($sql);
	$stmt->execute(array('littleExtra' => $littleExtra));
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function getAllMyApprovalsHistory($EmpNum) {
	global $db;
	$littleExtra = 'Yes';
	$sql = 'SELECT X.* FROM (SELECT
				ID					AS ID,
				NominatorEmpNum		AS NominatorEmpNum,
				NominatedEmpNum		AS NominatedEmpNum,
				Volunteer			AS Volunteer,
				""					AS Team,
				NomDate				AS NomDate,
				AprStatus			AS AprStatus,
				AprDate				AS AprDate
			FROM tblnominations
			WHERE AprStatus<>0 AND littleExtra= :littleExtra AND ApproverEmpNum = :EmpNum AND awardType = 1
			UNION
			SELECT
				ID					AS ID,
				NominatorEmpNum		AS NominatorEmpNum,
				""					AS NominatedEmpNum,
				Volunteer			AS Volunteer,
				Team				AS Team,
				NomDate				AS NomDate,
				AprStatus			AS AprStatus,
				AprDate				AS AprDate
			FROM tblnominations_team
			WHERE AprStatus<>0 AND littleExtra= :littleExtra AND ApproverEmpNum = :EmpNum) X
			ORDER BY NomDate DESC';
	$stmt = $db->prepare($sql);
	$stmt->execute(array('littleExtra' => $littleExtra, 'EmpNum' => $EmpNum));
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
?>