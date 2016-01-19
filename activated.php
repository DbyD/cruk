<?php 
	include 'inc/dbconn.php';
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
				<a href="<?=HTTP_PATH?>index.php">home</a></p>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<div class="medium-8 columns leftnp">
					<div class="callout panel colleaguelogin">
					<?php 
					if ($_GET['status']=='done'){
						echo '<p>Thank you for activating your account.</p><p>You can now <a href="<?=HTTP_PATH?>index.php">click here </a> to log in to access the portal.</p>';
					} else {
						echo '<p>We were unable to activate your account.</p><p>Please contact the help desk on 012345678 or email: <a href="<?=HTTP_PATH?>mailto:help@xexec.com">help@xexec.com</a> to assist.</p>';
					}
					?>
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