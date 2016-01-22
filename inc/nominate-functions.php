<?php
////////////////////////////////////////////////////////////////////////////////////
function createNominee($empnum){
	global $result, $db;
	$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	if ($result = $stmt->fetch()){
		if ($result->Shop != '' && $result->JobTitle != 'Shop Mgr'){
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
function getTotalPendingNominations($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatorEmpNum = :EmpNum AND AprStatus=0');
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
?>