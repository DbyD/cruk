<?php
function getAllEmployees(){
	global $db;
	$sql = "
SELECT  n.ID AS ID,
		e.Fname AS name,
		e.Sname AS Sname,
		e.EmpNum AS EmpNum,
		e.Photo AS Photo,
		n.Volunteer AS Volunteer,
		n.personalMessage AS personalMessage,
		n.BeliefID AS BeliefID,
		n.NominatorEmpNum AS NominatorEmpNum
FROM 
	tblnominations AS n
		INNER JOIN
	tblempall AS e
			ON n.NominatedEmpNum = e.EmpNum ORDER BY AprDate DESC LIMIT 20";
///			ON n.NominatorEmpNum = e.EmpNum GROUP BY n.NominatorEmpNum";

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
	$sql = 'SELECT
				sender			AS sender,
				recipient		AS recipient,
				text			AS text,
				date			AS date
			FROM tblmessage
			WHERE recipient = :recipient
			UNION
			SELECT
				NominatorEmpNum	AS sender,
				NominatedEmpNum	AS recipient,
				personalMessage	AS text,
				NomDate			AS date
			FROM tblnominations
			WHERE NominatedEmpNum = :recipient
			ORDER BY date DESC';
//	$stmt = $db->prepare('SELECT * FROM tblmessage WHERE recipient = :recipient ORDER BY date DESC');
	$stmt = $db->prepare($sql);
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