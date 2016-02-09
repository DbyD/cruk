<?php
////////////////////////////////////////////////////////////////////////////////////
function createNominee($empnum){
	global $result, $db;
	$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	if ($result = $stmt->fetch()){
		if (($result->Shop != '' && $result->Shop != 'N/A') && $result->JobTitle != 'Shop Mgr'){
			$result->offline = 'YES';
			// find Shop Mgr
			$stmt = $db->prepare('SELECT * FROM tblempall WHERE Shop = :Shop AND JobTitle= :JobTitle');
			$stmt->execute(array('Shop' => $result->Shop, 'JobTitle' => 'Shop Mgr' ));
			if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
				$result->shopMEmpNum = $mgr->EmpNum;
				$result->shopMFname = $mgr->Fname;
				$result->shopMSname = $mgr->Sname;
				$result->shopMEaddress = $mgr->Eaddress;
			}
		}
		if ($result->AppEmpNum == ''){
			// Get fullname and email address
			// Trading region = Trading Area Manager
			if (strpos(strtoupper($result->Team),strtoupper('Trading Region')) !== false){
				// find Area Mgr
				$stmt = $db->prepare('SELECT * FROM tblempall WHERE RetailArea = :RetailArea AND JobTitle= :JobTitle');
				$stmt->execute(array('RetailArea' => $result->RetailArea, 'JobTitle' => 'Area Mgr' ));
				if ($mgr = $stmt->fetch(PDO::FETCH_OBJ)){
					$result->AppEmpNum = $mgr->EmpNum;
					$result->AppFname = $mgr->Fname;
					$result->AppSname = $mgr->Sname;
					$result->AppEaddress = $mgr->Eaddress;
				}
			} else {
				// volunteer fundraising = senior Manager
				if (strpos(strtoupper($result->Team),strtoupper('Volunteer Fundraising')) == True){
				} else {
					//everyone else department head
				}
			}
		}
		$_SESSION['nominee'] = $result;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalNominations($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatorEmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalNewNominations($empnum){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblnominations WHERE NominatedEmpNum = :EmpNum AND littleExtra='Yes' AND AprStatus=1 AND AwardClaimed = 'No'");
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalPendingNominations($empnum){
	global $db;
	$count =0;
	
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE ApproverEmpNum = :EmpNum AND AprStatus=0');

	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		$count += $stmt->rowCount();
	}

	$stmt = $db->prepare('SELECT * FROM tblnominations_team WHERE ApproverEmpNum = :EmpNum AND AprStatus=0');
	
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		$count += $stmt->rowCount();
	}
	
	return $count;
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalApprovedNominations($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatorEmpNum = :EmpNum AND AprStatus=1');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getEmployeFnameAndSname () {
	global $db;
	$sql = 'SELECT e.Fname AS name,
				e.Sname AS sname,
				n.id AS id
			FROM 
				tblnominations AS n
			INNER JOIN
				tblempall AS e
			ON n.NominatedEmpNum = e.EmpNum
			WHERE n.awardType=1 AND n.AprStatus=1 ORDER BY n.AprDate DESC LIMIT 20';
	$stmt = $db->prepare( $sql );
	$stmt->execute();
	$arr = array();
	while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
		$arr[] = $result;
	}
	if(count($arr) == 0){
		return 0;
	}
	return $arr;
}
////////////////////////////////////////////////////////////////////////////////////
function fixMenuSpace($i){
	switch ($i) {
		case 1:
			return '<div class="tableReportsHead tableColumn-6 noRightBorder"></div>';
		case 2:
			return '<div class="tableReportsHead tableColumn-4 noRightBorder"></div>';
		case 3:
			return '<div class="tableReportsHead tableColumn-2 noRightBorder"></div>';
	}
}
////////////////////////////////////////////////////////////////////////////////////
////////////    TEAM FUNCTIONS    ////////////////////////////////////////////////////
function getmyTeams($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblteams WHERE EmpNum = :EmpNum ');
	$stmt->execute(array('EmpNum' => $empnum));
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function getmyTeamName($id){
	if (is_numeric($id)) {
		global $db;
		$stmt = $db->prepare('SELECT myTeamName FROM tblteams WHERE id = :id ');
		$stmt->execute(array('id' => $id));
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		return $result->myTeamName;
	} else {
		if($id == 'myteam'){
			return 'My Team';
		} else {
			return $id ;
		}
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getAllTeamsMembers($teamID) {
	global $db;
	if($teamID != 'myteam'){
		$stmt = $db->prepare("SELECT * FROM tblteamusers tu INNER JOIN tblempall e ON tu.EmpNum=e.EmpNum WHERE tu.teamID = :teamID");
		$stmt->execute(array('teamID' => $teamID));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	} else {
		$stmt = $db->prepare("SELECT * FROM tblempall WHERE Team = :Team");
		$stmt->execute(array('Team' => $_SESSION['user']->Team));
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function addTeamMember($empnum) {
	if(isset($_SESSION['TeamMembers'])){
	} else {
		$_SESSION['TeamMembers'] =  array();
	}
	$name = getName($empnum);
	if (in_array_r($empnum, $_SESSION['TeamMembers'])) {
	} else {
		$_SESSION['TeamMembers'][] = array('EmpNum' => $empnum, 'full_name' => $name);
	}
	return;
}
////////////////////////////////////////////////////////////////////////////////////
function getThisTeamMembers($teamID) {
	global $db;
	if($teamID == 'myteam'){
		$stmt = $db->prepare("SELECT EmpNum,Fname,Sname FROM tblempall WHERE Team = :Team");
		$stmt->execute(array('Team' => $_SESSION['user']->Team));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} else {
		if (is_numeric($teamID)) {
			$stmt = $db->prepare("SELECT * FROM tblteamusers tu INNER JOIN tblempall e ON tu.EmpNum=e.EmpNum WHERE tu.teamID = :teamID");
			$stmt->execute(array('teamID' => $teamID));
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$stmt = $db->prepare("SELECT EmpNum,Fname,Sname FROM tblempall WHERE Team = :Team");
			$stmt->execute(array('Team' => $teamID));
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
////////////////////////////////////////////////////////////////////////////////////
function removeTeamMember($empnum) {
     foreach($_SESSION['TeamMembers'] as $subKey => $subArray){
          if($subArray['EmpNum'] == $empnum){
               unset($_SESSION['TeamMembers'][$subKey]);
          }
     }
     return $_SESSION['TeamMembers'];
}
////////////////////////////////////////////////////////////////////////////////////
function shortenName($name){
	return (strlen($name) > 15) ? substr($name,0,10).'...' : $name;
}
////////////////////////////////////////////////////////////////////////////////////
function getTeamsApprover($EmpNum) {
	global $db;
	$stmt = $db->prepare("SELECT AppEmpNum, AppFname, AppSname, AppEaddress FROM tblempall WHERE EmpNum = :EmpNum");
	$stmt->execute(array('EmpNum' => $EmpNum));
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	return $result;
}
////////////////////////////////////////////////////////////////////////////////////
function cleanWorkAward($workAward){
	if( $workAward=='TeamEvent'){
		return 'Team event';
	} else {
		return '£20 Voucher per person';
	}
}
////////////////////////////////////////////////////////////////////////////////////
?>