<?php
////////////////////////////////////////////////////////////////////////////////////
function getTotalReport($startdate = '' ,$enddate = ''){
	global $db;
	if ($startdate != ''){
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NomDate >= :startdate AND NomDate <= :enddate');
		$stmt->bindParam(':startdate', $startdate);
		$stmt->bindParam(':enddate', $enddate);
	} else {
		$stmt = $db->prepare('SELECT * FROM tblnominations');
	}
	$stmt->execute();
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalPendingReport($startdate = '' ,$enddate = ''){
	global $db;
	if ($startdate != ''){
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NomDate >= :startdate AND NomDate <= :enddate AND AprStatus=0');
		$stmt->bindParam(':startdate', $startdate);
		$stmt->bindParam(':enddate', $enddate);
	} else {
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE AprStatus=0');
	}
	$stmt->execute();
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalApprovedReport($startdate = '' ,$enddate = ''){
	global $db;
	if ($startdate != ''){
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NomDate >= :startdate AND NomDate <= :enddate AND  AprStatus=1');
		$stmt->bindParam(':startdate', $startdate);
		$stmt->bindParam(':enddate', $enddate);
	} else {
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE AprStatus=1');
	}
	$stmt->execute();
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalDeclinedReport($startdate = '' ,$enddate = ''){
	global $db;
	if ($startdate != ''){
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NomDate >= :startdate AND NomDate <= :enddate AND  AprStatus=2');
		$stmt->bindParam(':startdate', $startdate);
		$stmt->bindParam(':enddate', $enddate);
	} else {
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE AprStatus=2');
	}
	$stmt->execute();
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTopTen($limit) {
	global $db;
	$stmt = $db->prepare("SELECT NominatedEmpNum, Count(*) AS nominations FROM tblnominations GROUP BY NominatedEmpNum ORDER BY nominations DESC LIMIT :limit ,5");
	$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}
	
////////////////////////////////////////////////////////////////////////////////////
?>