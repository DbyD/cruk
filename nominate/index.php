<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>
	<div id="content" class="large-8 large-push-2 columns">
		<div class="title">
			Nominate
		</div>
		<div class="callout panel nominateHome" id="subHome">
			<div class="image">&nbsp;</div>
		</div>
		<div class="row contentFill">
			<div class="medium-6 columns leftnp">
				<div class="callout panel white">
					<div class="nominateButton clickAble" data-type="gourl" data-url="colleague.php">
						Nominate a Colleague
					</div>
				</div>
			</div>
			<div class="medium-6 columns rightnp">
				<div class="callout panel white">
					<div class="nominateButton clickAble" data-type="gourl" data-url="team.php">
						Nominate a Team
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once('../inc/footer.php'); ?>