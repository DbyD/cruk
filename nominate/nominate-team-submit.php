<?php
	include '../inc/config.php';
	//if($_SESSION['alreadydone']!='yes'){
		// upload data and create emails
		$today = date("Y-m-d H:i:s", strtotime(date ("Y-m-d H:i:s")));
		
		$_SESSION['teamnominee']->BeliefID = $_POST['BeliefID'];
		$_SESSION['teamnominee']->personalMessage = $_POST['personalMessage'];
		if($_POST['littleExtra']){
			$_SESSION['teamnominee']->littleExtra = 'Yes';
		} else {
			$_SESSION['teamnominee']->littleExtra = 'No';
		}
		if($_POST['awardPrivate']){
			$_SESSION['teamnominee']->awardPrivate = 'Yes';
		} else {
			$_SESSION['teamnominee']->awardPrivate = 'No';
		}
		
		
		//print_r($_SESSION['teamnominee']);
		//echo "<br><br>";
		$stmt = $db->prepare("INSERT INTO tblnominations_team(
								awardType, NominatorEmpNum, Volunteer, ApproverEmpNum, Team, 
								littleExtra, amount, personalMessage, Reason, BeliefID, dReason, NomDate, AprDate, AprStatus, awardPrivate) 
								VALUES (:awardType, :NominatorEmpNum, :Volunteer, :ApproverEmpNum, :Team, 
								:littleExtra, :amount, :personalMessage, :Reason, :BeliefID, :dReason, NOW(), :AprDate, :AprStatus, :awardPrivate)");
		$stmt->bindParam(':awardType', $a = 2);
		$stmt->bindParam(':NominatorEmpNum', $_SESSION['user']->EmpNum);
		$stmt->bindParam(':Volunteer', $_SESSION['teamnominee']->Volunteer);
		
		// need to work out who correct approver is. get approver for first person
		$searchList = array_to_object(getThisTeamMembers($_SESSION['teamnominee']->teamID));
		//print_r($searchList);
		if ($searchList){
			foreach ($searchList as $list){
				//echo $list->AppEmpNum;
				$AppEmpNum = getTeamsApprover($list->EmpNum);
				$_SESSION['teamnominee']->AppEmpNum = $AppEmpNum->AppEmpNum;
				$_SESSION['teamnominee']->full_App_name = $AppEmpNum->Fname.' '.$AppEmpNum->Sname;
				//print_r($AppEmpNum);
		//echo "<br><br>";
				if($AppEmpNum->AppEmpNum !='') break;
			}
		}
		
		$stmt->bindParam(':ApproverEmpNum', $AppEmpNum->AppEmpNum);
		$stmt->bindParam(':Team', getmyTeamName($_SESSION['teamnominee']->teamID));
		$stmt->bindParam(':littleExtra', $_SESSION['teamnominee']->littleExtra);
		$stmt->bindParam(':personalMessage', $_SESSION['teamnominee']->personalMessage);
		$stmt->bindParam(':Reason', $_SESSION['teamnominee']->Reason);
		$stmt->bindParam(':BeliefID', $_SESSION['teamnominee']->BeliefID);
		$stmt->bindParam(':dReason', $_SESSION['teamnominee']->dReason);
		if($_SESSION['teamnominee']->littleExtra == 'Yes'){
			$stmt->bindParam(':amount', $_SESSION['teamnominee']->workAward);
			// check if teamnominee is also approver
			if($AppEmpNum->AppEmpNum == $_SESSION['user']->EmpNum){
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
		$stmt->bindParam(':awardPrivate', $_SESSION['awardPrivate']->AprDate);
	
		$stmt->execute();
		$id = $db->lastInsertId();
		
		//add team members 
		if ($searchList){
			foreach ($searchList as $list){
				$stmt = $db->prepare("INSERT INTO tblnominations_teamusers(nominationsID, EmpNum) VALUES (:nominationsID, :EmpNum)");
				$stmt->bindParam(':nominationsID', $id);
				$stmt->bindParam(':EmpNum', $list->EmpNum);
				$stmt->execute();
				$teamEmailList .= getName($list->EmpNum).", ";
			}
			$teamEmailList = chop($teamEmailList,", ");
			$_SESSION['teamnominee']->teamEmailList = $teamEmailList;
		}
		
		$_SESSION['alreadydone'] = 'yes';
			
		if($_SESSION['teamnominee']->littleExtra=='Yes' && ($AppEmpNum->AppEmpNum != $_SESSION['user']->EmpNum)){
			$sendEmail = new StdClass();
			$sendEmail->subject = 'Award Notification';
			$sendEmail->Bcc = '';
			if($AppEmpNum->AppEmpNum ==''){
				// send email to super user. but using xexec for now.
				$sendEmail->emailTo = $xexecEmail;
				$sendEmail->Content = "<p>Hello </p>
										<p>".$_SESSION['user']->Fname." has nominated a team to receive 'A Little Extra' as part of an Our Heroes Award.</p>
										<p>Hoever there is no approver listed. </p>";
				$email = sendEmail($sendEmail,'T'.$id);
				//echo $sendEmail->Content;
			} else {
				// send email to approver
				if(filter_var($AppEmpNum->AppEaddress, FILTER_VALIDATE_EMAIL)){
					$sendEmail->emailTo = $AppEmpNum->AppEaddress;
					$sendEmail->Content = "<p>Dear ".$AppEmpNum->AppFname."</p>
											<p>".$_SESSION['user']->Fname." has nominated the following colleagues to receive 'A Little Extra' as part of an Our Heroes Extraordinary People, Extraordinary Effort Team Award.</p>
											<p>Team Name: ".getmyTeamName($_SESSION['teamnominee']->teamID)."<br>
											".$teamEmailList.".</p>
											<p>".$_SESSION['user']->Fname." has given the following reason for the nomination:</p>
											<p>".$_SESSION['teamnominee']->Reason."</p>
											<p>As the senior manager of the first-named colleague in this team, you are asked to review the nomination and either approve or decline the award for all nominated colleagues. 
											You may wish to discuss the award with the senior managers of the other colleagues nominated before you make your decision.</p>
											<p>To view the details of the proposed nomination and to approve or decline the award, please login to the  <a href='".HTTP_PATH."'>Our Heroes Portal</a>.</p>
											<p>If no decision is made within the next 30 days, the nomination will automatically be approved.</p>
											<p>If you need a hand to access the Our Heroes Portal or approve the award, our recognition partners, Xexec, are happy to help 0845 230 9393</p>";
					$email = sendEmail($sendEmail,'T'.$id);
					//echo $sendEmail->Content;
				} else {
					$email = "fail";
				}
			}
			$_SESSION['alreadydone'] = 'yes';
		} else {
			if(($AppEmpNum->AppEmpNum == $_SESSION['user']->EmpNum)){
				// email to approver
				if(filter_var($_SESSION['user']->Eaddress, FILTER_VALIDATE_EMAIL)){
					$sendEmail = new StdClass();
					$sendEmail->emailTo = $_SESSION['user']->Eaddress;
					$sendEmail->subject = 'Award Notification';
					$sendEmail->Bcc = '';
					$sendEmail->Content = "<p>Dear ".$_SESSION['user']->Fname."</p>
											<p>Thank you for approving 'A Little Extra' award for ".getmyTeamName($_SESSION['teamnominee']->teamID).". The details of this award are as follows:<p>
											<p>Nominator: ".$_SESSION['user']->full_name."<br>
											Team Award: ".cleanWorkAward($_SESSION['teamnominee']->workAward)."<br>Award category: ".$_SESSION['teamnominee']->BeliefID."</p>
											<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal. 
											You can also find a history of nominations in the <a href='".HTTP_PATH."'>Reports</a> section.</p>";
					$email = sendEmail($sendEmail,'T'.$id);
					$_SESSION['alreadydone'] = 'yes';
				}
			}
			// send email to teamnominee
			if ($_SESSION['teamnominee']->Volunteer !='') {
				$_SESSION['teamnominee']->NomFull_name = $_SESSION['teamnominee']->Volunteer;
			} else {
				$_SESSION['teamnominee']->NomFull_name = $_SESSION['user']->full_name();
			}
			// get team ecard
			
			if ($searchList){
				foreach ($searchList as $list){
					$_SESSION['teamnominee']->teamEmailList = $teamEmailList;
					$_SESSION['teamnominee']->Eaddress = $list->Eaddress;
					$_SESSION['teamnominee']->Fname = getFirstName($list->EmpNum);
					$_SESSION['teamnominee']->full_name = getName($list->EmpNum);
					$_SESSION['teamnominee']->content = indEcardTeamText($_SESSION['teamnominee']);
					//echo $_SESSION['teamnominee']->content;
					// test if offline
					if ($list->offline == 'YES'){
						// they in a shop so considered offline. need to fix email with all requirements. will need to get wording from Jamie
						$sendEmail = new StdClass();
						$sendEmail->emailTo = $xexecEmail;
						$sendEmail->subject = 'E-Card Award Notification';
						$sendEmail->Bcc = '';
						$sendEmail->Content = "<p>Hi</p>
												<p>".$_SESSION['user']->Fname." has nominated ".$_SESSION['teamnominee']->full_name." to receive a Thank you card as part of an Our Heroes Award.</p>
												<p>Below is the content of the card:</p>
												<p>".$_SESSION['teamnominee']->content."</p>";
						$email = sendEmail($sendEmail,'T'.$id);
						echo "offline email sent to xxexec";
					} else {
						if(filter_var($_SESSION['teamnominee']->Eaddress, FILTER_VALIDATE_EMAIL)){
							$email = sendEcardEmail($_SESSION['teamnominee']);
							echo $email;
							echo "email sent to teamnominee";
						} else {
							$email = "fail xexec";
						}
					}
					$_SESSION['alreadydone'] = 'yes';
				}
			}
		}
		echo $email;
	$_SESSION['teamnominee']->teamEmailList = $teamEmailList;
	//}
	//header("Location: nominate-team-done.php");
?>