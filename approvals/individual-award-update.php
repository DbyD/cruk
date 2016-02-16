<?php
	include '../inc/config.php';
	// upload data and create emails
	//if($_SESSION['alreadydone']!='yes'){
		// get award details
		$ID = $_POST['ID'];
		$award = getNomination($ID);
			
		if($_POST['dReason'] == '') {
			// update award
			if($_SESSION['user']->EmpNum != $award->ApproverEmpNum){
				$stmt = $db->prepare("UPDATE tblnominations SET AprDate = NOW(), AprStatus = :AprStatus, AprSUEmpNum = :AprSUEmpNum WHERE ID = :ID");
				$stmt->bindParam(':AprSUEmpNum', $_SESSION['user']->EmpNum);
			} else {
				$stmt = $db->prepare("UPDATE tblnominations SET AprDate = NOW(), AprStatus = :AprStatus WHERE ID = :ID");
			}
			$stmt->bindParam(':AprStatus', $a = 1);
			$stmt->bindParam(':ID', $ID);
			$stmt->execute();
			
			// loop to add workawards
			foreach ($_POST as $key => $value){
				if (strstr($key, 'workAward')){
					//echo $value.$award->NominatedEmpNum;
					$stmt = $db->prepare("INSERT INTO tblworknominations(nominationID, workawardsID) VALUES (:nominationID, :workawardsID)");
					$stmt->bindParam(':nominationID', $ID);
					$stmt->bindParam(':workawardsID', $value);
					$stmt->execute();
				}
			}
			
			// set approver if approver is SU
			if($_SESSION['user']->EmpNum != $award->ApproverEmpNum){
				$approver_name = $_SESSION['user']->Fname.' '.$_SESSION['user']->Sname;
				$approver_fname = $_SESSION['user']->Fname;
				$approver_email = $_SESSION['user']->Eaddress;
			} else {
				$approver_name = $award->approver()->full_name;
				$approver_fname = $award->approver()->Fname;
				$approver_email = $award->approver()->Eaddress;
			}
				
			// send email to nominator
			if($award->ApproverEmpNum != $award->NominatorEmpNum){
				if(filter_var($award->nominator()->Eaddress, FILTER_VALIDATE_EMAIL)){
					$sendEmail = new StdClass();
					$sendEmail->emailTo = $award->nominator()->Eaddress;
					$sendEmail->subject = 'Congratulations, your nomination has been approved';
					$sendEmail->Bcc = '';
					$sendEmail->Content = "<p>Dear ".$award->nominator()->Fname."</p>
											<p>Good news!</p>
											<p>Your nomination of ".$award->nominee()->full_name." for an Our Heroes Extraordinary People, Extraordinary Effort Award has been approved by ".$approver_name.".</p>
											<p>The Thank You certificate you prepared when nominating this award has been sent by email to ".$award->nominee()->full_name." with details of the award.</p>
											<p>A record of all the nominations you have made and their current status can be viewed on the <a href='".HTTP_PATH."'>My Awards</a> section of the Our Heroes portal.</p>
											<p>Thank you for your nomination.</p>
											<p>Kind Regards</p>";
					$email = sendEmail($sendEmail,$ID);
					$_SESSION['alreadydone'] = 'yes';
					//echo $sendEmail->Content;
				} else {
					$email = "fail";
				}
			} 
			//echo $email;
			
			$awardOptions = '&pound;20 voucher';
			foreach ($_POST as $key => $value){
				if (strstr($key, 'workAward')){
					$awardtype = workAwardType($value);
					$awardOptions .= ", ".$awardtype->type;
				}
			}
			$awardOptions = chop($awardOptions,", ");
			$awardOptions = strrev(implode(strrev(' and'), explode(',', strrev($awardOptions), 2)));

			// email to Line Manger
			if($award->ApproverEmpNum != $award->lineManager()->EmpNum){
				if(filter_var($award->lineManager()->Eaddress, FILTER_VALIDATE_EMAIL)){
					$sendEmail = new StdClass();
					$sendEmail->emailTo = $award->lineManager()->Eaddress;
					$sendEmail->subject = "Congratulations, someone in your team has been sent a 'Little Extra' award";
					$sendEmail->Bcc = '';
					$sendEmail->Content = "<p>Dear ".$award->lineManager()->Fname."</p>
											<p>Good news!</p>
											<p>".$award->nominee()->full_name." in your team has been given an Our Heroes Extraordinary People, Extraordinary Effort award by ".$award->nominator()->full_name." for the ".$award->BeliefID." category.</p>
											<p>".$award->nominee()->Fname." was also given 'A Little Extra' as part of the award and can choose from: ".$awardOptions.". This was approved by ".$approver_name.".</p>
											<p>Please congratulate ".$award->nominee()->Fname." in person and to consider other members of your team who may be suitable for a nomination on the <a href='".HTTP_PATH."'>Our Heroes</a> portal.</p>
											<p>Kind Regards</p>";
											print_r($sendEmail);
					$email = sendEmail($sendEmail,$ID);
					$_SESSION['alreadydone'] = 'yes';
					echo $sendEmail->Content;
				} else {
					$email = "fail";
				}
			} 
			echo $email;
			
			// email to Shop Manager to be added in. At the present no shop mgr has an email address.
			
			// email to approver
			if(filter_var($approver_email, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $approver_email;
				$sendEmail->subject = "Confirmation of your approval for a 'Little Extra' award";
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Dear ".$approver_fname."</p>
										<p>Thank you for approving 'A Little Extra' award for ".$award->nominee()->full_name.". The details of this award are as follows:<p>
										<p>Nominator: ".$award->nominator()->full_name."<br>
										Award Options: ".$awardOptions."
										<br>Award category: ".$award->BeliefID."</p>
										<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal.</p>
										<p>Thank you</p>";
				$email = sendEmail($sendEmail,$ID);
				$_SESSION['alreadydone'] = 'yes';
			}
			
			// send email to nominee
			$award->Fname = $award->nominee()->Fname;
			$award->NomFull_name = $award->nominator()->full_name;
			$award->NomFname = $award->nominator()->Fname;
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
										<p>".$award->content."</p>";
				$email = sendEmail($sendEmail,$ID);
				echo "offline email sent to xxexec";
				$_SESSION['alreadydone'] = 'yes';
			} else {
				if(filter_var($award->nominee()->Eaddress, FILTER_VALIDATE_EMAIL)){
					$award->subject = "Congratulations, you've been sent an Our Heroes award with 'A Little Extra'";
					$email = sendEcardEmail($award,$ID);
					$_SESSION['alreadydone'] = 'yes';
				} else {
					$email = "fail";
				}
				echo $email;
			}
			
			return "approved";
		} else {
			
			// set approver if approver is SU
			if($_SESSION['user']->EmpNum != $award->ApproverEmpNum){
				$approver_name = $_SESSION['user']->Fname.' '.$_SESSION['user']->Sname;
				$approver_fname = $_SESSION['user']->Fname;
				$approver_email = $_SESSION['user']->Eaddress;
			} else {
				$approver_name = $award->approver()->full_name;
				$approver_fname = $award->approver()->Fname;
				$approver_email = $award->approver()->Eaddress;
			}
			
			// update award
			if($_SESSION['user']->EmpNum != $award->ApproverEmpNum){
				$stmt = $db->prepare("UPDATE tblnominations SET dReason = :dReason, AprDate = NOW(), AprStatus = :AprStatus, AprSUEmpNum = :AprSUEmpNum WHERE ID = :ID");
				$stmt->bindParam(':AprSUEmpNum', $_SESSION['user']->EmpNum);
			} else {
				$stmt = $db->prepare("UPDATE tblnominations SET dReason = :dReason, AprDate = NOW(), AprStatus = :AprStatus WHERE ID = :ID");
			}
			
			$stmt->bindParam(':dReason', $_POST['dReason']);
			$stmt->bindParam(':AprStatus', $a = 2);
			$stmt->bindParam(':ID', $ID);
			$stmt->execute();
			
			if(filter_var($award->nominator()->Eaddress, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $award->nominator()->Eaddress;
				$sendEmail->subject = "Unfortunately your 'Little Extra' nomination has been declined";
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Dear ".$award->nominator()->Fname."</p>
										<p>You recently nominated ".$award->nominee()->full_name." for an Our Heroes Extraordinary People, Extraordinary effort award.</p>
										<p>The nomination has been reviewed by ".$approver_name." and has unfortunately been declined.</p>
										<p>The following reason was given:<br>".$_POST['dReason']."
										<p>".$award->nominee()->full_name." has not been notified of the declined nomination.</p>
										<p>Thank you for participating in the Our Heroes recognition programme. We strongly encourage you to submit other 
										nominations in the future via the <a href='".HTTP_PATH."'>Our Heroes</a> portal.</p>
										<p>Kind Regards</p>";
				$email = sendEmail($sendEmail,$ID);
				//echo $sendEmail->Content;
				$_SESSION['alreadydone'] = 'yes';
			} else {
				$email = "fail";
			}
			// email to approver
			if(filter_var($approver_email, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $approver_email;
				$sendEmail->subject = "Confirmation that you declined a 'Little Extra' award";
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Dear ".$approver_fname."</p>
										<p>This is confirmation that you declined a nomination made by ".$award->nominator()->full_name." for ".$award->nominee()->full_name."
										on the Our Heroes Portal. The reason for this decline was given as:<br>".$_POST['dReason']."<p>
										<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal.</p>
										<p>Kind Regards</p>";
				$email = sendEmail($sendEmail,$ID);
				$_SESSION['alreadydone'] = 'yes';
			}
			
			return "declined";
		}
		//echo "end";
	//}
?>