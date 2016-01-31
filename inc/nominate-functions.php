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
	$stmt = $db->prepare("SELECT * FROM tblnominations WHERE NominatedEmpNum = :EmpNum AND AprStatus=1 AND AwardClaimed = 'No'");
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
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE ApproverEmpNum = :EmpNum AND AprStatus=0');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
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
?>