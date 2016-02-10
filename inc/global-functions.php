<?php
////////////////////////////////////////////////////////////////////////////////////
function startEmail(){
	$startemail = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<style type=text/css>
					body,div {margin:0px;padding:0px}
					.emailText {font-size:9pt;font-family:Arial;line-height:12pt;color:#2e008b;background:#fff;width:600px;padding:0 20px;text-align:left}
					img{display:block}
					.emailOurheroes {text-align: left;}
					.emailCruklogo {float: right;}
					.small{font-size:8pt;}
				</style></head><body><div align="center"><div class="emailText">
				<div class="ourheroes"><img src="'.HTTP_PATH.'images/emails/our-heroes.png" alt="Cancer Research UK"></div>';
	return  $startemail;
}
////////////////////////////////////////////////////////////////////////////////////
function endEmail($noid){
	$endemail .= '<img class="emailCruklogo" src="'.HTTP_PATH.'images/emails/Cancer-Research-UK.png" alt="Cancer Research UK">';
	$endemail .= '<p>Regards</p><p><b>Cancer Research</b></p>';
	if($noid != ''){
			$endemail .= '<p class="small">For future reference, if you need to contact our recognition partner, Xexec, about this nomination, please quote nomination code '.$noid.'</p>';
	}
	$endemail .= '</div></div></body></html>';
	return $endemail;
}
////////////////////////////////////////////////////////////////////////////////////
// send email
function sendEmail($email,$noid){
	global $strFrom;
	$message = startEmail();
	$message .= $email->Content;
	$message .= endEmail($noid);
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
function array_to_object($array) {
    return is_array($array) ? (object) array_map(__FUNCTION__,$array) : $array;
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
	$message = startEmail();
	$message .= $ecard->content;
	$message .= endEmail();
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
function getFirstName($empnum){
	global $db;
	$stmt = $db->prepare('SELECT Fname FROM tblempall WHERE EmpNum = :EmpNum');
	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetch(PDO::FETCH_OBJ)){
		return $result->Fname;
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
	
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	
	$ecardText = '<img src="'.HTTP_PATH.'images/emails/'.$ecardImage.'.png" alt="'.$ecard->BeliefID.'">';
	$ecardText .= "<p>Congratulations ".$ecard->Fname."</p>
				<p>".$ecard->NomFull_name." says you've done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award for the".$ecard->BeliefID." category.</p>
				<p>".$ecard->personalMessage."</p>
				<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p>
				<p>Thank you and well done!.</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function indEcardExtraText($ecard){
	
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	
	$ecardText = '<img src="'.HTTP_PATH.'images/emails/'.$ecardImage.'.png" alt="'.$ecard->BeliefID.'">';
	$ecardText .= "<p>Congratulations ".$ecard->Fname."</p>
				<p>".$ecard->NomFull_name." says you've done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award for the ".$ecard->BeliefID." category.</p>
				<p>".$ecard->personalMessage."</p>
				<p>".$ecard->NomFname." says you deserve  'A Little Extra' as part of your award! Please log onto the <a href='".HTTP_PATH."'>Our Heroes Portal</a> to view and claim your Little Extra award.</p>
				<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p> 
				<p>Thank you and well done!</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function getCurrentFolder($name){
	$folder = basename(getcwd());
	if ($folder == $name) echo 'selected';
}
////////////////////////////////////////////////////////////////////////////////////
function indEcardTeamText($ecard){
	
	$ecard->teamEmailList = str_replace($ecard->full_name.", ","",$ecard->teamEmailList);
	$ecard->teamEmailList = str_replace(", ".$ecard->full_name,"",$ecard->teamEmailList);
	$ecard->teamEmailList = strrev(implode(strrev(' and'), explode(',', strrev($ecard->teamEmailList), 2)));
	
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	
	$ecardText = '<img src="'.HTTP_PATH.'images/emails/'.$ecardImage.'.png" alt="'.$ecard->BeliefID.'">';
	$ecardText .= "<p>Congratulations ".$ecard->Fname."</p>
				<p>".$ecard->NomFull_name." says you've done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award for the ".$ecard->BeliefID." category.</p>
				<p>".$ecard->personalMessage."</p>
				<p>The award has been given to you as part of a team award that also includes ".$ecard->teamEmailList.".</p>
				<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p>
				<p>Thank you and well done!</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function indEcardTeamExtraText($ecard){
	$ecard->teamEmailList = str_replace($ecard->full_name.", ","",$ecard->teamEmailList);
	$ecard->teamEmailList = str_replace("and ".$ecard->full_name,"",$ecard->teamEmailList);
	if (strpos($ecard->teamEmailList, 'and') !== false) {
	} else {
		$ecard->teamEmailList = strrev(implode(strrev(' and'), explode(',', strrev($ecard->teamEmailList), 2)));
	}
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	
	$ecardText = '<img src="'.HTTP_PATH.'images/emails/'.$ecardImage.'.png" alt="'.$ecard->BeliefID.'">';
	$ecardText .= "<p>Congratulations ".$ecard->Fname."</p>
				<p>".$ecard->NomFull_name." says you've done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award for the".$ecard->BeliefID." category.</p>
				<p>".$ecard->personalMessage."</p>
				<p>The award has been given to you as part of a team award that also includes ".$ecard->teamEmailList.".</p>";
	if($ecard->workAward=='20pound'){
		$ecardText .= "Each member of the team has been awarded a &pound;20 voucher. You can use your voucher to choose from a great selection of awards on the <a href='".HTTP_PATH."'>Our Heroes Portal</a>.";
	} else {
		$ecardText .= "You and your team are invited to celebrate the award together at an event of your choice. Entertainment to the value of &pound;20 per team member can be expensed to the
		 				\"Our Heroes\" project code (HRP2000). Whether it's a few drinks, a meal out or a team experience, it's up to your team to decide and make arrangements to suit you all.  
		 				".$ecard->NomFname." has nominated ".$ecard->firstPerson." as the team's contact in the first instance.</p>";
	}
	$ecardText .= "<p>".$ecard->NomFname." says you deserve  'A Little Extra' as part of your award! Please log onto the <a href='".HTTP_PATH."'>Our Heroes Portal</a> to view and claim your Little Extra award.</p>
				<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p> 
				<p>Thank you and well done!</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>