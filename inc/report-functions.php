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
	$CSVMaster = "";
	$CSVLine = "";
	$CSVMaster .= $CSVLine;
	
	$sql = "SELECT * 
 			FROM tblnominations 
 			WHERE NomDate >= :NomDateF 
 			AND NomDate <= :NomDateT"; 
 	$stmt = $db->prepare($sql);
 	$NewFromDate = getConvertedDate($post["FromDate"]) . ' 00:00:00';
 	$NewEndDate = getConvertedDate($post["ToDate"]) . ' 00:00:00';
 	$stmt->bindParam(':NomDateF',$NewFromDate, PDO::PARAM_STR);
 	$stmt->bindParam(':NomDateT',$NewEndDate, PDO::PARAM_STR);
	$stmt->execute();
	
	$CSVLine .= "Nominee ID,Nominee,Team,Function,Department,Grade,Nominator ID,Nominator,Nominator Department,Nominator Grade,
			     Volunteer Name,Nomination Date,Core Belief,Nominated For,Nomination Reason,Personal Message,Line Manager,Site Name,
			     Approved,Approved Date,Approver,Decline Reason,Little Extra Removed,Status,Total Value\n";
	$CSVMaster .= $CSVLine;
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "";
		$dbline = $row;
		$Nominee = getUser($dbline["NominatedEmpNum"]);
		$Nominator = getUser($dbline["NominatorEmpNum"]);
		$EmpAwards = getAvailable($dbline["NominatedEmpNum"]);
		$ApproverDet = getUser($dbline["ApproverEmpNum"]);
		
		// We check each field and then add it to the CSV
		if($post["NomineeID"] == "yes"){$CSVLine .= $dbline["NominatedEmpNum"] . ",";}
		if($post["Nominee"] == "yes"){$CSVLine .= Trim($Nominee->Fname) . " " . Trim($Nominee->Sname) . ",";}
		if($post["Team"] == "yes"){$CSVLine .= Trim($Nominee->Team) . ",";}
		if($post["Function"] == "yes"){$CSVLine .= Trim($Nominee->JobTitle) . ",";}
		if($post["Department"] == "yes"){$CSVLine .= Trim($Nominee->Department) . ",";}
		if($post["NomGrade"] == "yes"){$CSVLine .= Trim($Nominee->Grade) . ",";}
		
		if($post["NominatorID"] == "yes"){$CSVLine .= $dbline["NominatorEmpNum"] . ",";}
		if($post["Nominator"] == "yes"){$CSVLine .= Trim($Nominator->Fname) . " " . Trim($Nominator->Sname) . ",";}
		if($post["NominatorDept"] == "yes"){$CSVLine .= Trim($Nominator->Department) . ",";}
		if($post["NominatorGrade"] == "yes"){$CSVLine .= Trim($Nominator->Grade) . ",";}
		
		if($post["VolName"] == "yes"){$CSVLine .= Trim($dbline["Volunteer"]) . ",";}
		
		if($post["NomDate"] == "yes"){$CSVLine .= $dbline["NomDate"] . ",";}
		if($post["CoreBelief"] == "yes"){$CSVLine .= Trim($dbline["BeliefID"]) . ",";}
		if($post["NomFor"] == "yes"){
			$CSVLine .= Trim($dbline["amount"]) . ",";
		}
		if($post["NomReason"] == "yes"){$CSVLine .= Trim($dbline["Reason"]) . ",";}
		if($post["PMessage"] == "yes"){$CSVLine .= Trim($dbline["personalMessage"]) . ",";}
		
		if($post["LineManager"] == "yes"){$CSVLine .= Trim($Nominee->LMFname) . " " . Trim($Nominee->LMSname) . ",";}
		if($post["SiteName"] == "yes"){$CSVLine .= Trim($Nominee->LocationName) . ",";}
		
		//Rules Here
		if($post["Approved"] == "yes"){
			if(intval($dbline["AprStatus"]) == 0){
				$CSVLine .= "Pending,";
			} else if(intval($dbline["AprStatus"]) == 1){
				$CSVLine .= "Approved,";
			} else {
				$CSVLine .= "Declined,";
			}
		}
		if($post["ApprovedDate"] == "yes"){$CSVLine .= Trim($dbline["AprDate"]) . ",";}
		if($post["Approver"] == "yes"){$CSVLine .= Trim($ApproverDet->Fname) . " " . Trim($ApproverDet->Sname) . ",";}
		if($post["Decreason"] == "yes"){$CSVLine .= Trim($dbline["dReason"]) . ",";}
		if($post["LittleExtra"] == "yes"){
			// Get the amount of extras
			// Check the work nominations table
			$WA = getWorkAwardsCnt();
			$WAAlloc = getWorkAwardsPerID($dbline["ID"]);
			if(intval($WA->Cnt) == intval($WAAlloc->Cnt)){
				$CSVLine .= "No,";
			} else {
				$CSVLine .= "Yes,";
			}
		}
		// Rules Here
		if($post["Status"] == "yes"){
			if($dbline["AwardClaimed"] == "Yes"){
				$CSVLine .= "Cliamed,";
			} else {
				$CSVLine .= "Not Cliamed,";
			}
		}
		if($post["TotalVal"] == "yes"){$CSVLine .= $EmpAwards . ",";}
		
		$CSVLine .= "\n";
		$CSVMaster .= $CSVLine;
		
	}
	$CSVMaster .= $CSVLine;
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
	$CSVMaster = "";
	$CSVLine = "";
	$CSVMaster .= $CSVLine;
	
	$sql = "SELECT *
 			FROM tblbasket b, tblbasketorders bo
 			WHERE bo.date >= :OrdDateF
 			AND bo.date <= :OrdDateT 
			AND b.orderID IS NOT NULL 
			AND b.orderID = bo.id";
	$stmt = $db->prepare($sql);
	$NewFromDate = getConvertedDate($post["FromDate"]) . ' 00:00:00';
	$NewEndDate = getConvertedDate($post["ToDate"]) . ' 00:00:00';
	$stmt->bindParam(':OrdDateF',$NewFromDate, PDO::PARAM_STR);
	$stmt->bindParam(':OrdDateT',$NewEndDate, PDO::PARAM_STR);
	$stmt->execute();
	
	
	$CSVLine .= "Nominee ID,Nominee,Department,Grade,Redeem Date,Transaction Code,Product Category,Product,Amount Spent,Current Balance\n";
	$CSVMaster .= $CSVLine;
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$CSVLine = "";
		$dbline = $row;
		$Nominee = getUser($dbline["EmpNum"]);
		$EmpAwards = getAvailable($dbline["EmpNum"]);
		$ProdData = getProductByID($dbline["prID"]);
		$CCTrans = getCCTransaction($dbline["orderID"]);
		
		// We check each field and then add it to the CSV
		if($post["NomineeID"] == "yes"){$CSVLine .= $dbline["EmpNum"] . ",";}
		if($post["Nominee"] == "yes"){$CSVLine .= Trim($Nominee->Fname) . " " . Trim($Nominee->Sname) . ",";}
		if($post["Department"] == "yes"){$CSVLine .= Trim($Nominee->Department) . ",";}
		if($post["NomGrade"] == "yes"){$CSVLine .= Trim($Nominee->Grade) . ",";}
		if($post["RedeemDate"] == "yes"){$CSVLine .= $dbline["date"] . ",";}

		if($post["TransCode"] == "yes"){$CSVLine .= ",";}
		if($post["ProdCat"] == "yes"){$CSVLine .= Trim($ProdDat["ProdCode"]) . ",";}
		if($post["Product"] == "yes"){$CSVLine .= Trim($ProdData["aTitle"]) . ",";}
		if($post["AmountSpent"] == "yes"){$CSVLine .= Trim($dbline["totalPrice"]) . ",";}
		if($post["CurrentBalance"] == "yes"){$CSVLine .= $EmpAwards . ",";}
	
		$CSVLine .= "\n";
		$CSVMaster .= $CSVLine;
	
	}
	$CSVMaster .= $CSVLine;
	return $CSVMaster;
}
/* GLV 2016-02-11 END ************************************************************/
?>