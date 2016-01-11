<?php 
	include 'inc/dbconn.php';
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="<?=$path?>css/foundation.css" />
<link rel="stylesheet" href="<?=$path?>css/styles.css">
<link rel="stylesheet" href="<?=$path?>css/sitespecific.css">
<script src="js/vendor/modernizr.js"></script>
<link rel="shortcut icon" href="<?=$path?>favicon.ico">
</head>
<body id="login">
<nav class="top-bar" data-topbar role="navigation">
	<ul class="title-area">
		<li class="name">
			<h1><a href="#"><img src="<?=$path?>images/Cancer-Research-UK-Logo.png" alt="Cancer Research UK" /></a></h1>
		</li>
	</ul>
	<!-- <section class="top-bar-section">
		Right Nav Section 
		<ul class="right">
			<li><a href="<?=$path?>logout.php">Logout</a></li>
			<li class="has-dropdown"> </li>
		</ul>
	</section>--> 
</nav>
<div class="row">
	<div id="left-column" class="large-2 columns">
		<div id="payoff" class="callout panel">
			<span class="helper"></span>
			<img src="<?=$path?>images/our-heroes.svg" alt="Cancer Research UK" />
		</div>
	</div>
	<div id="content" class="large-10 columns">
		<div class="row">
			<div class="large-12 columns">
				<h1 class="title">Recognition Portal</h1>
				<a href="<?=$path?>index.php">home</a></p>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<div class="medium-8 columns leftnp">
					<div class="callout panel colleaguelogin">	
						<div class="row">				
							<form action="register.php" method="post" name="login" id="login">
								<h1>Register Your Details</h1>
							<?php If ($_POST["submit"]){
										If ($_POST["register"]){
											// update password and send email to activate
											$EmpNum = $_POST["EmpNum"];
											$stmt = $db->prepare('UPDATE tblempall SET sPassword = :sPassword WHERE EmpNum = :EmpNum');
											$stmt->execute(array(':EmpNum' => $EmpNum,':sPassword' => $_POST["sPassword"]));
											$subject = "CRUK Website activation";
											$emailContent =	'<p>Hi '.$_POST['Fname'].'<p>
															<p>Please click on the link to activate your account. Please <a href="<?=$path?>'.$localServer.'activate.php?activate=yes&EmpNum='.$encrypt->encode($EmpNum).'">click here</a> to activate your account</p>' ;
											$reply = sendEmail($emailContent,$_POST["Eaddress"],$subject,$Bcc);
											if($reply="success"){
												$msg = "<p>Thank you for your registration.</p>
														<p>A confirmation email has been sent to your CRUK email address.</p>
														<p>Please check your mailbox for an Activation email.</p>";
											} else {
												$msg = "There seems to be a problem with our email server. Please try again later.";
											}
											echo $msg;
										} else {
											$stmt = $db->prepare("SELECT EmpNum,Eaddress,Fname,Sname,sPassword,statusID FROM tblempall WHERE EmpNum = :EmpNum and activationID=1");
											$stmt->execute(array('EmpNum' => $_POST["EmpNum"]));
											if ($user = $stmt->fetch()){ 
												if ($user['sPassword'] != "" && $user['statusID'] == 1){
							?>
								<p>Your account has already been registered.</p>
								<p>Please <a href="<?=$path?>forgotten_password.php">click here</a> if you have forgotten your password.</p>
							<?php				} else { ?>
								<input type="hidden" value="yes" name="register">
								<input type="hidden" value="<?=$user['EmpNum']?>" name="EmpNum">
								<input type="hidden" value="<?=$user['Fname']?>" name="Fname">
								<input type="hidden" value="<?=$user['Eaddress']?>" name="Eaddress">
								<p>Please enter a password to be used with your account. Confirmation details will be sent to your mail box to validate your account.</p>
								<div class="medium-6 columns">
									Password:
									<input type="text" name="sPassword" id="sPassword" />
								</div>
								<div class="medium-6 columns"></div><div class="medium-7 columns"></div>
								<div class="medium-5 columns">
									<input type="submit" value="Submit" name="submit">
								</div>
							<?php				} 
											} else { ?>
								<p class="alert">No record found.<br>Please try again or contact your line manager for further assistance.</p>
								<p>Please enter your employee Number to register.</p>
								<div class="medium-6 columns">
									Employee Number:
									<input type="text" name="EmpNum" id="EmpNum" />
								</div>
								<div class="medium-6 columns"></div><div class="medium-7 columns"></div>
								<div class="medium-5 columns">
									<input type="submit" value="Submit" name="submit">
								</div>
							<?php			}
										}
									} else { ?>
								<p>Please enter your employee Number to register.</p>
								<div class="medium-6 columns">
									Employee Number:
									<input type="text" name="EmpNum" id="EmpNum" />
								</div>
								<div class="medium-6 columns"></div><div class="medium-7 columns"></div>
								<div class="medium-5 columns">
									<input type="submit" value="Submit" name="submit">
								</div>
							<?php	} 
											//$decryptEmpNum = decryptString($EmpNumencrypt);
											//echo $EmpNum."<br>";?>
							</form>
						</div>
					</div>
				</div>
				<div class="medium-4 columns rightnp">
				</div>
			</div>
		</div>
	</div>
</div>
<script src="js/vendor/jquery.js"></script> 
<script src="js/foundation.min.js"></script> 
<script>
	$(document).foundation();
</script>
</body>
</html>