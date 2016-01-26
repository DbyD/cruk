<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title">
	Claim My Award
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<div class="textLeft">
			If you would like to swop your £20 for a work related award, choose from one of the following awards.
		</div>
	</div>
	<form action="claim-award-update.php" method="post" name="claimAward" id="claimAward" novalidate>
		<input type="hidden" name="ID" value="<?=$_GET['id']?>">
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
			} else {?>
			<div class="tableRow largerText">
				You do not have any work related awards available to you
			</div>
			<?php } ?>
		<div class="tableRow">
			<div class="tableColumn-12 textRight">
				<a href="#" class="pinkButton clickAble cancel" data-type="submit" data-url="claimAward" formnovalidate >claim</a>
			</div>
		</div>
	</form>
</div>
<script src="../js/cruk.js"></script>