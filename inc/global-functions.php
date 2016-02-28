<?php
////////////////////////////////////////////////////////////////////////////////////
function startEmail(){
	$startemail = '<!DOCTYPE HTML><html ><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
				<style type=text/css>
					body, div {margin: 0px;padding: 0px}
					.emailText {font-size: 11pt;font-family: Calibri;line-height: 14pt;color: #2e008b;background: #fff;width: 600px;padding: 0 20px;text-align: left;}
					.colorblock {padding: 20px;color: #fff;margin-bottom:20px;}
					img {display: block;}
					.ourheroes {padding: 20px;}
					.emailCruklogo {padding: 20px;text-align: right;}
					.emailCruklogo img {display: inline-block;}
					.small {font-size: 8pt;}
					.largetext {font-size: 17pt;}
					a {color:#2e008b;}
					.colorblock a {color:#fff}					
					.invoice, .details {margin-top: 10px;border-top: 1px solid #666666;border-left: 1px solid #666666;text-align:center;font-size: 11pt;font-family: Calibri;line-height: 14pt;color: #2e008b;width: 600px;}
					.mytable td {border:0px}
					.details{text-align: left;}
					.invoice td, .invoice th, .details td, .details th {border-right: 1px solid #666666;border-bottom: 1px solid #666666;}
					.details td {padding-left:10px;}
					.textLeft{text-align:left;padding-left:10px;}
					.textRight{text-align:right;padding-right:10px;}
				</style></head><body><div align="center">
				<table border="0" cellpadding="0" cellspacing="0" class="mytable"><tr><td colspan="2" class="emailText">';
	return  $startemail;
}
////////////////////////////////////////////////////////////////////////////////////
function startEcardEmail(){
	$startemail = '<!DOCTYPE HTML><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    			<title>CRUK Our Heroes</title>
				<style type=text/css>
					body, div {margin: 0px;padding: 0px}
					.small {font-size: 8pt;}
					.largetext {font-size: 17pt;}
					a {color: #fff;}
					.mytable {width: 600px;}
					.emailText {font-size: 11pt;font-family: Calibri;line-height: 14pt;color: #fff;background: #fff;width: 600px;text-align: left;padding: 20px;color: #fff;}
					.mytable img {display: block; width:600px;}
					.ourheroes {padding: 20px;}
					.emailCruklogo {padding: 20px;text-align: right;}
					.emailCruklogo img {display: inline-block;}
				</style></head><body><div align="center"><table border="0" cellpadding="0" cellspacing="0" class="mytable"><tr><td colspan="2">';
	return  $startemail;
}
////////////////////////////////////////////////////////////////////////////////////
function endEmail($noid){
	$endemail = '';
	$endemail .= '<p><b>Our Heroes Team</b></p>';
	if($noid != ''){
			$endemail .= '<p class="small">Xexec ref: '.$noid.'</p>';
	}
	$endemail .= '</td></tr><tr>
						<td class="ourheroes"><img src="'.HTTP_PATH.'images/emails/our-heroes.png" alt="Cancer Research UK"></td>
						<td class="emailCruklogo"><img src="'.HTTP_PATH.'images/emails/Cancer-Research-UK.png" alt="Cancer Research UK"></td>
					</tr></table>';
	$endemail .= '</div></body></html>';
	return $endemail;
}
////////////////////////////////////////////////////////////////////////////////////
function endEcardEmail($noid){
	$endemail = '';
	$endemail .= '<p>Thank you and well done!</p><p><b>Our Heroes Team</b></p>';
	if($noid != ''){
			$endemail .= '<p class="small">Xexec ref: '.$noid.'</p>';
	}
	$endemail .= '</td></tr><tr>
						<td class="ourheroes"><img src="'.HTTP_PATH.'images/emails/our-heroes.png" alt="Cancer Research UK"></td>
						<td class="emailCruklogo"><img src="'.HTTP_PATH.'images/emails/Cancer-Research-UK.png" alt="Cancer Research UK"></td>
					</tr></table>';
	$endemail .= '</div></body></html>';
	return $endemail;
}
////////////////////////////////////////////////////////////////////////////////////
// send email
function sendEmail($email,$noid){
	global $headers;
	$message = startEmail();
	$message .= $email->Content;
	$message .= endEmail($noid);
	if(isset($email->Cc)){
		$headers .= "Cc: ". $email->Cc . "\r\n";
	}
	if(isset($email->Bcc)){
		$headers .= "Bcc: ". $email->Bcc . "\r\n";
	}
	if (mail($email->emailTo, $email->subject, $message, $headers)){
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
function sendEcardEmail($ecard,$ID){
	// need to fix this so we can email anytime
	global $headers;
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
	$message = startEcardEmail();
	$message .= str_replace('<div class="colorblock"', '</td></tr><tr><td colspan="2" class="emailText"', $ecard->content);
	$message .= endEcardEmail($ID);
	if(isset($ecard->Cc)){
		$headers .= "Cc: ". $ecard->Cc . "\r\n";
	}
	if(isset($ecard->Bcc)){
		$headers .= "Bcc: ". $ecard->Bcc . "\r\n";
	}
	if (mail($emailTo, $ecard->subject, $message, $headers)){
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
function getConvertedShortDate($date){
	$date = new DateTime($date);
	return date_format($date, 'd M Y');
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
	$ecardText = ecardTopBar($ecard);
	$ecardText .= "<p>Dear ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." says you've done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award in the ".$ecard->BeliefID." category. Here's what they said:</p>
				<p>".$ecard->personalMessage."</p>
				<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function indEcardExtraText($ecard){
	$ecardText = ecardTopBar($ecard);
	$ecardText .= "<p>Dear ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." says you've done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award in the ".$ecard->BeliefID." category. </p>
				<p>".$ecard->personalMessage."</p>
				<p>".$ecard->NomFname." says you deserve  'A Little Extra' as part of your award! <span class='hide'>Please log on (or register if you haven't already) to the <a href='".HTTP_PATH."'>Our Heroes Portal</a> to view and claim your Little Extra award.</span></p>
				<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p>";
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
	$ecardText = ecardTopBar($ecard);
	$ecardText .= "<p>Dear ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." says you've done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award in the ".$ecard->BeliefID." category.</p>
				<p>".$ecard->personalMessage."</p>";
				
	if(substr_count($ecard->teamEmailList, ",") > 3){
		$ecardText .="<p>The award has been given to ".getmyTeamName($ecard->teamID)." as a team award.</p>";
	} else {
		$ecardText .="<p>The award has been given to you as part of a team award that also includes ".$ecard->teamEmailList.".</p>";
	}
	
	$ecardText .= "<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p>";
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
	
	$ecardText = ecardTopBar($ecard);
	
	$ecardText .= "<p>Dear ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." says you’ve done something really special and deserve an Our Heroes Extraordinary People, 
				Extraordinary Effort award in the ".$ecard->BeliefID." category.</p>
				<p>".$ecard->personalMessage."</p>";
				
	if(substr_count($ecard->teamEmailList, ",") > 3){
		$ecardText .="<p>The award has been given to ".getmyTeamName($ecard->teamID)." as a team award.</p>";
	} else {
		$ecardText .="<p>The award has been given to you as part of a team award that also includes ".$ecard->teamEmailList.".</p>";
	}
				
	if($ecard->workAward=='20pound'){
		$ecardText .= "Each member of the team has been awarded a &pound;20 voucher. You can use your voucher to choose from a great selection of awards on the <a href='".HTTP_PATH."'>Our Heroes Portal</a>.";
	} else {
		$ecardText .= "You and your team are invited to celebrate the award together at an event of your choice. Entertainment to the value of &pound;20 per team member can be expensed to the
		 				\"Our Heroes\" project code (HRP2000). Whether it's a few drinks, a meal out or a team experience, it's up to your team to decide and make arrangements to suit you all.  
		 				".$ecard->NomFname." has nominated ".$ecard->firstPerson." as the team's contact in the first instance.</p>";
	}
	$ecardText .= "<p>Through your dedication and commitment we can beat cancer sooner. The success of Cancer Research UK depends on people like you and we want you to know how much we appreciate your efforts.</p>";
				
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function ecardTopBar($ecard){
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	
	switch ($ecard->BeliefID) {
		case 'Be Brave'  :
			$backgroundColor= "#ec008c";
			break;
		case 'Be Sharp'  :
			$backgroundColor= "#00b6ed";
			break;
		case 'Be United'  :
			$backgroundColor= "#5833a2";
			break;
		default             :
			$backgroundColor= "#ec008c";
	}
	
	$ecardText = '<img src="'.HTTP_PATH.'images/emails/'.$ecardImage.'.png" alt="'.$ecard->BeliefID.'">';
	$ecardText .= '<div class="colorblock" style="background:'.$backgroundColor.'">';
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>