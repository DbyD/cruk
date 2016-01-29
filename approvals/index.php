<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>
	<div id="content" class="large-8 large-push-2 columns">
		<div class="title">
			Approvals
		</div>
		<div class="callout panel approvalHome" id="subHome">
			<div class="image">&nbsp;</div>
		</div>
		<div class="row contentFill">
			<div class="medium-6 columns leftnp">
				<div class="callout panel white">
					<div class="nominateButton clickAble" data-type="gourl" data-url="pending.php">
						Pending Approvals
					</div>
				</div>
			</div>
			<div class="medium-6 columns rightnp">
				<div class="callout panel white">
					<div class="nominateButton clickAble" data-type="gourl" data-url="history.php">
						Approval History
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once('../inc/footer.php'); ?>