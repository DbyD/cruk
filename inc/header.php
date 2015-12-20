<?php include 'dbconn.php'; ?>
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
<body>

<div id="alert" class="">
	<div class="alertbox">
		<div id="alertContent">
			<?php include 'alerts/my-award-details.php'; ?>
		</div>
		<div id="closealert" data-type="close" class="clickAble closealert" /><i class="icon-icons_close"></i></div>
	</div>
</div>

<nav class="top-bar hide-for-small" data-topbar role="navigation">
	<ul class="title-area">
		<li class="name">
			<h1><a href="#"><img src="images/Cancer-Research-UK-Logo.svg" alt="Cancer Research UK" /></a></h1>
		</li>
	</ul>
	<section class="top-bar-section">
		<!-- Right Nav Section -->
		<ul class="right">
			<li><a href="inc/logout.php">Logout</a></li>
			<li class="has-dropdown"> <a href="#">&nbsp;</a>
				<ul class="dropdown">
					<li><a href="#">some stuff will go here</a></li>
				</ul>
			</li>
		</ul>
	</section>
</nav>
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		<nav class="tab-bar hide-for-large-up">
			<section class="left-small">
				<a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
			</section>
			<section class="right tab-bar-section">
                <h1><img src="images/Cancer-Research-UK-Logo.png" alt="Cancer Research UK" /></h1>
            </section>
		</nav>
		<aside class="left-off-canvas-menu">
			<ul class="off-canvas-list">
				<li><?php include 'portfolio.php'; ?></li>
				<?php include 'menu.php'; ?>
			</ul>
		</aside>
		<section class="main-section">
			<div class="row">
