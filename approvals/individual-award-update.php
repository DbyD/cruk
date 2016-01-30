<?php
	include '../inc/config.php';
	// upload data and create emails
	if($_SESSION['alreadydone']!='yes'){
		// get award details
		$ID = $_POST['ID'];
		$award = getNomination($ID);
			
		if($_POST['dReason'] == '') {
			
			$stmt = $db->prepare("UPDATE tblnominations SET AprDate = NOW() , AprStatus = :AprStatus WHERE ID = :ID");
			$stmt->bindParam(':AprStatus', $a = 1);
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
											<p>A record of all the nominations you have made and their current status can be viewed on the <a href='".HTTP_PATH."'>My Account</a> section of the Our Heroes portal.</p>
											<p>Thank you for helping to create a more engaged workplace at Cancer Research.</p>";
					$email = sendEmail($sendEmail);
					$_SESSION['alreadydone'] = 'yes';
					echo $sendEmail->Content;
				} else {
					$email = "fail";
				}
			} 
			
			echo $email;
			if(filter_var($award->nominator()->Eaddress, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $award->nominator()->Eaddress;
				$sendEmail->subject = 'Award Notification';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Hello ".$award->approver()->Fname."</p>
										<p>Thank you for approving a Little Extra award for ".$award->nominee()->full_name."<p>
										<p>Nominator: ".$award->nominator()->full_name."<br>
										Award Options: &pound;20 voucher";
				foreach ($_POST as $key => $value){
				   if (strstr($key, 'workAward')){
					   $awardtype = workAwardType($value);
					   echo $awardtype->type;
					   $sendEmail->Content .= ", ".$awardtype->type;
				   }
				}
										
				$sendEmail->Content .= "<br>Cancer Research Belief: ".$award->nominator()->BeliefID."</p>
										<p>The nomination code for future correspondence is: NO".$ID."</p>
										<p>For details of any other nominations awaiting your approval, please visit <a href='".HTTP_PATH."'>My Account</a> 
										on the Our Heroes portal. For details of all historical nomination activity in your operational jurisdiction, please visit the 
										<a href='".HTTP_PATH."'>Reports</a> section of the Our Heroes portal.</p>";
				$email = sendEmail($sendEmail);
				$_SESSION['alreadydone'] = 'yes';
			}
			// send email to nominee
			$award->Fname = $award->nominee()->Fname;
			$award->NomFull_name = $award->nominator()->full_name;
			$award->content = indEcardExtraText($award);
			echo $award->content;
			// check if offline
			
			//print_r($award);
			if ($award->nominee()->offline == 'YES'){
				// they in a shop so considered offline. need to fix email with all requirements. will need to get from Jamie
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $xexecEmail;
				$sendEmail->subject = 'E-Card Award Notification';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Hi</p>
										<p>".$award->nominator()->full_name." has nominated ".$award->nominee()->full_name." to receive a Thank you card as part of an Our Heroes Award.</p>
										<p>Below is the content of the card:</p>
										<p>".$award->content."</p>
										<p>The nomination code for future correspondence is: NO".$id."</p>";
				$email = sendEmail($sendEmail);
				echo "offline email sent to xxexec";
				$_SESSION['alreadydone'] = 'yes';
			} else {
				if(filter_var($award->nominee()->Eaddress, FILTER_VALIDATE_EMAIL)){
					$email = sendEcardEmail($award);
					$_SESSION['alreadydone'] = 'yes';
				} else {
					$email = "fail";
				}
				echo $email;
			}
			return "approved";
		} else {
			
			$stmt = $db->prepare("UPDATE tblnominations SET dReason = :dReason, AprDate = NOW() , AprStatus = :AprStatus WHERE ID = :ID");
			$stmt->bindParam(':dReason', $_POST['dReason']);
			$stmt->bindParam(':AprStatus', $a = 2);
			$stmt->bindParam(':ID', $ID);
			$stmt->execute();
			
			if(filter_var($award->nominator()->Eaddress, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $award->nominator()->Eaddress;
				$sendEmail->subject = 'Award Notification';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Hello ".$award->nominator()->Fname."</p>
										<p>You recently nominated ".$award->nominee()->full_name." for a Recognition Award.</p>
										<p>The nomination has been reviewed by ".$award->approver()->full_name." and has unfortunately been declined.</p>
										<p>The following reason was given:<br>".$_POST['dReason']."
										<p>".$award->nominee()->full_name." has not been notified of the declined nomination.</p>
										<p>The nomination code for future correspondence is: NO".$ID."</p>
										<p>Thank you for participating in the Our Heroes recognition programme. We strongly encourage you to submit other 
										nominations in the future via the <a href='".HTTP_PATH."'>Our Heroes</a> portal.</p>";
				$email = sendEmail($sendEmail);
				//echo $sendEmail->Content;
				$_SESSION['alreadydone'] = 'yes';
			} else {
				$email = "fail";
			}
			return "declined";
		}
		//echo "end";
	}
?>