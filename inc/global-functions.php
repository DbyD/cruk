<?php
////////////////////////////////////////////////////////////////////////////////////
// send email
function sendEmail($email){
	global $strFrom;
	
	$message = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<style type=text/css>
					body,div {margin:0px;padding:0px}
					.emailText {font-size:9pt;font-family:Arial;line-height:12pt;color:#2e008b;background:#fff;width:560px;min-height:360px;padding:20px;text-align:left}
					img{display:block}
				</style></head><body><div align="center"><div class="emailText">';
				
	$message .= $email->Content;
	$message .= '<p>Regards</p><p><b>Cancer Research</b>
				</div></div></body></html>';
	
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
function sendEcardEmail($ecard){
	// need to fix this so we can email anytime
	global $strFrom;
	$subject = "Our Heroes E-Card";
	if ($emailTo = $ecard->offline == 'YES'){
		$emailTo = $ecard->shopMEaddress;
	} else {
		if ($ecard->Eaddress) {
			$emailTo = $ecard->Eaddress;
		} else {
			$emailTo = $ecard->nominee()->Eaddress;
		}
	}
	// need to fully design e-card
	$message = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<style type=text/css>
					body,div {margin:0px;padding:0px}
					.emailText {font-size:9pt;font-family:Arial;line-height:12pt;color:#2e008b;background:#fff;width:560px;min-height:360px;padding:20px;text-align:left}
					img{display:block}
				</style></head><body><div align="center"><div class="emailText">';
	$message .= $ecard->content;
	$message .= '<p>Regards</p><p><b>Cancer Research</b>
				</div></div></body></html>';
	if (mail($emailTo, $subject, $message, $strFrom)){
		$reply = "ecard sent";
	} else {
		$reply = "fail";
	}
	return $reply;
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
function getEcard($id){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE ID = :ID');
	$stmt->execute(array('ID' => $id));
	if ($result = $stmt->fetch(PDO::FETCH_OBJ)){
		return $result;
	} else{
		return "N/A";
	}
}
////////////////////////////////////////////////////////////////////////////////////
function in_object($val, $obj){
	if($val == ""){
		trigger_error("in_object expects parameter 1 must not empty", E_USER_WARNING);
        return false;
    }
    if(!is_object($obj)){
        $obj = (object)$obj;
    }
    foreach($obj as $key => $value){
        if(!is_object($value) && !is_array($value)){
            if($value == $val){
                return true;
            }
        }else{
            return in_object($val, $value);
        }
    }
    return false;
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
function indEcardText($ecard){
	$ecardText = "<p>Hello ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." would like to thank you for the amazing work you have performed here at Cancer Research.</p>
				<p>".$ecard->personalMessage."</p>
				<p>The CRUK Belief most closely associated with your achievement is: ".$ecard->BeliefID.".</p>
				<p>Congratulations again and many thanks for your contribution to Cancer Research UK.</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function indEcardExtraText($ecard){
	$ecardText = "<p>Hello ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." would like to thank you for the amazing work you have performed here at Cancer Research.</p>
				<p>".$ecard->personalMessage."</p>
				<p>The CRUK Belief most closely associated with your achievement is: ".$ecard->BeliefID.".</p>
				<p>As part of your award, you've also been given a 'Little Extra'. Please log onto the <a href='http://http://cruk.xexec.dev/'>Our Heroes Portal</a> to view and claim your Little Extra something.</p>
				<p>Congratulations again and many thanks for your contribution to Cancer Research UK.</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>