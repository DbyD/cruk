<?php
////////////////////////////////////////////////////////////////////////////////////
function getTotalAwards($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatedEmpNum = :EmpNum AND AprStatus=1');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalUnclaimedAwards($empnum){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblnominations WHERE NominatedEmpNum = :EmpNum AND AprStatus=1 AND amount='20' AND AwardClaimed='No'");
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getAllMyNominationsList($empnum) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatedEmpNum = :empnum AND AprStatus=1 ORDER BY AprDate DESC');
	$stmt->execute(array('empnum' => $empnum));
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function getNumberAwardsQuarter(){
	global $db;
	$count = 0;
	$stmt = $db->prepare("SELECT QUARTER(NOW()) AS QUARTER, COUNT(ID) AS ID FROM tblnominations WHERE awardType = 1 AND AprStatus=1 ");
	$stmt->execute();
	if ($result = $stmt->fetch()){
		$count += $result['ID'];
	}
	$stmt = $db->prepare("SELECT QUARTER(NOW()) AS QUARTER, COUNT(ID) AS ID FROM tblnominations_team WHERE awardType = 2 AND AprStatus=1 ");
	$stmt->execute();
	if ($result = $stmt->fetch()){
		$count += $result['ID'];
	}
	return $count;
}
////////////////////////////////////////////////////////////////////////////////////
 function getAllNominationsList($empnum) {
	// this needs to be fixed to include team
		global $db;
		$sql = 'SELECT X.* FROM ((
				SELECT 	ID				AS ID,
					NominatedEmpNum		AS NominatedEmpNum,
					""					AS Team,
					amount				AS amount,
					NomDate				AS NomDate,
					AprStatus			AS AprStatus,
					ApproverEmpNum		AS ApproverEmpNum 
				FROM tblnominations WHERE awardType=1 AND NominatorEmpNum = :empnum)
				UNION
				(SELECT  ID				AS ID,
					""					AS NominatedEmpNum,
					Team				AS Team,
					amount				AS amount,
					NomDate				AS NomDate,
					AprStatus			AS AprStatus,
					ApproverEmpNum		AS ApproverEmpNum
				FROM tblnominations_team WHERE awardType=2 AND NominatorEmpNum = :empnum)) X
						 ORDER BY NomDate DESC';
		$stmt = $db->prepare( $sql );
		$stmt->execute(array('empnum' => $empnum));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
    }
////////////////////////////////////////////////////////////////////////////////////
?>