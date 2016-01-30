<?php 
	include 'inc/config.php';
	If ($_POST['sEaddress']) {
		$sEaddress = $_POST['sEaddress'];
		$stmt = $db->prepare('SELECT * FROM tblempall WHERE Eaddress = :sEaddress');
		$stmt->execute(array('sEaddress' => $sEaddress));
		if ($user = $stmt->fetch()){
			if ($user['sPassword']){
				// send email with password.
				$sendEmail = new StdClass();
				$sendEmail->emailTo = $sEaddress;
				$sendEmail->subject = "CRUK Website password reminder";
				$sendEmail->Content = '<p>Hi '.$user['Fname'].'<p><p>Your Password is: '.$user['sPassword'].'</p>
									<p>If you would like to change your password please <a href="'.HTTP_PATH.'change_password.php">click here</a>';
				$reply = sendEmail($sendEmail,'');
				if($reply=="success"){
					$msg = "Your login information has been sent. Please check your mail box.";
				} else {
					$msg = "There seems to be a problem with our email server. Please try again later.";
				}
			} else {
				$msg = "You have not registered a password with the site. Please go back and click Register Now.";
			}
		} else {
			$msg = "User not found. Please enter the email address you registered with.";
		}
	}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="<?=HTTP_PATH?>css/foundation.css" />
<link rel="stylesheet" href="<?=HTTP_PATH?>css/styles.css">
<link rel="stylesheet" href="<?=HTTP_PATH?>css/sitespecific.css">
<script src="js/vendor/modernizr.js"></script>
<link rel="shortcut icon" href="<?=HTTP_PATH?>favicon.ico">
</head>
<body id="login">
<nav class="top-bar" data-topbar role="navigation">
	<ul class="title-area">
		<li class="name">
			<h1><a href="#"><img src="<?=HTTP_PATH?>images/Cancer-Research-UK-Logo.png" alt="Cancer Research UK" /></a></h1>
		</li>
	</ul>
	<!-- <section class="top-bar-section">
		Right Nav Section 
		<ul class="right">
			<li><a href="<?=HTTP_PATH?>logout.php">Logout</a></li>
			<li class="has-dropdown"> </li>
		</ul>
	</section>--> 
</nav>
<div class="row">
	<div id="left-column" class="large-2 columns">
		<div id="payoff" class="callout panel">
			<span class="helper"></span>
			<img src="<?=HTTP_PATH?>images/our-heroes.svg" alt="Cancer Research UK" />
		</div>
	</div>
	<div id="content" class="large-10 columns">
		<div class="row">
			<div class="large-12 columns">
				<h1 class="title">Recognition Portal</h1>
				<a href="<?=HTTP_PATH?>index.php">Home</a></p>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<div class="medium-8 columns leftnp">
					<div class="callout panel colleaguelogin">
						<div class="row">
							<form action="forgotten_password.php" method="post">
								<h1>Forgotten Password</h1>
								<p>Please enter your email address you registered with. Your password will automatically be e-mailed to you.</p>
								<?php if ($msg) echo '<p class="alert">'.$msg.'</p>'; ?>
								<div class="medium-6 columns">
									Your e-mail address:
									<input type="email" name="sEaddress">
								</div>
								<div class="medium-6 columns">
								</div>
								<div class="medium-7 columns">
								</div>
								<div class="medium-5 columns">
									<input type="submit" value="Submit">
								</div>
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