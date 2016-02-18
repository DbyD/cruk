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
function getSqlDate($date){
	$date = new DateTime($date);
	return date_format($date, 'Y-m-d');
}

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
	$stmt = $db->prepare('SELECT COUNT(*) AS Cnt FROM tblworkawards');
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getWorkAwardsPerID($id){
	global $db;
	$stmt = $db->prepare('SELECT COUNT(*) AS Cnt FROM tblworknominations WHERE nominationID = :NID');
	$stmt->bindParam(':NID', $id);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function createNominationExport($post){
	global $db;
	$CSVMaster = "<table>";
	$CSVLine = "";
	
	$sql = "SELECT * 
 			FROM tblnominations 
 			WHERE NomDate >= :NomDateF 
 			AND NomDate <= :NomDateT"; 
 	$stmt = $db->prepare($sql);
 	$NewFromDate = getSqlDate($post["FromDate"]) . ' 00:00:00';
 	$NewEndDate = getSqlDate($post["ToDate"]) . ' 00:00:00';
 	$stmt->bindParam(':NomDateF',$NewFromDate, PDO::PARAM_STR);
 	$stmt->bindParam(':NomDateT',$NewEndDate, PDO::PARAM_STR);
	$stmt->execute();
	
	$CSVLine .= "<tr><td>Nominee ID</td><td>Nominee</td><td>Team</td><td>Function</td><td>Department</td><td>Grade</td><td>Nominator ID</td><td>Nominator</td><td>Nominator Department</td><td>Nominator Grade</td><td>
			     Volunteer Name</td><td>Nomination Date</td><td>Core Belief</td><td>Nominated For</td><td>Nomination Reason</td><td>Personal Message</td><td>Line Manager</td><td>Site Name</td><td>
			     Approved</td><td>Approved Date</td><td>Approver</td><td>Decline Reason</td><td>Little Extra Removed</td><td>Status</td><td>Total Value</td></tr>";
	$CSVMaster .= $CSVLine;
	$CSVLine = "";
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "<tr>";
		$dbline = $row;
		$Nominee = getUser($dbline["NominatedEmpNum"]);
		$Nominator = getUser($dbline["NominatorEmpNum"]);
		$EmpAwards = getAvailable($dbline["NominatedEmpNum"]);
		$ApproverDet = getUser($dbline["ApproverEmpNum"]);
		
		// We check each field and then add it to the CSV
		if($post["NomineeID"] == "yes"){$CSVLine .= "<td>" . $dbline["NominatedEmpNum"] . "</td>";}
		if($post["Nominee"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Fname) . " " . Trim($Nominee->Sname) . "</td>";}
		if($post["Team"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Team) . "</td>";}
		if($post["Function"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->JobTitle) . "</td>";}
		if($post["Department"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Department) . "</td>";}
		if($post["NomGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Grade) . "</td>";}
		
		if($post["NominatorID"] == "yes"){$CSVLine .= "<td>" . $dbline["NominatorEmpNum"] . "</td>";}
		if($post["Nominator"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Fname) . " " . Trim($Nominator->Sname) . "</td>";}
		if($post["NominatorDept"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Department) . "</td>";}
		if($post["NominatorGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominator->Grade) . "</td>";}
		
		if($post["VolName"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["Volunteer"]) . "</td>";}
		
		if($post["NomDate"] == "yes"){$CSVLine .= "<td>" . $dbline["NomDate"] . ",";}
		if($post["CoreBelief"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["BeliefID"]) . "</td>";}
		if($post["NomFor"] == "yes"){
			$CSVLine .= "<td>" . Trim($dbline["amount"]) . "</td>";
		}
		if($post["NomReason"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["Reason"]) . "</td>";}
		if($post["PMessage"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["personalMessage"]) . "</td>";}
		
		if($post["LineManager"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->LMFname) . " " . Trim($Nominee->LMSname) . "</td>";}
		if($post["SiteName"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->LocationName) . "</td>";}
		
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
		if($post["Approver"] == "yes"){$CSVLine .= "<td>" . Trim($ApproverDet->Fname) . " " . Trim($ApproverDet->Sname) . "</td>";}
		if($post["Decreason"] == "yes"){$CSVLine .= "<td>" . Trim($dbline["dReason"]) . "</td>";}
		if($post["LittleExtra"] == "yes"){
			// Get the amount of extras
			// Check the work nominations table
			$WA = getWorkAwardsCnt();
			$WAAlloc = getWorkAwardsPerID($dbline["ID"]);
			if(intval($WA->Cnt) == intval($WAAlloc->Cnt)){
				$CSVLine .= "<td>No</td>";
			} else {
				$CSVLine .= "<td>Yes</td>";
			}
		}
		// Rules Here
		if($post["Status"] == "yes"){
			if($dbline["AwardClaimed"] == "Yes"){
				$CSVLine .= "<td>Cliamed</td>";
			} else {
				$CSVLine .= "<td>Not Cliamed</td>";
			}
		}
		if($post["TotalVal"] == "yes"){$CSVLine .= "<td>" . $EmpAwards . "</td>";}
		
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

function createRedemptionExport($post){
	global $db;
	$CSVMaster = "<table>";
	
	$sql = "SELECT *
 			FROM tblbasket b, tblbasketorders bo
 			WHERE bo.date >= :OrdDateF
 			AND bo.date <= :OrdDateT 
			AND b.orderID IS NOT NULL 
			AND b.orderID = bo.id";
	$stmt = $db->prepare($sql);
	$NewFromDate = getSqlDate($post["FromDate"]) . ' 00:00:00';
	$NewEndDate = getSqlDate($post["ToDate"]) . ' 00:00:00';
	$stmt->bindParam(':OrdDateF',$NewFromDate, PDO::PARAM_STR);
	$stmt->bindParam(':OrdDateT',$NewEndDate, PDO::PARAM_STR);
	$stmt->execute();
	
	
	$CSVLine .= "<tr><td>Nominee ID</td><td>Nominee</td><td>Department</td><td>Grade</td><td>Redeem Date</td><td>Transaction Code</td><td>Product Category</td><td>Product</td><td>Amount Spent</td><td>Current Balance</td></tr>";
	$CSVMaster .= $CSVLine;
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "<tr>";
		$dbline = $row;
		$Nominee = getUser($dbline["EmpNum"]);
		$EmpAwards = getAvailable($dbline["EmpNum"]);
		$ProdData = getProductByID($dbline["prID"]);
		$CCTrans = getCCTransaction($dbline["orderID"]);
		
		// We check each field and then add it to the CSV
		if($post["NomineeID"] == "yes"){$CSVLine .= "<td>" . $dbline["EmpNum"] . "</td>";}
		if($post["Nominee"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Fname) . " " . Trim($Nominee->Sname) . "</td>";}
		if($post["Department"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Department) . "</td>";}
		if($post["NomGrade"] == "yes"){$CSVLine .= "<td>" . Trim($Nominee->Grade) . "</td>";}
		if($post["RedeemDate"] == "yes"){$CSVLine .= "<td>" . $dbline["date"] . "</td>";}

		if($post["TransCode"] == "yes"){$CSVLine .= "<td>" . "</td>";}
		if($post["ProdCat"] == "yes"){$CSVLine .= "<td>" . Trim($ProdDat["ProdCode"]) . "</td>";}
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
?>