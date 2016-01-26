<<<<<<< HEAD
=======

>>>>>>> origin/master
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="<?=HTTP_PATH?>css/foundation.css" />
<link rel="stylesheet" href="<?=HTTP_PATH?>css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="<?=HTTP_PATH?>css/smoothness/jquery-ui-1.8.2.custom.css" /> 
<link rel="stylesheet" href="<?=HTTP_PATH?>css/styles.css">
<link rel="stylesheet" href="<?=HTTP_PATH?>css/sitespecific.css">
<link rel="stylesheet" href="<?=HTTP_PATH?>css/foundation-icons.css">
<script src="<?=HTTP_PATH?>js/vendor/modernizr.js"></script>
<link rel="shortcut icon" href="<?=HTTP_PATH?>favicon.ico"> 
</head>
<body>
	<!--POPUP-->
<div id="popup1" class="">
	<div id="popupbox1">
		<div id="popupContent1"></div>
		<div id="closepopup1" data-type="close" data-id="1" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<div id="ecardPopup" class="">
	<div id="ecardbox">
		<div id="popupEcard"></div>
		<div id="closeEcard" data-type="close" data-id="2" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<div id="alert" class="">
	<div id="alertbox">
		<div id="alertContent"></div>
		<div id="closealert" data-type="close" data-id="3" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>


<nav class="top-bar hide-for-small" data-topbar role="navigation">
	<ul class="title-area">
		<li class="name">
			<h1><a href="<?=HTTP_PATH?>home.php"><img src="<?=HTTP_PATH?>images/Cancer-Research-UK-Logo.svg" alt="Cancer Research UK" /></a></h1>
		</li>
	</ul>
	<section class="top-bar-section">
		<!-- Right Nav Section -->
		<ul class="right">
			<li><a href="<?=HTTP_PATH?>inc/logout.php">Logout</a></li>
			<!--<li class="has-dropdown"> <a href="#">&nbsp;</a>
				<ul class="dropdown">
					<li><a href="#">some stuff will go here</a></li>
				</ul>
			</li>-->
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
                <h1><img src="<?=HTTP_PATH?>images/Cancer-Research-UK-Logo.svg" alt="Cancer Research UK" /></h1>
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
