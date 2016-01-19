<?php include '../inc/dbconn.php'; ?>
<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			A Little Extra
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<form action="#" method="post" name="LittleExtraForm" id="LittleExtraForm">
		<div class="row withPadding">
			<div class="medium-12 columns">
				Please add a reason for giving 'A Little Extra' 
			</div>
		</div>
		<div class="row withPadding valign-middle">
			<div class="medium-12 columns">
				Reason:
				<textarea name="Reason" id="Reason"><?=$_SESSION['nominee']->Reason?></textarea>
			</div>
		</div>
		<div class="row withPadding">
			<div class="medium-12 columns textRight ">
				<a href="#" class="pinkButton clickAble" data-type="submit" data-url="LittleExtraForm">Confirm</a>
			</div>
		</div>
	</form>
</div>
<script src="../js/cruk.js"></script>
