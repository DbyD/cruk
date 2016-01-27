<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Reason
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<div class="row withPadding">
		<div class="medium-12 columns">
			<?php 
				include '../inc/config.php';
				$myaward = getNomination($_GET['id']);
				echo $myaward->Reason;
			?>
		</div>
	</div>
</div>
<script src="../js/cruk.js"></script>