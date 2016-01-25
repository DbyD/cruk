<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Volunteer
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<form action="#" method="post" name="volunteerForm" id="volunteerForm">
		<div class="row withPadding">
			<div class="medium-12 columns">
				Please tell us if a volunteer has asked you to complete a nomination on their behalf.
			</div>
		</div>
		<div class="row withPadding valign-middle">
			<div class="medium-4 columns">
				Add Name:
			</div>
			<div class="medium-8 columns">
				<input type="text" name="volunteer" id="volunteer" value="<?=$_SESSION['nominee']->Volunteer?>" />
			</div>
		</div>
		<div class="row withPadding">
			<div class="medium-5 columns">
				<a href="#" class="blueButton clickAble" data-type="cancelPopup" data-id="volunteer">Cancel</a>
			</div>
			<div class="medium-3 columns textRight">
				<a id="testtttt" href="#" class="blueButton clickAble" data-type="clear" data-id="volunteerForm">Clear</a>
			</div>
			<div class="medium-4 columns textRight ">
				<a href="#" class="pinkButton clickAble" data-type="submit" data-url="volunteerForm">Confirm</a>
			</div>
		</div>
	</form>
</div>
<script src="../js/cruk.js"></script>
