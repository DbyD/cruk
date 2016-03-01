<?php
include 'inc/config.php';

var_dump($_POST);

/*
	Sends out the activation email and redirects to success
*/
function sendActivation($email, $EmpNum)
{
	global $encrypt;

	$sendEmail = new StdClass();
	$sendEmail->emailTo = $email;
	$sendEmail->subject = "CRUK Website activation";
	$sendEmail->Content ='<p>Hi,<p>
					<p>Please click on the link to activate your account. Please <a href="'.HTTP_PATH.'activate.php?activate=yes&EmpNum='.$encrypt->encode($EmpNum).'">click here</a> to activate your account</p>' ;
	$reply = sendEmail($sendEmail,'');

	if($reply == "success")
	{
		header('Location: index.php?register&success');
	} 
	else 
	{
		header('Location: index.php?register&alert=There seems to be a problem with our email server. Please try again later.');
	}
}

if($_POST["empNum"] && isset($_POST['password']))
{
	//first let's check if the user has an email attached
	$EmpNum = $_POST["empNum"];
	$password = $_POST['password'];

	$stmt = $db->prepare("SELECT * FROM tblempall WHERE EmpNum = :EmpNum and eligible=1");
	$stmt->execute(array('EmpNum' => $EmpNum));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
	
	if ($user = $stmt->fetch())
	{ 
		//check if the user is already activated
		if ($user->sPassword != "" && $user->activated == 1)
		{
			header('Location: index.php?register&notactivated');
		}
	} 
	else //employee not found
	{ 
		header('Location: index.php?register&notfound');
	}

	if($user->Eaddress == "")
	{
		echo "Redirecting to fill in email...";
		// update password
		$stmt = $db->prepare('UPDATE tblempall SET sPassword = :sPassword WHERE EmpNum = :EmpNum');
		$stmt->execute(array(':EmpNum' => $EmpNum,':sPassword' => $password));

		header('Location: index.php?register&req_email&empNum='.$EmpNum);
	}
	else
	{
		echo "Sending activation email";

		// update password and send email to activate
		$stmt = $db->prepare('UPDATE tblempall SET sPassword = :sPassword WHERE EmpNum = :EmpNum');
		$stmt->execute(array(':EmpNum' => $EmpNum,':sPassword' => $password));

		sendActivation($user->Eaddress, $EmpNum);
	}
} 
else 
if(isset($_POST['email']) && isset($_POST['empNum']))
{
	// update the email and send email to activate
	$stmt = $db->prepare('UPDATE tblempall SET Eaddress = :email WHERE EmpNum = :EmpNum');
	$stmt->execute(array(':EmpNum' => $EmpNum,':email' => $_POST['email']));

	echo "Sending activation 2";
	sendActivation($_POST['email'], $_POST['empNum']);
}

