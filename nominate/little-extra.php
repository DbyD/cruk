<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			A Little Extra <i class="icon-icons_i small clickAble" data-type="alert" data-url="alert-little-extra.php"></i>
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<form action="#" method="post" name="LittleExtraForm" id="LittleExtraForm">
	<?php if(($_SESSION['nominee']->AppEmpNum == $_SESSION['user']->EmpNum)){ ?>
		<div class="tableRow">
			<div class="greyText textLeft">
				<p>As you are also the assigned Approver for this nomination, this award will automatically be approved. Please remove any of the options below that you deem to be unsuitable for this colleague.</p>
				Please note that all awards will be paid from a central budget and will not need to come out of your Department/Function budget.
				<i class="icon-icons_i clickAble blueText" data-type="subPopup"></i>
			</div>
		</div>
		<div class="tableRow largerText">
			<div class="tableColumn-10 textLeft">
				£20 Voucher <span class="small">(Cannot remove this option)</span>
			</div>
			<div class="tableColumn-2 textRight">
				<div id="" class="circleTick inline smallTick disabled circleTickChecked">
					<label for="20pound"></label>
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
		<?php  } 
		} ?>
		<div class="row withPadding">
			<div class="greyText medium-12 columns">
				Please add a reason for giving 'A Little Extra' 
			</div>
		</div>
		<div class="row withSidePadding valign-middle">
			<div class="medium-12 columns">
				Reason:
				<textarea name="Reason" id="Reason"><?=$_SESSION['nominee']->Reason?></textarea>
			</div>
		</div>
		<div class="row withPadding">
			<div class="medium-8 columns textRight">
				<?php if ($_SESSION['nominee']->littleExtra =='Yes') { ?>
				<a id="test" href="#" class="blueButton clickAble" data-type="clear" data-id="lexm">Delete 'A Little Extra'</a>
				<?php } ?>
			</div>
			<div class="medium-4 columns textRight ">
				<p><a href="#" class="pinkButton clickAble" data-type="submit" data-url="LittleExtraForm">Confirm</a></p>
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
