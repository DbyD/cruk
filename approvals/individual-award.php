<?php include '../inc/dbconn.php'; ?>

<div id="alertTitle" class="title">
	Approve/Decline Colleague Nomination
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<div class="textLeft">
			If approved, this colleague will be able to choose one of the following awards. Please remove options only if there’s a good reason to do so.
		</div>
	</div>
	<form action="individual-award-update.php" method="post" name="approveAward" id="approveAward" novalidate="novalidate">
		<input type="hidden" name="ID" value="<?=$_GET['id']?>">
		<div class="tableRow largerText">
			<div class="tableColumn-6 textLeft">
				£20 Voucher
			</div>
			<div class="tableColumn-6 textRight">
				<div id="" class="circleTick inline smallTick disabled">
					<label for="volunteer"></label>
				</div>
			</div>
		</div>
		<?php // get list of work related
			$workawards = getWorkAwards();
			foreach($workawards as $list){ 
		?>
		<div class="tableRow largerText">
			<div class="tableColumn-6 textLeft">
				<?=$list->type;?>
			</div>
			<div class="tableColumn-6 textRight">
				<div class="hiddenTick inline smallTick ">
					<input type="checkbox" value="<?=$list->id;?>" name="workAward<?=$list->id;?>" id="workAward<?=$list->id;?>" checked>
					<label for="workAward<?=$list->id;?>"></label>
				</div>
			</div>
		</div>
		<?php  } ?>
		<div class="tableRow">
			<div class="tableColumn-12 textLeft">
				If declining, please enter a reason below. The reason you give will be sent to the nominator for their information.
				<textarea id="dReason" name="dReason" required ></textarea>
			</div>
		</div>
		<div class="tableRow">
			<div class="tableColumn-9 textRight">
				<a href="#" class="blueButton clickAble" data-type="submit" data-url="approveAward">Decline</a>
			</div>
			<div class="tableColumn-3 textRight">
				<a href="#" class="pinkButton clickAble cancel" data-type="submitNoValidate" data-url="approveAward" formnovalidate >Approve</a>
			</div>
		</div>
	</form>
</div>
<script src="../js/cruk.js"></script>