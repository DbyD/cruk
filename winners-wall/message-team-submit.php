<?php
	include '../inc/config.php';
	if(isset($_GET['name']) && $_GET['name'] == 'message'){
		global $db;
		
		$recipientTeam = $_POST["recipientTeam"];
		$EmpNum = $_POST["senderTeam"];
		$date = date('Y-m-d H:i:s');
		
		// need to get each team member
		$TeamMembers = getThisTeamMembers($recipientTeam);
		foreach ($TeamMembers as $list){

			$stmt = $db->prepare("INSERT INTO tblmessage (recipient, sender, Department, text, date) VALUES (:recipient, :sender, :Department, :text, :date)");
			
			$NominatedEmpNum = $list['EmpNum'];
			$stmt->bindValue(':recipient',$NominatedEmpNum, PDO::PARAM_STR);
			
			$stmt->bindValue(':sender', $EmpNum, PDO::PARAM_STR);
			
			$Department = $list['Department'];
			$stmt->bindValue(':Department', $Department, PDO::PARAM_STR);
			
			$text = 'Hi '.$list['Fname'].'. I saw your "Our Heroes" award on the Wall of Fame. Congratulations! '.getName($EmpNum);
			$stmt->bindValue(':text',$text , PDO::PARAM_STR);
			
			$stmt->bindValue(':date',$date , PDO::PARAM_STR);
			$stmt->execute();
			
			$recipient = getUser($NominatedEmpNum);
			$senderTeam = getUser($EmpNum);
			
			$sendEmail = new StdClass();
			$sendEmail->subject = 'Award Notification';
			if(filter_var($recipient->Eaddress, FILTER_VALIDATE_EMAIL)){
				$sendEmail->emailTo = $recipient->Eaddress;
				$sendEmail->Content = "<p>Hello ".$recipient->Fname."</p>
										<p>".$senderTeam->Fname." has sent you a message from the Our Heroes Portal.</p>
										<p>Message: ".$text."</p>
										<p>To see who else has recently won awards or to nominate a colleague, please login to the <a href='".HTTP_PATH."'>Our Heroes Portal</a>.</p>";
				$email = sendEmail($sendEmail,'');
				echo "success";
			} else {
				echo "fail";
			}
		}
	}
?>