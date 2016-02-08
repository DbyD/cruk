<?php
	include '../inc/config.php';
	unset($_SESSION['alreadydone']);
	$myaward = getTeamNomination($_GET['id']);
?>

<div id="alertTitle" class="title">
	Approve/Decline Team Nomination
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<div class="textLeft">
			<b>Award:</b>
			<?php 
				echo cleanWorkAward($myaward->amount);
			?>
			<i class="icon-icons_i clickAble blueText" data-type="subPopup"></i>
		</div>
	</div>
	<div class="tableRow">
		<div class="textLeft">
			<b>Reason provided by the Nominator:</b>
			<?php 
				echo $myaward->Reason;
			?>
		</div>
	</div>
	<div id="teamMembers" class="greyBox">
		<div class="row mCustomScrollbar height120 scrollBar" data-mcs-theme="dark-2">
			<div class="row withSidePadding">
				<div class="small-12 columns">
					<div class="small">
						This team currently includes the following colleagues.
					</div>
				</div>
				<div class="small-12 columns">
					<?php
			// add in current team members
			$TeamMembers = $myaward->teamNominees();
			//print_r($TeamMembers);
			$x = 0 ;
			// add in current team members
			if ($TeamMembers){
				foreach ($TeamMembers as $list){
					$x ++ ;
					if($x == 1){
			?>
					<div class="row withTopPadding">
						<div class="medium-6 columns noPadding">
							<?php echo $list->Fname.' '.$list->Sname; ?>
						</div>
						<?php	} else {?>
						<div class="medium-6 columns noPadding">
							<?php echo $list->Fname.' '.$list->Sname; ?>
						</div>
					</div>
					<?php	
						$x = 0 ; 
					}
				}
			}
			if($x == 1){
			?>
					<div class="medium-6 columns noPadding">
					</div>
				</div>
				<?php
			}
			$count = count($_SESSION['TeamMembers']);
			?>
			</div>
		</div>
	</div>
</div>
<form action="../approvals/individual-award-update.php" method="post" name="approveAward" id="approveAward" novalidate>
	<input type="hidden" name="ID" value="<?=$_GET['id']?>">
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
		<h3>Team event</h3>
		<p>The team can choose how to celebrate together. The chosen event can be expensed to the sum of £20 per head.</p>
		<div id="closealert" data-type="close" data-id="4" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<script src="../js/cruk.js"></script>