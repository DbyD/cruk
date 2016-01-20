<?php
	include '../inc/dbconn.php';
	// upload data and create emails
	print_r($_SESSION['nominee']);
	
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
			$stmt->bindParam(':AprDate', 'NOW()');
		}else {
			$stmt->bindParam(':AprStatus', $a = 0);
		}
	} else {
		$stmt->bindParam(':AprStatus', $a = 1);
		$stmt->bindParam(':AprDate', 'NOW()');
		$stmt->bindParam(':amount', $a = 0);
	}
    $stmt->bindParam(':awardPrivate', $_SESSION['awardPrivate']->AprDate);

    $stmt->execute();
	$id = $db->lastInsertId();
	
	if($_SESSION['nominee']->littleExtra=='Yes' && ($_SESSION['nominee']->AppEmpNum != $_SESSION['user']->EmpNum)){
		// send email to approver
		if(filter_var($_SESSION['nominee']->Eaddress, FILTER_VALIDATE_EMAIL)){
			$sendEmail = new StdClass();
			$sendEmail->emailTo = $_SESSION['nominee']->AppEaddress;
			$sendEmail->subject = 'Award Notification';
			$sendEmail->Bcc = '';
			$sendEmail->Content = "<p>Hello ".$_SESSION['nominee']->AppFname."</p>
									<p>".$_SESSION['user']->Fname." has nominated ".$_SESSION['nominee']->full_name()." to receive 'A Little Extra' as part of an Our Heroes Award.</p>
									<p>".$_SESSION['user']->Fname." has given the following reason for the nomination:</p>
									<p>".$_SESSION['nominee']->Reason."</p>
									<p>Please login to the <a href='https://ourheroes.co.uk'>Our Heroes Portal</a> to view the details of the proposed nomination and to approve or decline the award.</p>
									<p>If no decision is made within the next 30 days, the nomination will automatically be approved.</p>
									<p>The nomination code for future correspondence is: NO".$id."</p>";
			$email = sendEmail($sendEmail);
			echo $sendEmail->Content;
		} else {
			$email = "fail";
		}
	} else {
		// send email to nominee
		if(filter_var($_SESSION['nominee']->Eaddress, FILTER_VALIDATE_EMAIL)){
			$email = sendEcardEmail($_SESSION['nominee']);
		} else {
			$email = "fail";
		}
	}
	echo $email;
	header("Location: nominate-done.php");
?>