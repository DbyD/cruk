<?php
	include '../inc/config.php';
	if($_POST['award'] != '') {
		// update db
		$ID = $_POST['ID'];
		$today = date("Y-m-d H:i:s", strtotime(date ("Y-m-d H:i:s")));
		$stmt = $db->prepare("UPDATE tblnominations SET amount = :award, AwardClaimed = :AwardClaimed, DateClaimed = :DateClaimed WHERE ID = :ID");
		$stmt->bindParam(':award', $_POST['award']);
		$AwardClaimed = 'Yes';
		$stmt->bindParam(':AwardClaimed', $AwardClaimed, PDO::PARAM_STR);
		$stmt->bindValue(':DateClaimed',  $today, PDO::PARAM_STR);
		$stmt->bindParam(':ID', $ID);
		$stmt->execute();
		
		// send nominee and LM emails
		$sendEmail = getNomination($ID);
		print_r($sendEmail);
		
		if($sendEmail->amount == '20'){
			$voucher = '£'.$sendEmail->amount;
		} else {
			$voucher = $sendEmail->amount;
		}
		$sendEmail->emailTo = $sendEmail->nominee()->Eaddress;
		$sendEmail->subject = 'Award Redemption';
		$sendEmail->Content ="<p>Hello ".$sendEmail->nominee()->Fname."</p>
								<p>You have chosen to redeem you award for a ".$voucher." voucher</p>
								<p>This email serves as confirmation of the award.</p>
								<P>Your Line Manager will also recieve confirmation of the award</p>";
		if(filter_var($sendEmail->nominee()->Eaddress, FILTER_VALIDATE_EMAIL)){
			$email = sendEmail($sendEmail,$ID);
			echo $email;
		}
		
		// send LM email
		$sendEmail->emailTo = $sendEmail->lineManager()->Eaddress;
		$sendEmail->subject = 'Award Redemption';
		$sendEmail->Content ="<p>Hello ".$sendEmail->lineManager()->Fname."</p>
								<p>".$sendEmail->nominee()->full_name." has chosen to redeem thier voucher for a work related award</p>
								<p>The voucher is: ".$voucher."</p>
								<p>This email serves as confirmation of the award.</p>";
		if(filter_var($sendEmail->lineManager()->Eaddress, FILTER_VALIDATE_EMAIL)){
			$email = sendEmail($sendEmail,$ID);
			echo $email;
		}
		
		return "updated";
	}
?>