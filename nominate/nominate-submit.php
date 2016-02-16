<?php
	include '../inc/config.php';
	if($_SESSION['alreadydone']!='yes'){
		// upload data and create emails
		$today = date("Y-m-d H:i:s", strtotime(date ("Y-m-d H:i:s")));
		
		$_SESSION['nominee']->BeliefID = $_POST['BeliefID'];
		$_SESSION['nominee']->personalMessage = $_POST['personalMessage'];
		if($_POST['littleExtra']){
			$_SESSION['nominee']->littleExtra = 'Yes';
		} else {
			$_SESSION['nominee']->littleExtra = 'No';
		}
		if($_POST['awardPrivate']){
			$_SESSION['nominee']->awardPrivate = 'Yes';
		} else {
			$_SESSION['nominee']->awardPrivate = 'No';
		}
		//print_r($_SESSION['nominee']);
		$stmt = $db->prepare("INSERT INTO tblnominations(
								awardType, NominatorEmpNum, NominatedEmpNum, Volunteer, ApproverEmpNum, Team, Section, Department, Directorate,
								littleExtra, amount, personalMessage, Reason, BeliefID, dReason, NomDate, AprDate, AprStatus, awardPrivate) 
								VALUES (:awardType, :NominatorEmpNum, :NominatedEmpNum, :Volunteer, :ApproverEmpNum, :Team, :Section, :Department, :Directorate, 
								:littleExtra, :amount, :personalMessage, :Reason, :BeliefID, :dReason, NOW(), :AprDate, :AprStatus, :awardPrivate)");
		$stmt->bindParam(':awardType', $a = 1);
		$stmt->bindParam(':NominatorEmpNum', $_SESSION['user']->EmpNum);
		$stmt->bindParam(':NominatedEmpNum', $_SESSION['nominee']->EmpNum);
		$stmt->bindParam(':Volunteer', $_SESSION['nominee']->Volunteer);
		
		// need to work out who correct approver is
		$stmt->bindParam(':ApproverEmpNum', $_SESSION['nominee']->AppEmpNum);
		
		$stmt->bindParam(':Team', $_SESSION['nominee']->Team);
		$stmt->bindParam(':Section', $_SESSION['nominee']->Section);
		$stmt->bindParam(':Department', $_SESSION['nominee']->Department);
		$stmt->bindParam(':Directorate', $_SESSION['nominee']->Directorate);
		$stmt->bindParam(':littleExtra', $_SESSION['nominee']->littleExtra);
		$stmt->bindParam(':personalMessage', $_SESSION['nominee']->personalMessage);
		$stmt->bindParam(':Reason', $_SESSION['nominee']->Reason);
		$stmt->bindParam(':BeliefID', $_SESSION['nominee']->BeliefID);
		$stmt->bindParam(':dReason', $_SESSION['nominee']->dReason);
		if($_SESSION['nominee']->littleExtra=='Yes'){
			$stmt->bindParam(':amount', $a = 20);
			// check if nominee is also approver
			if($_SESSION['nominee']->AppEmpNum == $_SESSION['user']->EmpNum){
				$stmt->bindParam(':AprStatus', $a = 1);
				$stmt->bindParam(':AprDate', $today, PDO::PARAM_STR);
			}else {
				$stmt->bindParam(':AprStatus', $a = 0);
				$stmt->bindValue(':AprDate', NULL, PDO::PARAM_NULL);
			}
		} else {
			$stmt->bindParam(':AprStatus', $a = 1);
			$stmt->bindParam(':AprDate', $today, PDO::PARAM_STR);
			$stmt->bindParam(':amount', $a = 0);
		}
		$stmt->bindParam(':awardPrivate', $_SESSION['nominee']->awardPrivate);
	
		$stmt->execute();
		$id = $db->lastInsertId();
		$_SESSION['alreadydone'] = 'yes';
		// add in work awards if app = nom
		if($_SESSION['nominee']->littleExtra=='Yes' && ($_SESSION['nominee']->AppEmpNum == $_SESSION['user']->EmpNum)){
			foreach ($_SESSION['nominee']->workAward as $key => $value){
				if (strstr($key, 'workAward')){
					$stmt = $db->prepare("INSERT INTO tblworknominations(nominationID, workawardsID) VALUES (:nominationID, :workawardsID)");
					$stmt->bindParam(':nominationID', $id);
					$stmt->bindParam(':workawardsID', $value);
					$stmt->execute();
				}
			}
		}
			
		if($_SESSION['nominee']->littleExtra=='Yes' && ($_SESSION['nominee']->AppEmpNum != $_SESSION['user']->EmpNum)){
			$sendEmail = new StdClass();
			$sendEmail->subject = 'Award Notification';
			$sendEmail->Bcc = '';
			if($_SESSION['nominee']->AppEmpNum ==''){
				// send email to super user. but using xexec for now.
				$sendEmail->emailTo = getSUemail();
				$sendEmail->Cc = 'ourheroes@cancer.org.uk';
				$sendEmail->Content = "<p>Hello </p>
										<p>".$_SESSION['user']->Fname." has nominated ".$_SESSION['nominee']->full_name()." to receive 'A Little Extra' as part of an Our Heroes Award.</p>
										<p>Hoever there is no approver listed. </p>";
				$email = sendEmail($sendEmail,$id);
				echo $sendEmail->Content;
			} else {
				// send email to approver
				if(filter_var($_SESSION['nominee']->Eaddress, FILTER_VALIDATE_EMAIL)){
					$sendEmail->emailTo = $_SESSION['nominee']->AppEaddress;
					$sendEmail->Content = "<p>Hello ".$_SESSION['nominee']->AppFname."</p>
											<p>".$_SESSION['user']->Fname." has nominated ".$_SESSION['nominee']->full_name()." to receive 'A Little Extra' as part of an Our Heroes Award.</p>
											<p>".$_SESSION['user']->Fname." has given the following reason for the nomination:</p>
											<p>".$_SESSION['nominee']->Reason."</p>
											<p>Please login to the <a href='".HTTP_PATH."'>Our Heroes Portal</a> to view the details of the proposed nomination and to approve or decline the award.</p>
											<p>If no decision is made within the next 30 days, the nomination will automatically be approved.</p>";
					$email = sendEmail($sendEmail,$id);
					echo $sendEmail->Content;
				} else {
					$email = "fail";
				}
			}
			$_SESSION['alreadydone'] = 'yes';
		} else {
			if(($_SESSION['nominee']->AppEmpNum == $_SESSION['user']->EmpNum)){
				// email to approver
				if(filter_var($_SESSION['user']->Eaddress, FILTER_VALIDATE_EMAIL)){
					$sendEmail = new StdClass();
					$sendEmail->emailTo = $_SESSION['user']->Eaddress;
					$sendEmail->subject = 'Award Notification';
					$sendEmail->Bcc = '';
					$sendEmail->Content = "<p>Dear ".$_SESSION['user']->Fname."</p>
											<p>Thank you for approving 'A Little Extra' award for ".$_SESSION['nominee']->full_name().". The details of this award are as follows:<p>
											<p>Nominator: ".$_SESSION['user']->full_name."<br>
											Award Options: &pound;20 voucher";
					foreach ($_SESSION['nominee']->workAward as $key => $value){
					   if (strstr($key, 'workAward')){
						   $awardtype = workAwardType($value);
						   echo $awardtype->type;
						   $sendEmail->Content .= ", ".$awardtype->type;
					   }
					}
					$sendEmail->Content .= "<br>Award category: ".$_SESSION['nominee']->BeliefID."</p>
											<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal. 
											You can also find a history of nominations in the <a href='".HTTP_PATH."'>Reports</a> section.</p>";
					$email = sendEmail($sendEmail,$id);
					$_SESSION['alreadydone'] = 'yes';
				}
			}
			// send email to nominee
			if ($_SESSION['nominee']->Volunteer !='') {
				$_SESSION['nominee']->NomFull_name = $_SESSION['nominee']->Volunteer;
			} else {
				$_SESSION['nominee']->NomFull_name = $_SESSION['user']->full_name();
			}
			$_SESSION['nominee']->content = indEcardText($_SESSION['nominee']);
			// test if offline
			if ($_SESSION['nominee']->offline == 'YES'){
				// they in a shop so considered offline. need to fix email with all requirements. will need to get wording from Jamie
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $xexecEmail;
				$sendEmail->subject = 'Congratulations, you’ve been sent an Our Heroes award';
				$sendEmail->Bcc = '';
				$sendEmail->Content = "<p>Hi</p>
										<p>".$_SESSION['user']->Fname." has nominated ".$_SESSION['nominee']->full_name()." to receive a Thank you card as part of an Our Heroes Award.</p>
										<p>Below is the content of the card:</p>
										<p>".$_SESSION['nominee']->content."</p>";
				$email = sendEmail($sendEmail,$id);
				echo "offline email sent to xxexec";
			} else {
				if(filter_var($_SESSION['nominee']->Eaddress, FILTER_VALIDATE_EMAIL)){
					$_SESSION['nominee']->emailsubject ="Congratulations, you've been sent an Our Heroes award";
					$email = sendEcardEmail($_SESSION['nominee']);
				} else {
					$email = "fail xexec";
				}
				echo "email sent to nominee";
			}
			$_SESSION['alreadydone'] = 'yes';
		}
		echo $email;
	}
	header("Location: nominate-done.php");
?>