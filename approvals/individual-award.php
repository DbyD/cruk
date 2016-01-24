<?php include '../inc/config.php'; ?>

<div id="alertTitle" class="title">
	Approve/Decline Colleague Nomination
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<div class="textLeft">
			If approved, this colleague will be able to choose one of the following awards. Please remove options only if there’s a good reason to do so.
			<i class="icon-icons_i clickAble" data-type="subPopup" data-url="work-awards.php"></i>
		</div>
	</div>
	<form action="individual-award-update.php" method="post" name="approveAward" id="approveAward" novalidate>
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
				If declining, please enter a reason below. The reason you give will be sent to the nominator for their information. <textarea id="dReason" name="dReason" required ></textarea>
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
<div id="subPopup" class="">
	<div id="subPopupbox">
		<div class="whiteUpArrow"></div>
		<div class="textRight"><i class="icon-icons_i"></i></div>
		<h3>Go Home Early</h3>
		<p>The nominee can go home two hours early, on a day agreed with their manager</p>
		<h3>Come In Late</h3>
		<p>The nominee can come in two hours late, on a day agreed with their manager</p>
		<h3>Coffee for a week</h3>
		<p>The nominee will get coffee for a week when agreed with their manager</p>
		<h3>Parking space</h3>
		<p>The nominee will park in a dedicated parking space for a week</p>
		<div id="closealert" data-type="close" data-id="4" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<script src="../js/cruk.js"></script>