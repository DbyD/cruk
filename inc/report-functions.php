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
function getTotalLikes(){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblmessage');
	$stmt->execute();
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////
function getSQLDate($date){
	$date = new DateTime($date);
	return date_format($date, 'Y-m-d');
}
////////////////////////////////////////////////////////////////////////////////////

/* GLV 2016-02-11 ****************************************************************/

function getAllAwards($empnum){
	global $db;
	$stmt = $db->prepare("SELECT COUNT(*) FROM tblnominations WHERE NominatedEmpNum = :EmpNum");
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetchColumn()){
		return $result;
	} else{
		return 0;
	}
}

function getWorkAwardsCnt(){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblworkawards');
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getWorkAwardsPerID($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblworknominations WHERE nominationID = :NID');
	$stmt->bindParam(':NID', $id);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getExportSQL($params){
	// We need to alter the SQL Statement to cater for some fairly difficult rules
	// Rule 1: If Team has Trading Region 1,2,3,4 then take the Retail Area value and filter by that
	// Rule 2: If Section is Volunteer Fundraising then take the Team and get everybody that matches the team
	// Rule 3: If not in Rule 1 and 2 then get Get Section. If Section Blank then get Department
	// Rule 4: If manager level 1,2,3 then get Section. If Section blank pull department. If manager Greater than 4 then get department and then carry on.
	// Rule 5: If Super User then pull everything
	
	// OK So we do this.
	// Base SQL
	// Filter SQL
	// Date SQL
	
	// Base SQL
	$baseSQL = "SELECT * FROM tblnominations";
	
	// Test and APPLY Rules
	$LoggedIn = getUser($params["EmpNum"]);
	$UserTeam = $LoggedIn->Team;
	$UserRetailArea = $LoggedIn->RetailArea;
	$UserSection = $LoggedIn->Section;
	$UserDepartment = $LoggedIn->Department;
	$UserGrade = $LoggedIn->Grade;
	$UserIsSuper = $LoggedIn->SuperUser;
	//Rule 1
	if(strtoupper($UserIsSuper) == "Y"){
		$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp";
	} else if((strtoupper($UserTeam) == "TRADING REGION 1") || (strtoupper($UserTeam) == "TRADING REGION 2") ||
			(strtoupper($UserTeam) == "TRADING REGION 3") || (strtoupper($UserTeam) == "TRADING REGION 4")){
				$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE RetailArea = '" . $UserRetailArea . "'";
	} else if(strtoupper($UserSection) == "VOLUNTEER FUNDRAISING"){
		$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE Team = '" . $UserTeam . "'";
	} else if(Trim($UserSection) != ""){
		$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE Section = '" . $UserSection . "'";
	} else if(Trim($UserDepartment) != ""){
		$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE Department = '" . $UserDepartment . "'";
	} else if((strtoupper($UserGrade) == "MANAGER 1") || (strtoupper($UserGrade) == "MANAGER 2") ||
			  (strtoupper($UserGrade) == "MANAGER 3")){
		if(Trim($UserSection) != ""){
			$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE Section = '" . $UserSection . "'";
		} else {
			$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE Department = '" . $UserDepartment . "'";
		}
	} else {
		$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE Department = '" . $UserDepartment . "'";
	}
	
	if(Trim($params["FromDate"]) != ""){
		$NewFromDate = getSQLDate($params["FromDate"]) . ' 00:00:00';
		$dateSQL = "SELECT * FROM (" . $filterSQL . ") AS TDates WHERE NomDate >= '" . $NewFromDate . "' ";
		if(Trim($params["ToDate"]) != ""){
			$NewEndDate = getSQLDate($params["ToDate"]) . ' 23:59:59';
			$dateSQL . " AND NomDate <= '" . $NewEndDate . "' ";
		}
	} else {
		$dateSQL = "SELECT * FROM (" . $filterSQL . ") AS TDates WHERE awardType = 1";
	}
	return $dateSQL;
}

function getTeamExportSQL($params){
	// We need to alter the SQL Statement to cater for some fairly difficult rules
	// Rule 1: If Team has Trading Region 1,2,3,4 then take the Retail Area value and filter by that
	// Rule 2: If Section is Volunteer Fundraising then take the Team and get everybody that matches the team
	// Rule 3: If not in Rule 1 and 2 then get Get Section. If Section Blank then get Department
	// Rule 4: If manager level 1,2,3 then get Section. If Section blank pull department. If manager Greater than 4 then get department and then carry on.
	// Rule 5: If Super User then pull everything

	// OK So we do this.
	// Base SQL
	// Filter SQL
	// Date SQL

	// Base SQL
	$baseSQL = "SELECT * FROM tblnominations_team";

	// Test and APPLY Rules
	$LoggedIn = getUser($params["EmpNum"]);
	$UserTeam = $LoggedIn->Team;
	$UserIsSuper = $LoggedIn->SuperUser;
	//Rule 1
	//if(strtoupper($UserIsSuper) == "Y"){
		$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp";
	//} else {
	//	$filterSQL = "SELECT * FROM (" . $baseSQL . ") AS Temp WHERE Team = '" . $UserTeam . "'";
	//}

	if(Trim($params["FromDate"]) != ""){
		$NewFromDate = getSQLDate($params["FromDate"]) . ' 00:00:00';
		$dateSQL = "SELECT * FROM (" . $filterSQL . ") AS TDates WHERE NomDate >= '" . $NewFromDate . "' ";
		if(Trim($params["ToDate"]) != ""){
			$NewEndDate = getSQLDate($params["ToDate"]) . ' 23:59:59';
			$dateSQL . " AND NomDate <= '" . $NewEndDate . "' ";
		}
	} else {
		$dateSQL = "SELECT * FROM (" . $filterSQL . ") AS TDates WHERE awardType = 2";
	}
	return $dateSQL;
}

function getRedeemDates($params, $prefix){
	$dateSQL = "";
	if(Trim($params["FromDate"]) != ""){
		$NewFromDate = getSQLDate($params["FromDate"]) . ' 00:00:00';
		$dateSQL .= " AND " . $prefix . "date >= '" . $NewFromDate . "' ";
		if(Trim($params["ToDate"]) != ""){
			$NewEndDate = getSQLDate($params["ToDate"]) . ' 23:59:59';
			$dateSQL .= " AND " . $prefix . "date <= '" . $NewEndDate . "' ";
		}
	}
	return $dateSQL;
}

function getDepartmentSQL($EmpNum){
	$LoggedIn = getUser($EmpNum);
	$UserDepartment = $LoggedIn->Department;
	if((strtoupper($UserGrade) == "MANAGER 1") || (strtoupper($UserGrade) == "MANAGER 2") ||
	   (strtoupper($UserGrade) == "MANAGER 3")){
		if(Trim($UserSection) != ""){
			$filterSQL = "Section = '" . $UserSection . "'";
		} else {
			$filterSQL = "Department = '" . $UserDepartment . "'";
		}
	} else {
		$filterSQL = "Department = '" . $UserDepartment . "'";
	}
	return $filterSQL;
}

function getRedeemSQL($EmpNum){
	$LoggedIn = getUser($EmpNum);
	$UserDepartment = $LoggedIn->Department;
	$UserIsSuper = $LoggedIn->SuperUser;
	if($UserIsSuper == "Y"){
		$filterSQL = "";
	} else if((strtoupper($UserGrade) == "MANAGER 1") || (strtoupper($UserGrade) == "MANAGER 2") ||
			(strtoupper($UserGrade) == "MANAGER 3")){
				if(Trim($UserSection) != ""){
					$filterSQL = " AND a.Section = '" . $UserSection . "'";
				} else {
					$filterSQL = " AND a.Department = '" . $UserDepartment . "'";
				}
	} else {
		$filterSQL = " AND a.Department = '" . $UserDepartment . "'";
	}
	return $filterSQL;
}

function createNominationExport($post){
	global $db;
	
	setMyCookie($post, 'crukNom');
	
	$CSVMaster = "<table>";
	$CSVLine = "";
	$SQL = getExportSQL($post);
//	$CSVLine .=$SQL;
	$stmt = $db->prepare($SQL);
	$stmt->execute();
	
	
	
	$CSVLine .= "<tr>";
	$CSVLine .= "<td>Nomination ID</td>";
	if($post["NomineeID"] == "yes"){$CSVLine .= "<td>Nominee ID</td>";}
	if($post["Nominee"] == "yes"){$CSVLine .= "<td>Nominee</td>";}
	if($post["Team"] == "yes"){$CSVLine .= "<td>Nominee Team</td>";}
	if($post["Function"] == "yes"){$CSVLine .= "<td>Nominee Function</td>";}
	if($post["Department"] == "yes"){$CSVLine .= "<td>Nominee Department</td>";}
	if($post["NomGrade"] == "yes"){$CSVLine .= "<td>Nominee Grade</td>";}
	if($post["LineManager"] == "yes"){$CSVLine .= "<td>Line Manager</td>";}
	if($post["StoreManager"] == "yes"){$CSVLine .= "<td>Store Manager</td>";}
	if($post["LocationName"] == "yes"){$CSVLine .= "<td>Site Name</td>";}
	if($post["NominatorID"] == "yes"){$CSVLine .= "<td>Nominator ID</td>";}
	if($post["Nominator"] == "yes"){$CSVLine .= "<td>Nominator</td>";}
	if($post["NominatorDept"] == "yes"){$CSVLine .= "<td>Nominator Department</td>";}
	if($post["NominatorGrade"] == "yes"){$CSVLine .= "<td>Nominator Grade</td>";}
	if($post["VolName"] == "yes"){$CSVLine .= "<td>Volunteer Name</td>";}
	if($post["NomDate"] == "yes"){$CSVLine .= "<td>Nomination Date</td>";}
	if($post["CoreBelief"] == "yes"){$CSVLine .= "<td>Core Belief</td>";}
	if($post["NomReason"] == "yes"){$CSVLine .= "<td>Nomination Reason</td>";}
	if($post["PMessage"] == "yes"){$CSVLine .= "<td>Personal Message</td>";}
	if($post["Approver"] == "yes"){$CSVLine .= "<td>Approver</td>";}
	if($post["Approved"] == "yes"){$CSVLine .= "<td>Approved</td>";}
	if($post["ApprovedDate"] == "yes"){$CSVLine .= "<td>Approved Date</td>";}
	if($post["Decreason"] == "yes"){$CSVLine .= "<td>Decline Reason</td>";}
	if($post["Amount"] == "yes"){$CSVLine .= "<td>Amount</td>";}
	if($post["LittleExtra"] == "yes"){$CSVLine .= "<td>Little Extra Removed</td>";}
	if($post["Status"] == "yes"){$CSVLine .= "<td>Status</td>";}
	if($post["TotalVal"] == "yes"){$CSVLine .= "<td>Total Value</td>";}
	$CSVLine .= "</tr>";
	$CSVMaster .= $CSVLine;
	$CSVLine = "";
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "<tr>";
		$dbline = $row;
		$Nominee = getUser($dbline["NominatedEmpNum"]);
		$Nominator = getUser($dbline["NominatorEmpNum"]);
		$EmpAwards = getAvailable($dbline["NominatedEmpNum"]);
		$ApproverDet = getUser($dbline["ApproverEmpNum"]);
		
		$CSVLine .= "<td>" . $dbline["ID"] . "</td>";
		
		// We check each field and then add it to the CSV
		if($post["NomineeID"] == "yes"){$CSVLine .= "<td>" . $dbline["NominatedEmpNum"] . "</td>";}
		if($post["Nominee"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Fname) . " " . Trim($Nominee->Sname) . "</td>";}
		if($post["Team"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Team) . "</td>";}
		if($post["Function"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->JobTitle) . "</td>";}
		if($post["Department"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Department) . "</td>";}
		if($post["NomGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Grade) . "</td>";}
		if($post["LineManager"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->LMFname) . " " . Trim($Nominee->LMSname) . "</td>";}
		
		// need to get store manager
		$stmt2 = $db->prepare('SELECT * FROM tblempall WHERE Shop = :Shop AND JobTitle= :JobTitle');
		$stmt2->execute(array('Shop' => $Nominee->RetailArea, 'JobTitle' => 'Shop Mgr' ));
		if ($mgr = $stmt2->fetch(PDO::FETCH_OBJ)){
			$shopmgr = $mgr->Fname.' '.$mgr->Sname;
		} else {
			$shopmgr = '';
		}
		if($post["StoreManager"] == "yes"){$CSVLine .= "<td>" . Trim($shopmgr) . "</td>";}
		
		if($post["LocationName"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->LocationName) . "</td>";}
		
		if($post["NominatorID"] == "yes"){$CSVLine .= "<td>" . $dbline["NominatorEmpNum"] . "</td>";}
		if($post["Nominator"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Fname) . " " . Trim($Nominator->Sname) . "</td>";}
		if($post["NominatorDept"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Department) . "</td>";}
		if($post["NominatorGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Grade) . "</td>";}
		
		if($post["VolName"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["Volunteer"]) . "</td>";}
		
		if($post["NomDate"] == "yes"){$CSVLine .= "<td>" . $dbline["NomDate"] . "</td>";}
		if($post["CoreBelief"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["BeliefID"]) . "</td>";}
		if($post["NomReason"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["Reason"]) . "</td>";}
		if($post["PMessage"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["personalMessage"]) . "</td>";}
		
		if(Trim($dbline["amount"])!=0){
			if($post["Approver"] == "yes"){$CSVLine .= "<td>" . Trim($ApproverDet->Fname) . " " . Trim($ApproverDet->Sname) . "</td>";}
			//Rules Here
			if($post["Approved"] == "yes"){
				if(intval($dbline["AprStatus"]) == 0){
					$CSVLine .= "<td>Pending</td>";
				} else if(intval($dbline["AprStatus"]) == 1){
					$CSVLine .= "<td>Approved</td>";
				} else {
					$CSVLine .= "<td>Declined</td>";
				}
			}
			if($post["ApprovedDate"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["AprDate"]) . "</td>";}
			if($post["Decreason"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["dReason"]) . "</td>";}
			
			if($post["Amount"] == "yes"){
				$CSVLine .= "<td>" . Trim($dbline["amount"]) . "</td>";
			}
			if($post["LittleExtra"] == "yes"){
				// Get the amount of extras
				// Check the work nominations table
				$WA = getWorkAwardsCnt();
				$WAAlloc = getWorkAwardsPerID($dbline["ID"]);
				$removed = '';
				foreach($WAAlloc as $list){
					if (($key = array_search($list->workawardsID, $WA)) !== false) {
						unset($WA[$key]);
					}
				}
				foreach($WA as $list){
					$removed .= $list->type.' ,';
				}
				$CSVLine .= "<td>".$removed."</td>";
			}
			// Rules Here
			if($post["Status"] == "yes"){
				if($dbline["AwardClaimed"] == "Yes"){
					$CSVLine .= "<td>Cliamed</td>";
				} else {
					$CSVLine .= "<td>Not Cliamed</td>";
				}
			}
		} else {
			if($post["Approver"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["Approved"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["ApprovedDate"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["Decreason"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["Amount"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["LittleExtra"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["Status"] == "yes"){$CSVLine .= "<td></td>"; }
		}
		if($post["TotalVal"] == "yes"){$CSVLine .= "<td>" . $EmpAwards . "</td>";}
		
		$CSVLine .= "</tr>";
		$CSVMaster .= $CSVLine;
		
	}
	$CSVMaster .= $CSVLine . "</table>";
	return $CSVMaster;
}

function createTeamNominationExport($post){
	global $db;
	
	setMyCookie($post, 'crukTeamNom');
	
	$CSVMaster = "<table>";
	$CSVLine = "";
	$SQL = getTeamExportSQL($post);
	//	$CSVLine .=$SQL;
	$stmt = $db->prepare($SQL);
	$stmt->execute();
	
	
	
	$CSVLine .= "<tr>";
	$CSVLine .= "<td>Nomination ID</td>";
	if($post["Team"] == "yes"){$CSVLine .= "<td>Nominee Team</td>";}
	if($post["Nominees"] == "yes"){$CSVLine .= "<td>Nominees</td>";}
	if($post["NominatorID"] == "yes"){$CSVLine .= "<td>Nominator ID</td>";}
	if($post["Nominator"] == "yes"){$CSVLine .= "<td>Nominator</td>";}
	if($post["NominatorDept"] == "yes"){$CSVLine .= "<td>Nominator Department</td>";}
	if($post["NominatorGrade"] == "yes"){$CSVLine .= "<td>Nominator Grade</td>";}
	if($post["VolName"] == "yes"){$CSVLine .= "<td>Volunteer Name</td>";}
	if($post["NomDate"] == "yes"){$CSVLine .= "<td>Nomination Date</td>";}
	if($post["CoreBelief"] == "yes"){$CSVLine .= "<td>Core Belief</td>";}
	if($post["NomReason"] == "yes"){$CSVLine .= "<td>Nomination Reason</td>";}
	if($post["PMessage"] == "yes"){$CSVLine .= "<td>Personal Message</td>";}
	if($post["Approver"] == "yes"){$CSVLine .= "<td>Approver</td>";}
	if($post["Approved"] == "yes"){$CSVLine .= "<td>Approved</td>";}
	if($post["ApprovedDate"] == "yes"){$CSVLine .= "<td>Approved Date</td>";}
	if($post["Decreason"] == "yes"){$CSVLine .= "<td>Decline Reason</td>";}
	if($post["Amount"] == "yes"){$CSVLine .= "<td>Amount</td>";}
	$CSVLine .= "</tr>";
	$CSVMaster .= $CSVLine;
	$CSVLine = "";
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "<tr>";
		$dbline = $row;
		$Nominee = getUser($dbline["NominatedEmpNum"]);
		$Nominator = getUser($dbline["NominatorEmpNum"]);
		$EmpAwards = 0;
		$ApproverDet = getUser($dbline["ApproverEmpNum"]);
	
		$CSVLine .= "<td>" . $dbline["ID"] . "</td>";
	
		// We check each field and then add it to the CSV
		
		if($post["Team"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["Team"]) . "</td>";}
		if($post["Nominees"] == "yes"){
			$CSVLine .= "<td>";
			// The names of the nominees for the award
			$stmt2 = $db->prepare('SELECT * FROM tblnominations_teamusers WHERE nomination_teamID = :NomTID');
			$stmt2->execute(array('NomTID' => $dbline["ID"]));
			while ($teamusers = $stmt2->fetch(PDO::FETCH_ASSOC)) {
				$userdata = getUser($teamusers["EmpNum"]);
				$CSVLine .= $userdata->Fname . " " . $userdata->Sname . ", ";
				$EmpAwards = $EmpAwards + getAvailable($teamusers["EmpNum"]);
			}
			$CSVLine .= "</td>";
		}
		
		if($post["NominatorID"] == "yes"){$CSVLine .= "<td>" . $dbline["NominatorEmpNum"] . "</td>";}
		if($post["Nominator"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Fname) . " " . Trim($Nominator->Sname) . "</td>";}
		if($post["NominatorDept"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Department) . "</td>";}
		if($post["NominatorGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Grade) . "</td>";}
	
		if($post["VolName"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["Volunteer"]) . "</td>";}
	
		if($post["NomDate"] == "yes"){$CSVLine .= "<td>" . $dbline["NomDate"] . "</td>";}
		if($post["CoreBelief"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["BeliefID"]) . "</td>";}
		if($post["NomReason"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["Reason"]) . "</td>";}
		if($post["PMessage"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["personalMessage"]) . "</td>";}
	
		if( $dbline["amount"] == '0' ){
			if($post["Approver"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["Approved"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["ApprovedDate"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["Decreason"] == "yes"){$CSVLine .= "<td></td>"; }
			if($post["Amount"] == "yes"){$CSVLine .= "<td></td>"; }
		} else {
			if($post["Approver"] == "yes"){$CSVLine .= "<td>" . Trim($ApproverDet->Fname) . " " . Trim($ApproverDet->Sname) . "</td>";}
			//Rules Here
			if($post["Approved"] == "yes"){
				if(intval($dbline["AprStatus"]) == 0){
					$CSVLine .= "<td>Pending</td>";
				} else if(intval($dbline["AprStatus"]) == 1){
					$CSVLine .= "<td>Approved</td>";
				} else {
					$CSVLine .= "<td>Declined</td>";
				}
			}
			if($post["ApprovedDate"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["AprDate"]) . "</td>";}
			if($post["Decreason"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["dReason"]). "</td>";}
				
			if($post["Amount"] == "yes"){
				if($dbline["amount"] == 'TeamEvent'){
					$CSVLine .= "<td>Team Event</td>";
				} else {
					$CSVLine .= "<td>&pound;20</td>";
				}
			}
		}
	
		$CSVLine .= "</tr>";
		$CSVMaster .= $CSVLine;
	
	}
	$CSVMaster .= $CSVLine . "</table>";
	return $CSVMaster;
}

function getCCTransaction($OrderID){
	global $db;
	$stmt = $db->prepare('SELECT SUM(amount) AS Cnt FROM tblcreditcard WHERE orderID = :OID');
	$stmt->bindParam(':OID', $OrderID);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function setMyCookie($post, $type){
	setcookie("$type", "", time() - 3600);
	$cookie_items = $_COOKIE[$type];
	foreach($cookie_items as $index => $value){
		setcookie($type."[".$index."]", '');
	}
	setcookie("$post");
	foreach ($post as $key => $value){
		setcookie($type."[".$key."]", $value);
	}
}

function createRedemptionExport($post){
	global $db;
	
	setMyCookie($post, 'crukRed');
	
	$CSVMaster = "<table>";
	$sqlWhere = getRedeemSQL($post["EmpNum"]);
	$dateSQL = getRedeemDates($post,"bo."); 
	$sql = "SELECT *
 			FROM tblbasket b, tblbasketorders bo, tblempall a
 			WHERE b.orderID IS NOT NULL 
			AND b.orderID = bo.id 
			AND b.EmpNum = a.EmpNum 
			" . $sqlWhere . $dateSQL. " ORDER BY bo.id DESC";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	
	$CSVLine .= "<tr>";
	if($post["NomineeID"] == "yes"){$CSVLine .= "<td>Nominee ID</td>";}
	if($post["Nominee"] == "yes"){$CSVLine .= "<td>Nominee</td>";}
	if($post["Department"] == "yes"){$CSVLine .= "<td>Department</td>";}
	if($post["NomGrade"] == "yes"){$CSVLine .= "<td>Grade</td>";}
	if($post["RedeemDate"] == "yes"){$CSVLine .= "<td>Redeem Date</td>";}
	if($post["TransCode"] == "yes"){$CSVLine .= "<td>Order Ref</td>";}
	if($post["ProdCat"] == "yes"){$CSVLine .= "<td>Product Category</td>";}
	if($post["Product"] == "yes"){$CSVLine .= "<td>Product</td>";}
	if($post["AmountSpent"] == "yes"){$CSVLine .= "<td>Amount Spent</td>";}
	if($post["CurrentBalance"] == "yes"){$CSVLine .= "<td>Current Balance</td>";}
	$CSVLine .= "</tr>";
	$CSVMaster .= $CSVLine;
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "<tr>";
		$dbline = $row;
		$Nominee = getUser($dbline["EmpNum"]);
		$EmpAwards = getAvailable($dbline["EmpNum"]);
		$ProdData = getProductByID($dbline["prID"]);
		$CCTrans = getCCTransaction($dbline["orderID"]);
		$prodCat = getProductCategory($ProdData["subID"]);
		
		// We check each field and then add it to the CSV
		if($post["NomineeID"] == "yes"){$CSVLine .= "<td>" . $dbline["EmpNum"] . "</td>";}
		if($post["Nominee"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Fname) . " " . Trim($Nominee->Sname) . "</td>";}
		if($post["Department"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Department) . "</td>";}
		if($post["NomGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Grade) . "</td>";}
		if($post["RedeemDate"] == "yes"){$CSVLine .= "<td>" . $dbline["date"] . "</td>";}
		if($post["TransCode"] == "yes"){$CSVLine .= "<td>CR".$dbline["orderID"]. "</td>";}
		if($post["ProdCat"] == "yes"){$CSVLine .= "<td>" . Trim($prodCat["label"]) . "</td>";}
		if($post["Product"] == "yes"){$CSVLine .= "<td>" . Trim($ProdData["aTitle"]) . "</td>";}
		$totalprice = floatval($dbline["totalPrice"]) + floatval($CCTrans->Amount);
		if($post["AmountSpent"] == "yes"){$CSVLine .= "<td>" . Trim($totalprice) . "</td>";}
		if($post["CurrentBalance"] == "yes"){$CSVLine .= "<td>" . $EmpAwards . "</td>";}
	
		$CSVLine .= "</tr>";
		$CSVMaster .= $CSVLine;
	
	}
	$CSVMaster .= $CSVLine . "</table>";
	return $CSVMaster;
}
/* GLV 2016-02-11 END ************************************************************/
function createXexecRedemptionExport($post){
	global $db;
	
	setMyCookie($post, 'crukRed');
	
	$CSVMaster = "<table>";
	$sqlWhere = getRedeemSQL($post["EmpNum"]);
	$dateSQL = getRedeemDates($post,"bo."); 
	$sql = "SELECT *
 			FROM tblbasket b, tblbasketorders bo, tblempall a
 			WHERE b.orderID IS NOT NULL 
			AND b.orderID = bo.id 
			AND b.EmpNum = a.EmpNum 
			" . $sqlWhere . $dateSQL. " ORDER BY bo.id DESC";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	
	$CSVLine .= "<tr>";
	if($post["NomineeID"] == "yes"){$CSVLine .= "<td>Nominee ID</td>";}
	if($post["Nominee"] == "yes"){$CSVLine .= "<td>Nominee</td>";}
	if($post["Department"] == "yes"){$CSVLine .= "<td>Department</td>";}
	if($post["NomGrade"] == "yes"){$CSVLine .= "<td>Grade</td>";}
	if($post["RedeemDate"] == "yes"){$CSVLine .= "<td>Redeem Date</td>";}
	if($post["TransCode"] == "yes"){$CSVLine .= "<td>Order Ref</td>";}
	if($post["ProdCat"] == "yes"){$CSVLine .= "<td>Product Category</td>";}
	if($post["Product"] == "yes"){$CSVLine .= "<td>Product</td>";}
	if($post["AmountSpent"] == "yes"){$CSVLine .= "<td>Amount Spent</td>";}
	if($post["CurrentBalance"] == "yes"){$CSVLine .= "<td>Current Balance</td>";}
	
	$CSVLine .= "<td>Address 1</td>";
	$CSVLine .= "<td>Address 2</td>";
	$CSVLine .= "<td>Town</td>";
	$CSVLine .= "<td>Postcode</td>";
	
	$CSVLine .= "</tr>";
	$CSVMaster .= $CSVLine;
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "<tr>";
		$dbline = $row;
		$Nominee = getUser($dbline["EmpNum"]);
		$EmpAwards = getAvailable($dbline["EmpNum"]);
		$ProdData = getProductByID($dbline["prID"]);
		$CCTrans = getCCTransaction($dbline["orderID"]);
		$prodCat = getProductCategory($ProdData["subID"]);
		
		// We check each field and then add it to the CSV
		if($post["NomineeID"] == "yes"){$CSVLine .= "<td>" . $dbline["EmpNum"] . "</td>";}
		if($post["Nominee"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Fname) . " " . Trim($Nominee->Sname) . "</td>";}
		if($post["Department"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Department) . "</td>";}
		if($post["NomGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Grade) . "</td>";}
		if($post["RedeemDate"] == "yes"){$CSVLine .= "<td>" . $dbline["date"] . "</td>";}
		if($post["TransCode"] == "yes"){$CSVLine .= "<td>CR".$dbline["orderID"]. "</td>";}
		if($post["ProdCat"] == "yes"){$CSVLine .= "<td>" . Trim($prodCat["label"]) . "</td>";}
		if($post["Product"] == "yes"){$CSVLine .= "<td>" . Trim($ProdData["aTitle"]) . "</td>";}
		$totalprice = floatval($dbline["totalPrice"]) + floatval($CCTrans->Amount);
		if($post["AmountSpent"] == "yes"){$CSVLine .= "<td>" . Trim($totalprice) . "</td>";}
		if($post["CurrentBalance"] == "yes"){$CSVLine .= "<td>" . $EmpAwards . "</td>";}
		
		$CSVLine .= "<td>" . Trim($dbline["address1"]) . "</td>";
		$CSVLine .= "<td>" . Trim($dbline["address2"]) . "</td>";
		$CSVLine .= "<td>" . Trim($dbline["town"]) . "</td>";
		$CSVLine .= "<td>" . Trim($dbline["postcode"]) . "</td>";
		
		$CSVLine .= "</tr>";
		$CSVMaster .= $CSVLine;
	
	}
	$CSVMaster .= $CSVLine . "</table>";
	return $CSVMaster;
}
////////////////////////////////////////////////////////////////////////////////////
function getProductCategory( $id ){
	global $db;
	$sql = 'SELECT * FROM tblmenuleft WHERE id = :id';
	$stmt = $db->prepare( $sql );
	$stmt->execute( array('id' => $id) );
	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		return $result;
	}
}
////////////////////////////////////////////////////////////////////////////////////

?>
