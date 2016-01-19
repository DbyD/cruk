<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/sitespecific.css">
<script src="js/vendor/modernizr.js"></script>
<link rel="shortcut icon" href="favicon.ico">
</head>
<body id="login">
<nav class="top-bar" data-topbar role="navigation">
	<ul class="title-area">
		<li class="name">
			<h1><a href="#"><img src="images/Cancer-Research-UK-Logo.svg" alt="Cancer Research UK" /></a></h1>
		</li>
	</ul>
	<!-- <section class="top-bar-section">
		Right Nav Section 
		<ul class="right">
			<li><a href="logout.php">Logout</a></li>
			<li class="has-dropdown"> </li>
		</ul>
	</section>--> 
</nav>
<div class="row">
	<div id="left-column" class="large-2 columns">
		<div id="payoff" class="callout panel">
			<span class="helper"></span>
			<img src="images/our-heroes.svg" alt="Cancer Research UK" />
		</div>
	</div>
	<div id="content" class="large-10 columns">
		<div class="row">
			<div class="large-12 columns">
				<h1 class="title">Recognition Portal</h1>
				<p>We encourage everyone to show their appreciation for colleagues and celebrate success.</p>
			</div>
		</div>
		<div class="row">
			<div class="medium-12 columns">
				<div class="medium-6 columns leftnp">
					<div class="callout panel colleaguelogin">
						<div class="row">
							<form action="inc/login.php" method="post" name="login" id="login">
								<h1>Employee Login</h1>
								<p>Login below to send a 'Thank you' card or a gift to a colleague.</p>
								<?php if($_GET['alert']) echo '<p class="alert">You have entered an incorrect Username or Password</p>'; ?>
								<div class="medium-6 columns">
									Username: (Employee number)
									<input type="text" name="sUsername" autocomplete="off" />
								</div>
								<div class="medium-6 columns">
									Password:
									<input type="password" name="sPassword" autocomplete="off" />
								</div>
								<div class="medium-9 columns small">
									By logging in, you agree to abide by the Bupa Saudi Arabia<br>
									Terms and Conditions. See link below
								</div>
								<div class="medium-3 columns">
									<p><input type="submit" value="Submit"></p>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="medium-6 columns rightnp">
					<div class="callout panel firsttime">
						<div class="row">
							<form>
								<h1>First time users</h1>
								<p>If you are new to the Recognition portal, register here.</p>
								<div class="medium-6 columns LoginPadding">
									<a href="forgotten_password.php" class="blueButton">Forgot password?</a>
								</div>
								<div class="medium-6 columns LoginPadding">
									<p><a href="register.php" class="pinkButton LoginPadding">Register now</a></p>
								</div>
							</form>
						</div>
					</div>
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