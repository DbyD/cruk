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
		//print_r($sendEmail);
		
		 switch ($sendEmail->amount) {
            case 'Go Home Early':
                $voucher = 'vouchers_ghe.jpg';
                break;
            case 'Come in Late':
                $voucher = 'vouchers_cil.jpg';
                break;
            case 'Take a Long Lunch':
                $voucher = 'vouchers_tall.jpg';
                break;
        }
		
		if($sendEmail->amount != '20'){
			$sendEmail->emailTo = $sendEmail->nominee()->Eaddress;
			$sendEmail->subject = 'Award Redemption';
			$sendEmail->Content ='<p>Dear '.$sendEmail->nominee()->Fname.'</p>
									<p>You have chosen to redeem your Our Heroes Extraordinary People, Extraordinary Effort award for the following voucher.</p>
									<p><img src="'.HTTP_PATH.'images/emails/'.$voucher.'" alt="'.$sendEmail->amount.'"></p>
									<p>Thank you once again.</p>';
			if(filter_var($sendEmail->nominee()->Eaddress, FILTER_VALIDATE_EMAIL)){
				$email = sendEmail($sendEmail,$ID);
				echo $email;
			}
			
			// send LM and Shop Manger email 
			$sendEmail->emailTo = $sendEmail->lineManager()->Eaddress;
			$sendEmail->subject = 'Award Redemption';
			if($sendEmail->nominee()->Offline != 'Y' || $sendEmail->nominee()->JobTitle == 'Shop Mgr'){
				//if online  LM only
				$sendEmail->Content ='<p>Dear '.$sendEmail->lineManager()->Fname.'</p>
										<p>'.$sendEmail->nominee()->full_name.' has chosen to redeem their Our Heroes Extraordinary People, Extraordinary Effort award for a 
										'. $sendEmail->amount.' voucher.</p>
										<p>They have been asked to discuss arrangements for this award with you.</p>
										<p>Kind regards</p>';
				if(filter_var($sendEmail->lineManager()->Eaddress, FILTER_VALIDATE_EMAIL)){
					$email = sendEmail($sendEmail,$ID);
					echo $email;
				}
			} else {
				// else if offline email LM
				// if in a shop
				if($sendEmail->nominee()->Shop != ''){
					$sendEmail->Content ='<p>Dear '.$sendEmail->lineManager()->Fname.'</p>
											<p>'.$sendEmail->nominee()->full_name.' has chosen to redeem their Our Heroes Extraordinary People, Extraordinary Effort award for a 
											'. $sendEmail->amount.' voucher. This email serves as confirmation of the award.</p>
											<p>Notification of their award has also been sent to their Shop Manager with whom they must discuss arrangements for the award.</p>
											<p>Kind regards</p>';
					if(filter_var($sendEmail->lineManager()->Eaddress, FILTER_VALIDATE_EMAIL)){
						$email = sendEmail($sendEmail,$ID);
						echo $email;
					}
					// email shop manager
					$sendEmail->emailTo = $sendEmail->shopManager()->Eaddress;
					$sendEmail->Content ='<p>Dear '.$sendEmail->shopManager()->Fname.'</p>
											<p>'.$sendEmail->nominee()->full_name.' has chosen to redeem their Our Heroes Extraordinary People, Extraordinary Effort award for a 
											'. $sendEmail->amount.' voucher. This email serves as confirmation of the award.</p>
											<p>They have been asked to discuss arrangements for this award with you.</p>
											<p>Kind regards</p>';
					if(filter_var($sendEmail->shopManager()->Eaddress, FILTER_VALIDATE_EMAIL)){
						$email = sendEmail($sendEmail,$ID);
						echo $email;
					}
				} else {
					//if offline but only have a  LM only
					$sendEmail->Content ='<p>Dear '.$sendEmail->lineManager()->Fname.'</p>
											<p>'.$sendEmail->nominee()->full_name.' has chosen to redeem their Our Heroes Extraordinary People, Extraordinary Effort award for a 
											'. $sendEmail->amount.' voucher.</p>
											<p>They have been asked to discuss arrangements for this award with you.</p>
											<p>Kind regards</p>';
					if(filter_var($sendEmail->lineManager()->Eaddress, FILTER_VALIDATE_EMAIL)){
						$email = sendEmail($sendEmail,$ID);
						echo $email;
					}
				}
				
			}
			
		}
		
		return "updated";
	}
?>