<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>

	<div id="content" class="large-8 large-push-2 columns">
		<div class="title">
			My Account
		</div>
		<div class="callout panel accountHome" id="subHome">
			<div class="image">&nbsp;</div>
		</div>
		<div class="row contentFill">
			<div class="medium-6 columns leftnp">
				<div class="callout panel white">
					<div class="awardButton clickAble" data-type="gourl" data-url="my-awards.php">
						My Awards <div class="awardStar"><i class="icon-icons_star"></i><span><?php echo getTotalAwards($_SESSION['user']->EmpNum) ?></span></div>
					</div>
				</div>
			</div>
			<div class="medium-6 columns rightnp">
				<div class="callout panel white">
					<div class="awardButton clickAble" data-type="gourl" data-url="my-nominees.php">
						My Nominees <div class="awardStar"><i class="icon-icons_star"></i><span><?php echo getTotalNominations($_SESSION['user']->EmpNum) ?></span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once('../inc/footer.php'); ?>