<?php 
	include 'inc/config.php';
	if($_POST['email']) 
	{
		$email = $_POST['email'];
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE Eaddress = :sEaddress');
		$stmt->execute(array('sEaddress' => $email));

		if ($user = $stmt->fetch())
		{
			if ($user['sPassword'])
			{
				// send email with password.
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $email;
				$sendEmail->subject = "CRUK Website password reminder";
				$sendEmail->Content = '<p>Hi '.$user['Fname'].'<p><p>Your Password is: '.$user['sPassword'].'</p>';
				$reply = sendEmail($sendEmail);

				if($reply=="success")
				{
					header('Location: index.php?forgotten_password&success');
				} 
				else 
				{
					header('Location: index.php?forgotten_password&alert=There seems to be a problem with our mail server. Please try again later.');
				}
			} 
			else 
			{
				header('Location: index.php?forgotten_password&alert=You have not registered a password with the site. Please go back and click Register Now.');
			}
		} 
		else
		{
			header('Location: index.php?forgotten_password&alert=User not found. Please enter the email address you registered with.');
		}
	}
?>