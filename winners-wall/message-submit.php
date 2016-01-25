<?php
	include '../inc/config.php';
	if(isset($_GET['name']) && $_GET['name'] == 'message'){
	global $db;

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
	
	$recipient = getUser($EmpNum);
	$sender = getUser($NominatedEmpNum);
	
	$sendEmail = new StdClass();
	$sendEmail->subject = 'Award Notification';
	$sendEmail->Bcc = '';
	if(filter_var($recipient->Eaddress, FILTER_VALIDATE_EMAIL)){
		$sendEmail->emailTo = $recipient->Eaddress;
		$sendEmail->Content = "<p>Hello ".$recipient->Fname."</p>
								<p>".$sender->Fname." has sent you a message from the Our Heroes Portal.</p>
								<p>Message: ".$_POST["text"]."</p>
								<p>Please login to the <a href='http://cruk.xexec.dev/'>Our Heroes Portal</a> to view the message.</p>";
		$email = sendEmail($sendEmail);
		echo "success";
	} else {
		echo "fail";
	}
}
?>