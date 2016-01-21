<?php
	include '../inc/config.php';
	// upload data and create emails
	echo "start".$_POST['ID']."--";
	if($_POST['dReason'] == '') {
		
		// get award details
		$ID = $_POST['ID'];
		$stmt = $db->prepare('SELECT * FROM tblnominations WHERE ID = :ID');
		$stmt->execute(array('ID' => $ID));
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Award');
		$award = $stmt->fetch();
		/*print_r($award);
		print_r($award->nominator());
		print_r($award->nominee());
		print_r($award->approver());*/
		
		$stmt = $db->prepare("UPDATE tblnominations SET AprDate = NOW() , AprStatus = :AprStatus WHERE ID = :ID");
		$stmt->bindParam(':AprStatus', $a = 1);
		//$stmt->bindParam(':AprDate', 'NOW()'); // Dont know why its not working
		$stmt->bindParam(':ID', $ID);
		$stmt->execute();
		
		// loop to add workawards
		foreach ($_POST as $key => $value){
		   if (strstr($key, 'workAward')){
				echo $value.$award->NominatedEmpNum;
				$stmt = $db->prepare("INSERT INTO tblworknominations(nominationID, workawardsID) VALUES (:nominationID, :workawardsID)");
				$stmt->bindParam(':nominationID', $ID);
				$stmt->bindParam(':workawardsID', $value);
				$stmt->execute();
		   }
		}
		
		if($award->ApproverEmpNum != $award->NominatorEmpNum){
			// send email to nominator
			if(filter_var($award->nominator()->Eaddress, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $award->nominator()->Eaddress;
				$sendEmail->subject = 'Award Notification';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Hello ".$award->nominator()->Fname."</p>
										<p>Good news!</p>
										<p>Your nomination of ".$award->nominee()->full_name." for an Our Heroes Award has been approved by ".$award->approver()->full_name.".</p>
										<p>The Thank You certificate you prepared when nominating this award has been sent by email to ".$award->nominee()->full_name." with details of the award.</p>
										<p>The nomination code for future correspondence is: NO".$ID."</p>
										<p>A record of all the nominations you have made and their current status can be viewed on the <a href='https://ourheroes.co.uk'>My Account</a> section of the Our Heroes portal.</p>
										<p>Thank you for helping to create a more engaged workplace at Cancer Research.</p>";
				$email = sendEmail($sendEmail);
				echo $sendEmail->Content;
			} else {
				$email = "fail";
			}
		} 
		echo $email;
		// send email to nominee
		if(filter_var($award->nominee()->Eaddress, FILTER_VALIDATE_EMAIL)){
			$email = sendEcardEmail($award);
		} else {
			$email = "fail";
		}
		echo $email;
		return "approved";
	} else {
		return "declined";
	}
	//echo "end";
?>