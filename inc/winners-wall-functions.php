<?php
function getAllEmployees(){
	global $db;
	$sql = 'SELECT X.* FROM ((
				SELECT  "individual"		AS Type,
						n.ID				AS ID,
						""					AS TeamID,
						e.Fname				AS name,
						e.Sname				AS Sname,
						e.EmpNum			AS EmpNum,
						e.Photo				AS Photo,
						e.Department		AS Department,
						e.DirectorateInitials		AS DirectorateInitials,
						n.Volunteer			AS Volunteer,
						n.personalMessage	AS personalMessage,
						n.BeliefID			AS BeliefID,
						n.NominatorEmpNum	AS NominatorEmpNum,
						n.AprDate			AS AprDate
				FROM tblnominations AS n
				INNER JOIN tblempall AS e
				ON n.NominatedEmpNum = e.EmpNum
				WHERE n.awardType=1 AND n.AprStatus=1)
				UNION
				(SELECT  "Team"				AS Type,
						ID					AS ID,
						TeamID				AS TeamID,
						Team				AS name,
						""					AS Sname,
						""					AS EmpNum,
						""					AS Photo,
						""					AS Department,
						""					AS DirectorateInitials,
						Volunteer			AS Volunteer,
						personalMessage		AS personalMessage,
						BeliefID			AS BeliefID,
						NominatorEmpNum		AS NominatorEmpNum,
						AprDate				AS AprDate
				FROM tblnominations_team
				WHERE awardType=2 AND AprStatus=1)) X
			ORDER BY AprDate DESC';
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
function getMyMessages($empnum) {
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
			WHERE NominatedEmpNum = :recipient AND AprStatus = 1) X
			ORDER BY date DESC';
	//		ORDER BY Department = :Department DESC, date DESC';
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
function fixText($text){
	$text = str_replace('£','&pound;',$text);
	return $text;
}
////////////////////////////////////////////////////////////////////////////////////
?>