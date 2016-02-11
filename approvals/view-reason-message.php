<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Reason / Message
		</div>
	</div>
</div>
<?php 
	include '../inc/config.php';
	$myaward = getNomination($_GET['id']);
?>
<div id="alertBody" class="alertBody">
	<div class="row withPadding">
		<div class="medium-12 columns">
			<h2>Reason</h2>
			<p><?php echo $myaward->Reason; ?></p>
		</div>
		<div class="medium-12 columns">
			<h2>Personal Message</h2>
			<p><?php echo $myaward->personalMessage; ?></p>
		</div>
		<?php if($myaward->AprStatus == 2){ ?>
		<div class="medium-12 columns">
			<h2>Decline Reason</h2>
			<p><?php echo $myaward->dReason; ?></p>
		</div>
		<?php } ?>
	</div>
</div>
<script src="../js/cruk.js"></script>