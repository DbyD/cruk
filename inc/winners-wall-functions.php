<?php
function getAllEmployees(){
	global $db;
	$sql = "
SELECT  e.ID AS ID,
		e.Fname AS name,
		e.Sname AS Sname,
		e.EmpNum AS EmpNum,
		e.Photo AS Photo,
		n.personalMessage AS personalMessage,
		n.BeliefID AS BeliefID,
		n.NominatedEmpNum AS NominatedEmpNum
FROM 
	tblnominations AS n
		INNER JOIN
	tblempall AS e
			ON n.NominatorEmpNum = e.EmpNum GROUP BY n.NominatorEmpNum";

	$stmt = $db->prepare( $sql );
	
	$stmt->execute();

	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arr[] = $result;
	}

	if( count($arr) == 0){
		return 0;
	}

	return $arr;
}
////////////////////////////////////////////////////////////////////////////////////
function getMyMessages( $empnum ) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblmessage WHERE recipient = :recipient ORDER BY date DESC');
	$stmt->execute(array('recipient' => $empnum));
	while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
		$arr[] = $result;
	}
	if(count($arr) == 0){
		return 0;
	}
	return $arr;
}
////////////////////////////////////////////////////////////////////////////////////
function getUser( $empnum ) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>