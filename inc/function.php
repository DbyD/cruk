<?php
////////////////////////////////////////////////////////////////////////////////////
// send email
function sendEmail($email){
	global $strFrom;
	
	$message = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<style type=text/css>
					body,div {background:#eaedf2;margin:0px;padding:0px}
					.emailText {font-size:9pt;font-family:Arial;line-height:12pt;color:#2e008b;background:#fff;width:560px;min-height:360px;padding:20px;text-align:left}
					img{display:block}
				</style></head><body><div align="center"><div class="emailText">';
				
	$message .= $email->Content;
	$message .= "</div></div></body></html>";
	
	if (mail($email->emailTo, $email->subject, $message, $strFrom)){
		$reply = "success";
	} else {
		$reply = "fail";
	}
	return $reply;
}
////////////////////////////////////////////////////////////////////////////////////
// to be used if session declared before class
function fixObject (&$object){
	if (!is_object ($object) && gettype ($object) == 'object')
		return ($object = unserialize (serialize ($object)));
	return $object;
}
////////////////////////////////////////////////////////////////////////////////////
function createNominee($empnum){
	global $result, $db;
	$result = array();
	$stmt = $db->prepare('SELECT * FROM tblempall WHERE EmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	if ($result = $stmt->fetch()){
		if ($result->AppEmpNum == ''){
			// Get fullname and email address
			// Trading region = Trading Area Manager
			if (strpos(strtoupper($result->Team),strtoupper('Trading Region')) == True){
				$result->AppEmpNum == "";
				$result->AppFname == "";
				$result->AppSname == "";
				$result->AppEaddress == "";
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
function sendEcardEmail($ecard){
	global $strFrom;
	$subject = "Our Heroes E-Card";
	$message = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<style type=text/css>
					body,div {background:#eaedf2;margin:0px;padding:0px}
					.emailText {font-size:9pt;font-family:Arial;line-height:12pt;color:#2e008b;background:#fff;width:560px;min-height:360px;padding:20px;text-align:left}
					img{display:block}
				</style></head><body><div align="center"><div class="emailText">';
				
	$message .= $ecard->personalMessage;
	$message .= "</div></div></body></html>";
	if (mail($emailTo, $subject, $message, $strFrom)){
		$reply = "ecard sent";
	} else {
		$reply = "fail";
	}
	return $reply;
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
function getTotalAwards($empnum){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE NominatedEmpNum = :EmpNum AND AprStatus=1');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch()){
		return $stmt->rowCount();
	} else{
		return 0;
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getTotalNominationsList($empnum){
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
function getName($empnum){
	global $db;
	$stmt = $db->prepare('SELECT Fname, Sname FROM tblempall WHERE EmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch(PDO::FETCH_OBJ)){
		return $result->Fname." ".$result->Sname;
	} else{
		return "N/A";
	}
}
////////////////////////////////////////////////////////////////////////////////////
function getConvertedDate($date){
	$date = new DateTime($date);
	return date_format($date, 'd F Y');
}
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>