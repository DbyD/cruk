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
	$stmt = $db->prepare("SELECT QUARTER(NOW()) AS QUARTER, COUNT(ID) AS ID FROM tblnominations WHERE awardType = 1 AND AprStatus=1 ");
	$stmt->execute();
	if ($result = $stmt->fetch()){
		return $result['ID'];
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
?>