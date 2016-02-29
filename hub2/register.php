<?php 
	if($_POST["submit"])
	{
		If ($_POST["register"])
		{
			// update password and send email to activate
			$EmpNum = $_POST["EmpNum"];
			$stmt = $db->prepare('UPDATE tblempall SET sPassword = :sPassword WHERE EmpNum = :EmpNum');
			$stmt->execute(array(':EmpNum' => $EmpNum,':sPassword' => $_POST["sPassword"]));

			$sendEmail = new StdClass();
			$sendEmail->emailTo = $_POST["Eaddress"];
			$sendEmail->subject = "CRUK Website activation";
			$sendEmail->Content ='<p>Hi '.$_POST['Fname'].'<p>
							<p>Please click on the link to activate your account. Please <a href="'.HTTP_PATH.'activate.php?activate=yes&EmpNum='.$encrypt->encode($EmpNum).'">click here</a> to activate your account</p>' ;
			$reply = sendEmail($sendEmail,'');
			if($reply="success")
			{
				$msg = "<p>Thank you for your registration.</p>
						<p>A confirmation email has been sent to your CRUK email address.</p>
						<p>Please check your mailbox for an Activation email.</p>";
			} 
			else 
			{
				$msg = "There seems to be a problem with our email server. Please try again later.";
			}
			echo $msg;
		} 
		else 
		{
			If ($_POST["emailaddress"])
			{
				$EmpNum = $_POST["EmpNum"];
				$stmt = $db->prepare('UPDATE tblempall SET Eaddress = :sEaddress WHERE EmpNum = :EmpNum');
				$stmt->execute(array(':EmpNum' => $EmpNum,':sEaddress' => $_POST["sEaddress"]));
			}

			$stmt = $db->prepare("SELECT EmpNum,Eaddress,Fname,Sname,sPassword,activated FROM tblempall WHERE EmpNum = :EmpNum and eligible=1");
			$stmt->execute(array('EmpNum' => $_POST["EmpNum"]));

			if ($user = $stmt->fetch())
			{ 
				// check if has email address
				if ($user['Eaddress'] == "")
				{
					header('Location: ?register&noemail');
				} 
				else 
				{
					if ($user['sPassword'] != "" && $user['activated'] == 1)
					{
						header('Location: ?register&alreadyActivated');
					} 
					else 
					{ 
						?>
			<input type="hidden" value="yes" name="register">
			<input type="hidden" value="<?=$user['EmpNum']?>" name="EmpNum">
			<input type="hidden" value="<?=$user['Fname']?>" name="Fname">
			<input type="hidden" value="<?=$user['Eaddress']?>" name="Eaddress">
			<p>Please enter a password to be used with your account. Confirmation details will be sent to your mail box to validate your account.</p>
			<div class="medium-6 columns">
				Password:
				<input type="password" name="sPassword" id="sPassword" required/>
			</div>
			<div class="medium-6 columns"></div><div class="medium-7 columns"></div>
			<div class="medium-5 columns">
				<input type="submit" value="Submit" name="submit">
			</div>
			<?php	   
				  } 
				}
			} 
			else 
			{ 
			?>
			<p class="alert">No record found. Please try again or contact <a href="hrservicecentre@cancer">hrservicecentre@cancer</a> or the Xexec helpdesk on 020 8201 6483 for further assistance.</p>
			<p>Please enter your employee Number to register.</p>
			<div class="medium-6 columns">
				Employee Number:
				<input type="text" name="EmpNum" id="EmpNum" required/>
			</div>
			<div class="medium-6 columns"></div>
			<div class="medium-10 columns textRight">
				<input type="submit" value="Submit" name="submit">
			</div>
		<?php
			}
		}
	} 
	else 
	{ 
	} 
