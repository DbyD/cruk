<?php
	include '../inc/config.php';
	// upload data and create emails
	//if($_SESSION['alreadydone']!='yes'){
		// get award details
		$ID = $_POST['ID'];
		$award = getTeamNomination($ID);
		print_r($award);
		echo '<br><br>';
		if($_POST['dReason'] == '') {
			// update award
			if($_SESSION['user']->EmpNum != $award->ApproverEmpNum){
				$stmt = $db->prepare("UPDATE tblnominations_team SET AprDate = NOW(), AprStatus = :AprStatus, AprSUEmpNum = :AprSUEmpNum WHERE ID = :ID");
				$stmt->bindParam(':AprSUEmpNum', $_SESSION['user']->EmpNum);
			} else {
				$stmt = $db->prepare("UPDATE tblnominations_team SET AprDate = NOW(), AprStatus = :AprStatus WHERE ID = :ID");
			}
			$stmt->bindParam(':AprStatus', $a = 1);
			$stmt->bindParam(':ID', $ID);
			$stmt->execute();
			
			// loop to add awards to each person
			$TeamMembers = $award->teamNominees();
			print_r($TeamMembers);
			foreach ($TeamMembers as $list){
				$stmt = $db->prepare("INSERT INTO tblnominations(
								awardType, NominatorEmpNum, NominatedEmpNum, nomination_teamID, Volunteer, ApproverEmpNum,
								littleExtra, amount, NomDate, AprDate, AprStatus) 
								VALUES (:awardType, :NominatorEmpNum, :NominatedEmpNum, :nomination_teamID, :Volunteer, :ApproverEmpNum, 
								:littleExtra, :amount, :NomDate, :AprDate, :AprStatus)");
				$stmt->bindParam(':awardType', $a = 2);
				$stmt->bindParam(':NominatorEmpNum', $award->NominatorEmpNum);
				$stmt->bindParam(':NominatedEmpNum', $list->EmpNum);
				$stmt->bindParam(':nomination_teamID', $award->ID);
				$stmt->bindParam(':Volunteer', $award->Volunteer);
				$stmt->bindParam(':ApproverEmpNum', $award->ApproverEmpNum);
				$stmt->bindParam(':littleExtra', $award->littleExtra);
				if($award->amount=='20pound'){
					$amount = 20;
				} else {
					$amount = 'Team Event';
				}
				$stmt->bindParam(':amount', $amount);
				$stmt->bindValue(':NomDate', $award->NomDate, PDO::PARAM_NULL);
				$stmt->bindValue(':AprDate', $award->AprDate, PDO::PARAM_NULL);
				$stmt->bindParam(':AprStatus', $award->AprStatus);
				$stmt->execute();
				
				$teamEmailList .= getName($list->EmpNum).", ";
				if(!isset($firstPerson)){
					$firstPerson = getName($list->EmpNum);
				}
			}
			$teamEmailList = chop($teamEmailList,", ");
			$teamEmailList = strrev(implode(strrev(' and'), explode(',', strrev($teamEmailList), 2)));
			$award->teamEmailList = $teamEmailList;
			echo $teamEmailList;
//			exit;
			
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
					$sendEmail->subject = 'Award Notification';
					$sendEmail->Bcc = '';
					$sendEmail->Content = "<p>Dear ".$award->nominator()->Fname."</p>
											<p>Good news!</p>
											<p>Your nomination of ".$award->teamEmailList." for an Our Heroes Extraordinary People, Extraordinary Effort Award has been approved by ".$approver_name.".</p>
											<p>The Thank You certificate you prepared when nominating this award has been sent by email to ".$award->teamEmailList." with details of the award.</p>
											<p>A record of all the nominations you have made and their current status can be viewed on the <a href='".HTTP_PATH."'>My Awards</a> section of the Our Heroes portal.</p>
											<p>Thank you for your nomination.</p>";
					$email = sendEmail($sendEmail,'T'.$ID);
					$_SESSION['alreadydone'] = 'yes';
					echo $sendEmail->Content;
				} else {
					$email = "fail";
				}
			} 
			echo $email;
			
			// email to approver
			if(filter_var($approver_email, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $approver_email;
				$sendEmail->subject = 'Award Notification';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Dear ".$approver_fname."</p>
										<p>Thank you for approving 'A Little Extra' award for ".$award->teamEmailList.". The details of this award are as follows:<p>
										<p>Nominator: ".$award->nominator()->full_name."<br>
										Team Award: ".cleanWorkAward($award->workAward)."<br>Award category: ".$award->BeliefID."</p>
										<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal. 
										You can also find a history of nominations in the <a href='".HTTP_PATH."'>Reports</a> section.</p>";
			//	$email = sendEmail($sendEmail,'T'.$ID);
				$_SESSION['alreadydone'] = 'yes';
			}
			
			
			$award->NomFull_name = $award->nominator()->full_name;
			$award->NomFname = $award->nominator()->Fname;
			$award->firstPerson = $firstPerson;
			//print_r($award);
			// send email to nominee
			foreach ($TeamMembers as $list){
				$award->teamEmailList = $teamEmailList;
				$award->Fname = $list->Fname;
				$award->full_name = $list->Fname.' '.$list->Sname;
				
				//need to get offline...
				//$award->teamNominees()->offline = ;
				
				$award->content = indEcardTeamExtraText($award);
				echo $award->content;
			// check if offline
				if ($award->teamNominees()->offline == 'YES'){
					// they in a shop so considered offline. need to fix email with all requirements. will need to get from Jamie
					$sendEmail = new StdClass();
					$sendEmail->emailTo = $xexecEmail;
					$sendEmail->subject = 'E-Card Award Notification';
					$sendEmail->Bcc = '';
					$sendEmail->Content = "<p>Hi</p>
											<p>".$award->nominator()->full_name." has nominated ".$award->teamEmailList." to receive a Thank you card as part of an Our Heroes Award.</p>
											<p>Below is the content of the card:</p>
											<p>".$award->content."</p>";
					$email = sendEmail($sendEmail,'T'.$ID);
					echo "offline email sent to xxexec";
					$_SESSION['alreadydone'] = 'yes';
				} else {
					$award->Eaddress = $list->Eaddress;
					if(filter_var($award->Eaddress, FILTER_VALIDATE_EMAIL)){
						$email = sendEcardEmail($award);
						$_SESSION['alreadydone'] = 'yes';
					} else {
						$email = "fail";
					}
					echo $email;
				}
			}
			
			//return "approved";
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
				$stmt = $db->prepare("UPDATE tblnominations_team SET dReason = :dReason, AprDate = NOW(), AprStatus = :AprStatus, AprSUEmpNum = :AprSUEmpNum WHERE ID = :ID");
				$stmt->bindParam(':AprSUEmpNum', $_SESSION['user']->EmpNum);
			} else {
				$stmt = $db->prepare("UPDATE tblnominations_team SET dReason = :dReason, AprDate = NOW(), AprStatus = :AprStatus WHERE ID = :ID");
			}
			
			$stmt->bindParam(':dReason', $_POST['dReason']);
			$stmt->bindParam(':AprStatus', $a = 2);
			$stmt->bindParam(':ID', $ID);
			$stmt->execute();
			
			if(filter_var($award->nominator()->Eaddress, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $award->nominator()->Eaddress;
				$sendEmail->subject = 'Award Notification';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Dear ".$award->nominator()->Fname."</p>
										<p>You recently nominated your team ".$award->Team." for an Our Heroes Extraordinary People, Extraordinary effort award.</p>
										<p>The nomination has been reviewed by ".$approver_name." and has unfortunately been declined.</p>
										<p>The following reason was given:<br>".$_POST['dReason']."
										<p>None of your team nominees have been notified of the declined nomination.</p>
										<p>Thank you for participating in the Our Heroes recognition programme. We strongly encourage you to submit other 
										nominations in the future via the <a href='".HTTP_PATH."'>Our Heroes</a> portal.</p>";
				$email = sendEmail($sendEmail,'T'.$ID);
				//echo $sendEmail->Content;
				$_SESSION['alreadydone'] = 'yes';
			} else {
				$email = "fail";
			}
			// email to approver
			if(filter_var($approver_email, FILTER_VALIDATE_EMAIL)){
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $approver_email;
				$sendEmail->subject = 'Award Notification';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Dear ".$approver_fname."</p>
										<p>This is confirmation that you declined a nomination made by ".$award->nominator()->full_name." for ".$award->Team."
										on the Our Heroes Portal. The reason for this decline was given as:<br>".$_POST['dReason']."<p>
										<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal. 
										You can also find a history of nominations in the <a href='".HTTP_PATH."'>Reports</a> section.</p>";
				$email = sendEmail($sendEmail,'T'.$ID);
				$_SESSION['alreadydone'] = 'yes';
			}
			
			return "declined";
		}
		//echo "end";
//	}
?>