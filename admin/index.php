<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		Admin
	</div>
	<div class="callout panel adminHome" id="subHome">
		<div class="image">
			&nbsp;
		</div>
	</div>
	<div class="row contentFill">
		<div class="medium-6 columns leftnp">
			<div class="callout panel white">
				<div class="nominateButton clickAble" data-type="gourl" data-url="approvals.php">
					Approvals
				</div>
			</div>
		</div>
		<div class="medium-6 columns rightnp">
			<div class="callout panel white">
				<div class="nominateButton clickAble" data-type="gourl" data-url="staff.php">
					Staff Data
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once('../inc/footer.php'); ?>