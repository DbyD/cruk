<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			A Little Extra
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<form action="#" method="post" name="teamLittleExtraForm" id="teamLittleExtraForm">
	<?php //if(($_SESSION['nominee']->AppEmpNum == $_SESSION['user']->EmpNum)){ ?>
		<div class="tableRow">
			<div class="greyText textLeft">
				<p>A team event allows your nominated team to celebrate their success together. Where this isn't practical, each team member can be given a £20 voucher to redeem on an item of their choice.
				<i class="icon-icons_i clickAble blueText" data-type="subPopup"></i></p>
				Please note that the first-named person in your team list will be responsible for organising the team event.
			</div>
		</div>
		<div class="tableRow largerText">
			<div class="tableColumn-10 textLeft">
				Team event
			</div>
			<div class="tableColumn-2 textRight">
				<div class="hiddenTick inline smallTick ">
					<input type="radio" value="TeamEvent" name="workAward" id="TeamEvent" checked>
					<label for="TeamEvent" class="clickAble" data-type="clear" data-id="te"></label>
				</div>
			</div>
			<div class="tableColumn-12 textLeft" id="optout">
				Check if you would like to include yourself.
				<div class="hiddenTick inline verysmallTick ">
					<input type="checkbox" value="includeMe" name="includeMe" id="includeMe" <?php if ($_SESSION['teamnominee']->includeMe == 'includeMe'){ echo "checked"; }?>>
					<label for="includeMe"></label>
				</div>
			</div>
		</div>
		<div class="tableRow largerText">
			<div class="tableColumn-10 textLeft">
				£20 Voucher per person
			</div>
			<div class="tableColumn-2 textRight">
				<div class="hiddenTick inline smallTick ">
					<input type="radio" value="20pound" name="workAward" id="20pound" <?php if ($_SESSION['teamnominee']->workAward=='20pound') echo "checked"; ?>>
					<label for="20pound" class="clickAble" data-type="clear" data-id="20"></label>
				</div>
			</div>
		</div>
		<div class="row withPadding">
			<div class="greyText medium-12 columns">
				Please add a reason for giving 'A Little Extra' 
			</div>
		</div>
		<div class="row withSidePadding valign-middle">
			<div class="medium-12 columns">
				Reason:
				<textarea name="Reason" id="Reason" maxlength="100"><?=$_SESSION['teamnominee']->Reason?></textarea>
			</div>
		</div>
		<div class="row withPadding">
			<div class="medium-8 columns textRight">
				<?php if ($_SESSION['teamnominee']->littleExtra =='Yes') { ?>
				<a id="test" href="#" class="blueButton clickAble" data-type="clear" data-id="tlexm">Delete 'A Little Extra'</a>
				<?php } ?>
			</div>
			<div class="medium-4 columns textRight ">
				<p><a href="#" class="pinkButton clickAble" data-type="submit" data-url="teamLittleExtraForm">Confirm</a></p>
			</div>
		</div>
	</form>
</div>
<div id="subPopup" class="">
	<div id="subPopupbox">
		<div class="whiteUpArrow"></div>
		<div class="textRight"><i class="icon-icons_i"></i></div>
		<h3>Team event</h3>
		<p>The team can choose how to celebrate together. The chosen event can be expensed to the sum of £20 per head.</p>
		<div id="closealert" data-type="close" data-id="4" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<?php if ($_SESSION['teamnominee']->workAward=='20pound'){ ?>
<script>
	$("#includeMe").attr('checked', false);
	$("#optout").addClass('hide');
</script>
<?php } ?>
<script src="../js/cruk.js"></script>
