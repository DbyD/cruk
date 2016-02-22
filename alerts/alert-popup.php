<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			<i class="icon-icons_info"></i>
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<div class="row withPadding">
		<div class="medium-12 columns">
			<?php echo $_POST['error']; ?>
		</div>
	</div>
</div>
<div class="hide" id="nextUrl"><?php echo $_POST['url']; ?></div>
<script src="../js/cruk.js"></script>