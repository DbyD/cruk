<?php
	include '../inc/config.php';
	$_SESSION['alreadydone'] = 'no';
?>

<div id="alertTitle" class="title">
	Approve/Decline Colleague Nomination
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<div class="textLeft">
			<b>Reason provided by the Nominator:</b>
			<?php 
				$myaward = getNomination($_GET['id']);
				echo $myaward->Reason;
			?>
		</div>
	</div>
	<div class="tableRow">
		<div class="greyText textLeft">
			If approved, this colleague will be able to choose one of the following awards. Please remove options only if there’s a good reason to do so.<br>
			Please note that all awards will be paid from a central budget and will not need to come out of your Department/Function budget.
			<i class="icon-icons_i clickAble blueText" data-type="subPopup"></i>
		</div>
	</div>
	<form action="../approvals/individual-award-update.php" method="post" name="approveAward" id="approveAward" novalidate>
		<input type="hidden" name="ID" value="<?=$_GET['id']?>">
		<div class="tableRow largerText">
			<div class="tableColumn-10 textLeft">
				£20 Voucher <span class="small">(Cannot remove this option)</span>
			</div>
			<div class="tableColumn-2 textRight">
				<div id="" class="circleTick inline smallTick disabled">
					<label for="Volunteer"></label>
				</div>
			</div>
		</div>
		<?php // get list of work related
			$workawards = getWorkAwards();
			foreach($workawards as $list){ 
		?>
		<div class="tableRow largerText">
			<div class="tableColumn-10 textLeft">
				<?=$list->type;?>
			</div>
			<div class="tableColumn-2 textRight">
				<div class="hiddenTick inline smallTick ">
					<input type="checkbox" value="<?=$list->id;?>" name="workAward<?=$list->id;?>" id="workAward<?=$list->id;?>" checked>
					<label for="workAward<?=$list->id;?>"></label>
				</div>
			</div>
		</div>
		<?php  } ?>
		<div class="tableRow noBorder">
			<div class="tableColumn-12 textLeft greyText">
				If declining this award, please enter a reason below. The reason you give will be sent to the nominator for their information. <textarea id="dReason" name="dReason" required ></textarea>
			</div>
		</div>
		<div class="tableRow noBorder popupLastRow">
			<div class="tableColumn-8 textRight">
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
		<h3>Take a Long Lunch</h3>
		<p>The nominee can take a long lunch, on a day agreed with their manager</p>
		<div id="closealert" data-type="close" data-id="4" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<script src="../js/cruk.js"></script>