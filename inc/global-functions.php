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
				</style></head><body><div align="center"><div class="emailText">
				<div class="ourheroes"><img src="'.HTTP_PATH.'images/emails/our-heroes.png" alt="Cancer Research UK"></div>';
	return  $startemail;
}
////////////////////////////////////////////////////////////////////////////////////
function endEmail(){
	$endemail .= '<img class="emailCruklogo" src="'.HTTP_PATH.'images/emails/Cancer-Research-UK.png" alt="Cancer Research UK">';
	$endemail .= '<p>Regards</p><p><b>Cancer Research</b></p>
				</div></div></body></html>';
	return $endemail;
}
////////////////////////////////////////////////////////////////////////////////////
// send email
function sendEmail($email){
	global $strFrom;
	$message = startEmail();
	$message .= $email->Content;
	$message .= endEmail();
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
	$ecardText .= "<p>Hello ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." would like to thank you for the amazing work you have performed here at Cancer Research.</p>
				<p>".$ecard->personalMessage."</p>
				<p>The CRUK Belief most closely associated with your achievement is: ".$ecard->BeliefID.".</p>
				<p>Congratulations again and many thanks for your contribution to Cancer Research UK.</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function indEcardExtraText($ecard){
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	$ecardText = '<img src="'.HTTP_PATH.'images/emails/'.$ecardImage.'.png" alt="'.$ecard->BeliefID.'">';
	$ecardText .= "<p>Hello ".$ecard->Fname."</p>
				<p>Congratulations!</p>
				<p>".$ecard->NomFull_name." would like to thank you for the amazing work you have performed here at Cancer Research.</p>
				<p>".$ecard->personalMessage."</p>
				<p>The CRUK Belief most closely associated with your achievement is: ".$ecard->BeliefID.".</p>
				<p>As part of your award, you've also been given a 'Little Extra'. Please log onto the <a href='http://http://cruk.xexec.dev/'>Our Heroes Portal</a> to view and claim your Little Extra something.</p>
				<p>Congratulations again and many thanks for your contribution to Cancer Research UK.</p>";
	return $ecardText;
}
////////////////////////////////////////////////////////////////////////////////////
function getAllEmployees(){
	global $db;

	//Photo,Fname,Belief,NominatedEmpNum

	$sql = "
SELECT  e.Fname AS name,
		e.EmpNum AS EmpNum,
		e.Photo AS Photo,
		e.Belief AS Belief,
		n.NominatedEmpNum AS NominatedEmpNum
FROM 
	tblnominations AS n
		INNER JOIN
	tblempall AS e
			ON n.NominatorEmpNum = e.EmpNum GROUP BY n.NominatorEmpNum";

	$stmt = $db->prepare( $sql );
	
	$stmt->execute();

	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arr[] = $result;
	}

	if( count($arr) == 0){
		return 0;
	}

	return $arr;
}

function getMyMessages( $empnum ) {
	global $db;

	$stmt = $db->prepare('SELECT * FROM tblmessage WHERE recipient = :recipient');
	$stmt->execute(array('recipient' => $empnum));

	while($result = $stmt->fetch( PDO::FETCH_ASSOC )) {
		$arr[] = $result;
	}

	if(count($arr) == 0){
		return 0;
	}

	return $arr;
}

if(isset($_GET['name']) && $_GET['name'] == 'message'){
	$db_server = 'Localhost';
	$db_database = 'cruk';
	$db_user = 'DbyDcruk';
	$db_passwd = 'dbd#01master';
	
	try {
		$db = new PDO("mysql:host=$db_server;dbname=$db_database", $db_user, $db_passwd);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

	$stmt = $db->prepare("INSERT INTO tblmessage (recipient, sender, text, date) VALUES (:recipient, :sender, :text, :date)");
	
	$NominatedEmpNum = $_POST["recipient"];
	$EmpNum = $_POST["sender"];
	$text = $_POST["text"];
	$date = date('Y-m-d H:i:s');

	$stmt->bindValue(':recipient',$NominatedEmpNum, PDO::PARAM_STR);
	$stmt->bindValue(':sender', $EmpNum, PDO::PARAM_STR);
	$stmt->bindValue(':text',$text , PDO::PARAM_STR);
	$stmt->bindValue(':date',$date , PDO::PARAM_STR);
	$stmt->execute();
}
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>