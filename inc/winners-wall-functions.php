<?php
function getAllEmployees(){
	global $db;
	$sql = "
SELECT  n.ID AS ID,
		e.Fname AS name,
		e.Sname AS Sname,
		e.EmpNum AS EmpNum,
		e.Photo AS Photo,
		e.Department AS Department,
		n.Volunteer AS Volunteer,
		n.personalMessage AS personalMessage,
		n.BeliefID AS BeliefID,
		n.NominatorEmpNum AS NominatorEmpNum
FROM 
	tblnominations AS n
		INNER JOIN
	tblempall AS e
			ON n.NominatedEmpNum = e.EmpNum
			WHERE n.awardType=1 AND n.AprStatus=1 
			ORDER BY n.AprDate DESC LIMIT 20";
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
function getMyMessages($empnum,$department) {
	global $db;
	$sql = 'SELECT X.* FROM (SELECT
				sender			AS sender,
				recipient		AS recipient,
				text			AS text,
				date			AS date,
				"m"				AS award,
				Department		AS Department
			FROM tblmessage
			WHERE recipient = :recipient
			UNION
			SELECT
				NominatorEmpNum	AS sender,
				NominatedEmpNum	AS recipient,
				personalMessage	AS text,
				AprDate			AS date,
				"a"				AS award,
				Department		AS Department
			FROM tblnominations
			WHERE NominatedEmpNum = :recipient) X
			ORDER BY Department = :Department DESC, date DESC';
//	$stmt = $db->prepare('SELECT * FROM tblmessage WHERE recipient = :recipient ORDER BY date DESC');
	$stmt = $db->prepare($sql);
	$stmt->execute(array('recipient' => $empnum,'Department' => $department));
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