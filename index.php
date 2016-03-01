<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="css/hub2/bootstrap/bootstrap.css" />
<link rel="stylesheet" href="css/hub2/style.css">
<link rel="shortcut icon" href="favicon.ico"> 
</head>
<body class="index">
<?php require_once 'inc/config.php'; ?>

<div class="row white">
	<div class="logo clickable" href="/"></div>
</div>

<div class="container bigImage">
	<div class="row">
		<?php 
		if(isset($_GET['login']) && !isset($_SESSION['user']))
		{
			//show the login box
		?>
		<div class="col-md-2 col-md-offset-3" id="loginBox" <?php if(isset($_GET['alert'])) echo 'style="height: 400px;"'; ?>>
			<p>Sign In</p>
			<form method="POST" action="login.php">
				<?php 
				if(isset($_GET['alert']))
				{
					echo '
						<div class="alert alert-danger">
						  <strong>'.$_GET['alert'].'</strong> 
						</div>
					';
				}
				?>
				<div class="form-group">
				  <label for="username">Username (employee number or email address)</label>
				  <input type="text" class="form-control" name="username" id="username">
				</div>

				<div class="form-group">
				  <label for="password">Password:</label>
				  <input type="password" class="form-control" name="password" id="password">
				</div>

				<button type="submit" class="btn btn-lg signin">Sign In</button>
			</form>
			<div class="col-md-6 noPadding"><a href="?register" class="signRegister">Register</a></div>
			<div class="col-md-6 noPadding"><a href="?forgot" class="signRegister">Forgot Password</a></div>
			<p style="font-size: 12px"> By registering or signing in you agree to the <br> <b><u><a href="terms-conditions.php" target="_default">Terms and Conditions</a></u></b></p>
		</div>
		<?php
		}
		else
		if(isset($_GET['register']) && !isset($_SESSION['user']))
		{
		?>
		<div class="col-md-2 col-md-offset-3" id="registerBox" <?php if(isset($_GET['alert'])) echo 'style="height: 460px;"'; if(isset($_GET['success']) || isset($_GET['notfound']) || isset($_GET['activated']) 
		|| isset($_GET['notactivated'])) echo 'style="height: 290px;"'; ?>>
			<p>Register</p>
			<form method="POST" action="register.php">
				<?php 
				if(isset($_GET['alert']))
				{
					echo '
						<div class="alert alert-danger">
						  <strong>'.$_GET['alert'].'</strong> 
						</div>
					';
				}
				else
				if(isset($_GET['success']))
				{
					echo '
						<div class="alert alert-success">
						  Thank you for your registration. <br>
						  A confirmation email has been sent to your email address. (If you do not have a CRUK email address, the email will have been sent to the address you entered on registration).<br>
						  <strong>Please check your mailbox for an Activation email.</strong>
						</div>
					';
				}
				else
				if(isset($_GET['notfound']))
				{
					echo '
						<div class="alert alert-danger">
						No record found. Please try again or contact <a href="hrservicecentre@cancer">hrservicecentre@cancer</a> or the Xexec helpdesk on 020 8201 6483 for further assistance.</p>
						</div>
					';
				}
				else
				if(isset($_GET['activated']))
				{
					echo '
						<div class="alert alert-success">
						  Thank you for activating your account.<br>
						  You can now <a href="'.HTTP_PATH.'index.php">click here </a> to log in to access the portal
						</div>
					';
					
				}
				else
				if(isset($_GET['notactivated']))
				{
					echo '
						<div class="alert alert-danger">
						 We were unable to activate your account. Please contact the help desk on 012345678 or email: <a href="mailto:help@xexec.com">help@xexec.com</a> to assist.
						</div>
					';
					
				}

				if(!isset($_GET['req_email']))
				{
				?>

				<div class="form-group" <?php if(isset($_GET['success']) || isset($_GET['notfound']) || isset($_GET['activated']) || isset($_GET['notactivated'])) echo 'style="display:none;"';?>>
				  <label for="empNum">Employee Number:</label>
				  <input type="text" class="form-control" name="empNum" id="empNum">
				</div>			

				<div class="form-group" <?php if(isset($_GET['success']) || isset($_GET['notfound']) || isset($_GET['activated']) || isset($_GET['notactivated'])) echo 'style="display:none;"';?>>
				  <label for="password">Password:</label>
				  <input type="password" class="form-control" name="password" id="password">
				</div>

				<div class="form-group" <?php if(isset($_GET['success']) || isset($_GET['notfound']) || isset($_GET['activated']) || isset($_GET['notactivated'])) echo 'style="display:none;"';?>>
				  <label for="password">Confirm Password:</label>
				  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
				</div>

				<button type="submit" class="btn btn-lg register" <?php if(isset($_GET['success']) || isset($_GET['notfound']) || isset($_GET['activated']) || isset($_GET['notactivated'])) echo 'style="display:none;"';?>>Register</button>

				<?php
				}
				else
				if(isset($_GET['req_email']))
				{ 
				?>
				<div class="alert alert-info">
						You do not have an email address in the system. Please fill in the field with your email address and press continue.
				</div>

				<div class="form-group">
				  <label for="email">Email Address:</label>
				  <input type="text" class="form-control" name="email" id="email">
				  <input type="hidden" name="empNum" id="empNum" value="<?=$_GET['empNum']?>"/>
				</div>	

				<button type="submit" class="btn btn-lg register">Continue</button>

				<?php 
				}
				?>

			</form>

			<p style="font-size: 12px" > By registering or signing in you agree to the <br> <b><u><a href="terms-conditions.php" target="_default">Terms and Conditions</a></u></b></p>
		</div>
		<?php
		}
		else
		if(!isset($_SESSION['user'])) 
		{
		//display the login / register box
		?>
		<div class="col-md-2 col-md-offset-3" id="optionBox">
			<p>Welcome to the Cancer Research UK <br> Benefits and Recognition portals</p>

			<button class="btn btn-lg register clickable" href="?register">Register</button>
			<button class="btn btn-lg signin clickable" href="?login">Sign In</button>

			<p style="font-size: 12px"> By registering or signing in you agree to the <br> <b><u><a href="terms-conditions.php" target="_default">Terms and Conditions</a></u></b></p>
		</div>
		<?php
		}
		else
		{
		//display the 2 boxes
		?>
		<div class="col-md-2 col-md-offset-3" id="discountsBox">
			<p>Discounts &amp; Benefits</p>

			<div class="image"></div>
			<?php 
				$secret = '49%wAjqQYHF5v(S@';
				//prepare signature
				$signature = md5(date("YmdHis").'|'.$_SESSION['user']->Eaddress.'|'.$secret);
			?>
			<button class="btn btn-lg go clickable" href="https://cruk3.xexec.com/sso/simple?id=<?php echo $_SESSION['user']->Eaddress; ?>&date=<?php echo date("YmdHis"); ?>&sig=<?php echo $signature; ?>">Go!</button>
		</div>

		<div class="col-md-2" id="heroesBox">
			<p>Colleague Recognition Portal</p>

			<div class="image"></div>

			<button class="btn btn-lg go clickable" href="home.php">Go!</button>
		</div>
		<?php
		}
		?>
	</div>
</div>

<div class="row loginfooter">
<!--    <ul class="_footer nav navbar-nav">
      <li><a href="#">PRIVACY</a></li>
      <li><a href="#">TERMS</a></li>
      <li><a href="#">HELP</a></li> 
      <li><a href="#">CONTACT</a></li> 
    </ul> -->

    <div class="branding">
  		&copy; Xexec 2016
    </div>
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/hub2.js"></script>
</body>
</html>