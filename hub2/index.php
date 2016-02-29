<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="../css/hub2/bootstrap/bootstrap.css" />
<link rel="stylesheet" href="../css/hub2/style.css">
<link rel="shortcut icon" href="../favicon.ico"> 
</head>
<body>
<?php require_once '../inc/config.php'; ?>

<div class="row white">
	<div class="logo"></div>
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
				  <label for="username">Username:</label>
				  <input type="text" class="form-control" name="username" id="username">
				</div>

				<div class="form-group">
				  <label for="password">Password:</label>
				  <input type="password" class="form-control" name="password" id="password">
				</div>

				<button type="submit" class="btn btn-lg signin">Login</button>
			</form>
			<p style="font-size: 12px"> By registering or signing in you agree to the <br> <b><u>Terms and Conditions</u></b></p>
		</div>
		<?php
		}
		else
		if(isset($_GET['register']) && !isset($_SESSION['user']))
		{
		?>
		<div class="col-md-2 col-md-offset-3" id="registerBox" <?php if(isset($_GET['alert'])) echo 'style="height: 600px;"'; ?>>
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
				?>
				<div class="form-group">
				  <label for="empNum">Employee Number:</label>
				  <input type="text" class="form-control" name="empNum" id="empNum">
				</div>

				<div class="form-group">
				  <label for="fname">First Name:</label>
				  <input type="text" class="form-control" name="fname" id="fname">
				</div>	

				<div class="form-group">
				  <label for="lname">Last Name:</label>
				  <input type="text" class="form-control" name="lname" id="lname">
				</div>

				<div class="form-group">
				  <label for="email">Email Address:</label>
				  <input type="text" class="form-control" name="email" id="email">
				</div>				

				<div class="form-group">
				  <label for="password">Password:</label>
				  <input type="text" class="form-control" name="password" id="password">
				</div>


				<button type="submit" class="btn btn-lg register">Register</button>
			</form>

			<p style="font-size: 12px"> By registering or signing in you agree to the <br> <b><u>Terms and Conditions</u></b></p>
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

			<p style="font-size: 12px"> By registering or signing in you agree to the <br> <b><u>Terms and Conditions</u></b></p>
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

			<button class="btn btn-lg go clickable" href="../home.php">Go!</button>
		</div>
		<?php
		}
		?>
	</div>
</div>

<div class="row">
    <ul class="_footer nav navbar-nav">
      <li><a href="#">PRIVACY</a></li>
      <li><a href="#">TERMS</a></li>
      <li><a href="#">HELP</a></li> 
      <li><a href="#">CONTACT</a></li> 
    </ul>

    <div class="branding">
  	 Powered by <b>Xexec</b> (V 3.0.9.27535)
    </div>
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="../js/jquery.validate.min.js"></script>
<script src="../js/hub2.js"></script>
</body>
</html>