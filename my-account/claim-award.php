<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title">
	Claim My Award
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<div class="textLeft">
			Please confirm which 'Little Extra' gift you would like to claim below.
			<i class="icon-icons_i clickAble blueText" data-type="subPopup"></i>
		</div>
	</div>
	<form action="claim-award-update.php" method="post" name="claimAward" id="claimAward" novalidate>
		<input type="hidden" name="ID" value="<?=$_GET['id']?>">
		<div class="tableRow largerText">
			<div class="tableColumn-6 textLeft">
				£20 Voucher
			</div>
			<div class="tableColumn-6 textRight">
				<div class="hiddenTick inline smallTick ">
					<input type="radio" value="20" name="award" id="award0">
					<label for="award0"></label>
				</div>
			</div>
		</div>
		<?php // get list of work related
			$workawards = getMyWorkAwards($_GET['id']);
			if ($workawards) {
			foreach($workawards as $list){ 
		?>
		<div class="tableRow largerText">
			<div class="tableColumn-6 textLeft">
				<?=$list->type;?>
			</div>
			<div class="tableColumn-6 textRight">
				<div class="hiddenTick inline smallTick ">
					<input type="radio" value="<?=$list->type;?>" name="award" id="award<?=$list->id;?>">
					<label for="award<?=$list->id;?>"></label>
				</div>
			</div>
		</div>
		<?php  } 
			} ?>
		<div class="tableRow">
			<div class="tableColumn-12 textLeft">
				If you select a £20 voucher, this will be added to your Our Heroes account. If you select a different option, you and your Line Manager will receive confirmation of your selection via email.
			</div>
		</div>
		<div class="tableRow">
			<div class="tableColumn-12 textRight">
				<a href="#" class="pinkButton clickAble cancel" data-type="submit" data-url="claimAward" formnovalidate >claim</a>
			</div>
		</div>
	</form>
</div>
<div id="subPopup" class="">
	<div id="subPopupbox">
		<div class="whiteUpArrow UpArrowRight"></div>
		<div class="textRight"><i class="icon-icons_i"></i></div>
		<h3>Go Home Early</h3>
		<p>You can go home two hours early, on a day agreed with your manager.</p>
		<h3>Come In Late</h3>
		<p>You can come in two hours late, on a day agreed with your manager.</p>
		<h3>Take a Long Lunch</h3>
		<p>You can take a long lunch, on a day agreed with your manager.</p>
		<div id="closealert" data-type="close" data-id="4" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<script src="../js/cruk.js"></script>