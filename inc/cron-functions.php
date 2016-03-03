<?php
function autoApproveIndividualAward($id)
{
	global $db;

	//first we set the approval status as 1 in the table
	$rs = $db->prepare("UPDATE tblnominations WHERE id LIKE :id SET AprStatus = '1', AprDate = NOW()");
	$rs->execute(array(":id" => $id));

	//Add all the work awards to the nominee
	for($i=1; $i<=3; $i++)
	{
		$stmt = $db->prepare("INSERT INTO tblworknominations(nominationID, workawardsID) VALUES (:nominationID, :workawardsID)");
		$stmt->bindParam(':nominationID', $id);
		$stmt->bindParam(':workawardsID', $i);
		$stmt->execute();
	}

	//let's get all details we need for this nomination
	$nomination = $db->prepare(
		"SELECT n.BeliefID as BeliefID,
				n.personalMessage as personalMessage,
				LM.Eaddress as LMEaddress, 
				LM.Fname as LMFname, 
				CONCAT(approver.Fname, ' ', approver.Sname) as approverFullname,
				approver.Eaddress as approverEaddress, 
				approver.Fname as approverFname,
				nominator.Eaddress as nominatorEaddress,
				nominator.Fname as nominatorFname, 
				nominator.Sname as nominatorSname, 
				CONCAT(nominator.Fname, ' ', nominator.Sname) as nominatorFullname, 
				CONCAT(nominee.Fname, ' ', nominee.Sname) as nomineeFullname,
				nominee.Offline as nomineeOffline,
				nominee.Fname as nomineeFname,
				nominee.Sname as nomineeSname, 
				FROM tblnominations as n 
				JOIN tblempall as nominator ON nominator.EmpNum = n.NominatorEmpNum 
				JOIN tblempall as nominee ON nominee.EmpNum = n.NominatedEmpNum 
				JOIN tblempall as approver ON approver.EmpNum = n.ApproverEmpNum 
				JOIN tblempall as LM ON lm.EmpNum = nominee.LMEmpNum WHERE n.id LIKE :id");
	$nomination = $nomination->fetch(PDO::FETCH_OBJ);

	//now let's start sending out some emails

	//----------------------------------
	// Shoot an email to the Nominator
	//----------------------------------
	$sendEmail = new StdClass();
	$sendEmail->emailTo = $nomination->nominatorEaddress;
	$sendEmail->subject = 'Congratulations, your nomination has been approved';
	$sendEmail->Content = "<p>Dear ".$nomination->nominatorFname."</p>
							<p>Good news!</p>
							<p>Your nomination of ".$nomination->nomineeFullname." for an Our Heroes Extraordinary People, Extraordinary Effort Award has been approved by ".$nomination->approverFullname.".</p>
							<p>The Thank You certificate you prepared when nominating this award has been sent by email to ".$nomination->nomineeFullname." with details of the award.</p>
							<p>A record of all the nominations you have made and their current status can be viewed on the <a href='".HTTP_PATH."'>My Awards</a> section of the Our Heroes portal.</p>
							<p>Thank you for your nomination.</p>
							<p>Kind Regards</p>";
	$email = sendEmail($sendEmail,$id);

	//----------------------------------
	// Shoot an email to the line manager
	//----------------------------------
	$sendEmail = new StdClass();
	$sendEmail->emailTo = $nomination->LMEaddress;
	$sendEmail->subject = "Congratulations, someone in your team has been sent a 'Little Extra' award";
	$sendEmail->Content = "<p>Dear ".$nomination->LMFname."</p>
							<p>Good news!</p>
							<p>".$nomination->nomineeFullname." in your team has been given an Our Heroes Extraordinary People, Extraordinary Effort award by ".$nomination->nominatorFullname." for the ".$nomination->BeliefID." category.</p>
							<p>".$nomination->nomineeFname." was also given 'A Little Extra' as part of the award and can choose from. This was approved by ".$nomination->approverFullname.".</p>
							<p>Please congratulate ".$nomination->nomineeFname." in person and to consider other members of your team who may be suitable for a nomination on the <a href='".HTTP_PATH."'>Our Heroes</a> portal.</p>
							<p>Kind Regards</p>";

	$email = sendEmail($sendEmail,$id);

	//----------------------------------
	// Shoot an email to the approver
	//----------------------------------
	$sendEmail = new StdClass();
	$sendEmail->emailTo = $nomination->approverEaddress;
	$sendEmail->subject = "Confirmation of your approval for a 'Little Extra' award";
	$sendEmail->Content = "<p>Dear ".$nomination->approverFname."</p>
							<p>Thank you for approving 'A Little Extra' award for ".$nomination->nomineeFullname.". The details of this award are as follows:<p>
							<p>Nominator: ".$award->nominator()->full_name."<br>
							Award Options: ".$awardOptions."
							<br>Award category: ".$award->BeliefID."</p>
							<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal.</p>
							<p>Thank you</p>";
	$email = sendEmail($sendEmail,$id);

	//----------------------------------
	// Shoot an email to the nominee
	//----------------------------------

	//First let's construct the ECard
	$ecard = new StdClass();
	$ecard->Fname = $nomination->nomineeFname;
	$ecard->NomFull_name = $nomination->nominatorFullname;
	$ecard->BeliefID = $nomination->BeliefID;
	$ecard->personalMessage = $nomination->personalMessage;
	$ecard->NomFname = $nomination->nominatorFname;

	$content = indEcardExtraText($ecard);

	//If the nominee if offline, shoot an email to the administrator of xexec
	if($nomination->nomineeOffline == 'Y')
	{
		$sendEmail = new StdClass();
		$sendEmail->emailTo = $xexecEmail;
		$sendEmail->Cc = 'hillarypress@btconnect.com';
		$sendEmail->subject = 'E-Card Award Notification';
		$sendEmail->Content = "<p>Hi</p>
								<p>".$nomination->nominatorFullname." has nominated ".$nomination->nomineeFullname." to receive a Thank you card as part of an Our Heroes Award.</p>
								<p>Below is the content of the card:</p>
								<p>".$content."</p>";
		$email = sendEmail($sendEmail,$id);
	}
	else //else just shoot him an email
	{
		$ecard->subject = "Congratulations, you've been sent an Our Heroes award with 'A Little Extra'";
		$email = sendEcardEmail($ecard,$id);
	}
}

function function autoApproveTeamAward($id)
{
	global $db;

	//first we set the approval status as 1 in the table
	$rs = $db->prepare("UPDATE tblnominations_team WHERE id LIKE :id SET AprStatus = '1', AprDate = NOW()");
	$rs->execute(array(":id" => $id));

	//add award to each team member
	$award = getTeamNomination($id);

	// loop to add awards to each person
	$TeamMembers = $award->teamNominees();
	foreach ($TeamMembers as $list)
	{
		$stmt = $db->prepare("INSERT INTO tblnominations(
						awardType, NominatorEmpNum, NominatedEmpNum, nomination_teamID, Volunteer, personalMessage, ApproverEmpNum,
						littleExtra, amount, NomDate, AprDate, AprStatus, AwardClaimed, DateClaimed) 
						VALUES (:awardType, :NominatorEmpNum, :NominatedEmpNum, :nomination_teamID, :Volunteer, :personalMessage, :ApproverEmpNum, 
						:littleExtra, :amount, :NomDate, NOW(), :AprStatus, :AwardClaimed, NOW())");
		$stmt->bindParam(':awardType', $a = 2);
		$stmt->bindParam(':NominatorEmpNum', $award->NominatorEmpNum);
		$stmt->bindParam(':NominatedEmpNum', $list->EmpNum);
		$stmt->bindParam(':nomination_teamID', $award->ID);
		$stmt->bindParam(':Volunteer', $award->Volunteer);
		$stmt->bindParam(':personalMessage', $award->personalMessage);
		$stmt->bindParam(':ApproverEmpNum', $award->ApproverEmpNum);
		$stmt->bindParam(':littleExtra', $award->littleExtra);

		if($award->amount=='20pound')
		{
			$amount = 20;
		} 
		else 
		{
			$amount = 'Team Event';
		}

		$stmt->bindParam(':amount', $amount);
		$stmt->bindValue(':NomDate', $award->NomDate, PDO::PARAM_NULL);
		$stmt->bindParam(':AprStatus', $a = 1);
		$stmt->bindParam(':AwardClaimed', $a = 'Yes');
		$stmt->execute();
		
		$teamEmailList .= getName($list->EmpNum).", ";
		if(!isset($firstPerson))
		{
			$firstPerson = getName($list->EmpNum);
		}
	}

	$teamEmailList = chop($teamEmailList,", ");
	$teamEmailList = strrev(implode(strrev(' and'), explode(',', strrev($teamEmailList), 2)));
	$award->teamEmailList = $teamEmailList;
	echo $teamEmailList;
	//exit;
	
	// send email to nominator
	if($award->ApproverEmpNum != $award->NominatorEmpNum)
	{
		if(filter_var($award->nominator()->Eaddress, FILTER_VALIDATE_EMAIL))
		{
			$sendEmail = new StdClass();
			$sendEmail->emailTo = $award->nominator()->Eaddress;
			$sendEmail->subject = 'Congratulations, your nomination has been approved';
			$sendEmail->Content = "<p>Dear ".$award->nominator()->Fname."</p>
									<p>Good news!</p>
									<p>Your nomination of ".$award->teamEmailList." for an Our Heroes Extraordinary People, Extraordinary Effort Award has been approved by ".$approver_name.".</p>
									<p>The Thank You certificate you prepared when nominating this award has been sent by email to ".$award->teamEmailList." with details of the award.</p>
									<p>A record of all the nominations you have made and their current status can be viewed on the <a href='".HTTP_PATH."'>My Awards</a> section of the Our Heroes portal.</p>
									<p>Thank you for your nomination.</p>
									<p>Kind regards</p>";
			$email = sendEmail($sendEmail,'T'.$id);
			echo $sendEmail->Content;
		} 
		else 
		{
			$email = "fail";
		}
	} 

	// email to approver
	if(filter_var($approver_email, FILTER_VALIDATE_EMAIL))
	{
		$sendEmail = new StdClass();
		$sendEmail->emailTo = $approver_email;
		$sendEmail->subject = "Confirmation of your approval for a 'Little Extra' award";
		$sendEmail->Content = "<p>Dear ".$approver_fname."</p>
								<p>Thank you for approving 'A Little Extra' award for ".$award->teamEmailList.". The details of this award are as follows:<p>
								<p>Nominator: ".$award->nominator()->full_name."<br>
								Team Award: ".cleanWorkAward($award->amount)."<br>Award category: ".$award->BeliefID."</p>
								<p>Any other nominations awaiting your approval can be found in the <a href='".HTTP_PATH."'>My Approvals</a> section of the Our Heroes Portal.</p>
								<p>Thank you</p>";
		$email = sendEmail($sendEmail,'T'.$id);
	}
	
	if ($award->Volunteer !='') 
	{
		$award->NomFull_name = $award->Volunteer;
	} 
	else 
	{
		$award->NomFull_name = $award->nominator()->full_name;
	}

	$award->NomFname = $award->nominator()->Fname;
	$award->firstPerson = $firstPerson;

	//print_r($award);
	// send email to nominee
	foreach ($TeamMembers as $list)
	{
		$award->teamEmailList = $teamEmailList;
		$award->Fname = $list->Fname;
		$award->full_name = $list->Fname.' '.$list->Sname;
		
		//need to get offline...
		//$award->teamNominees()->Offline = ;
		
		//also need to send to LM
		
		$award->content = indEcardTeamExtraText($award);
		echo $award->content;

		// check if offline
		if ($award->teamNominees()->Offline == 'Y')
		{
			// they in a shop so considered offline. need to fix email with all requirements. will need to get from Jamie
			$sendEmail = new StdClass();
			$sendEmail->emailTo = $xexecEmail;
			$sendEmail->Cc = 'hillarypress@btconnect.com';
			$sendEmail->subject = 'E-Card Award Notification';
			$sendEmail->Content = "<p>Hi</p>
									<p>".$award->nominator()->full_name." has nominated ".$award->teamEmailList." to receive a Thank you card as part of an Our Heroes Award.</p>
									<p>Below is the content of the card:</p>
									<p>".$award->content."</p>";
			$email = sendEmail($sendEmail,'T'.$id);
			echo "offline email sent to xxexec";
		} 
		else 
		{
			$award->Eaddress = $list->Eaddress;
			if(filter_var($award->Eaddress, FILTER_VALIDATE_EMAIL))
			{
				$award->subject = "Congratulations, your team has been sent an Our Heroes award with 'A Little Extra'";
				$email = sendEcardEmail($award,'T'.$id);
			} 
			else 
			{
				$email = "fail";
			}
			echo $email;
		}
	}
}

/*
	Returns true if today's date is 
	divisible by 7
*/
function seventhDayCheck()
{
	$today = date('j', time());
	switch($today)
	{
		case '7':
			return true;
		break;
		case '14':
			return true;
		break;
		case '21':
			return true;
		break;
		case '28':
			return true;
		break;
		default:
			return false;
		break;
	}
}

/*
Returns true if it's the 1st of these months:
- March ( 03 )
- June ( 06 )
- September ( 09 )
- December ( 12 )
*/
function quarterCheck()
{
	$today = date('m-j', time());

	switch ($today) {
		case '03-1':
			return true;
		break;
		case '06-1'
			return true;
		break;
		case '09-1':
			return true;
		break;
		case '12-1':
			return true;
		default:
			return false;
		break;
	}
}

/*
Constructs the CC for sending emails to SU
*/
function constructCCSU()
{	
	global $db;
	$SuperUsers = $db->prepare("SELECT Eaddress as Email FROM tblempall WHERE SuperUser = 'Y'");
	$SuperUsers->execute();
	$cc = "";
	while($SuperUser = $SuperUsers->fetch(PDO::FETCH_OBJ))
	{
		$cc .= $SuperUser->Email.';';
	}

	//remove the last ;
	$cc = substr($cc, 0, -1);

	return $cc;
}
