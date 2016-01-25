<?php include '../inc/config.php'; ?>
<div id="alertTitle" class="title">
	My Award Details
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<div class="tableColumn-6 textLeft">
			Awards I've recieved:
		</div>
		<div class="tableColumn-6 textRight">
			<?php echo getTotalAwards($_SESSION['user']->EmpNum) ?>
		</div>
	</div>
	<div id="AwardsClaimed">
		<div class="tableRow">
		<?php
			// get list of all awards claimed
			$nomUsers = new claimedAwardsList($db);
			$nomList = $nomUsers->getAllclaimedAwardsList($_SESSION['user']->EmpNum);
			//print_r($nomList);
			$numberPound = 0;
			$numberWork = 0;
			foreach($nomList as $list){ 
				if( $nomList->amount == 20){
					$numberPound ++;
				} else {
					$numberWork ++ ;
				}
			}
		?>
			<div class="tableColumn-6 textLeft expandArrow">
				<?php if ($numberPound > 0 || $numberWork > 0) { ?>
				<i class="icon-icons_pointright clickAble" data-type="expandArrow" data-id="AwardsClaimed"></i>
				<?php } ?>
				Awards I've Claimed:
			</div>
			<div class="tableColumn-6 textRight">
				<?=$numberPound+$numberWork?>
			</div>
		</div>
		<?php if ($numberPound > 0 || $numberWork > 0){ ?>
		<div class="tableRow claimedAwardsExpanded">
		<?php	if ($numberPound > 0){ ?>
			<div class="row subTitle">
				<div class="tableColumn-6 textLeft">
					&pound;20 Vouchers
				</div>
				<div class="tableColumn-6 textRight">
				<?=$numberPound?>
				</div>
			</div>
				<?php
					// count number
					foreach($nomList as $list){
						if($list->amount =='20'){
				?>
			<div class="row">
				<div class="textRight">
					<?=getConvertedDate($list->DateClaimed)?>
				</div>
			</div>
		<?php 			} 
					}
				}
				if ($numberWork > 0){
		?>
			<div class="row subTitle">
				<div class="tableColumn-6 textLeft">
					Work-related awards
				</div>
				<div class="tableColumn-6 textRight">
				<?=$numberWork?>
				</div>
			</div>
				<?php
					foreach($nomList as $list){
						if($list->amount !='20'){
				?>
			<div class="row">
				<div class="tableColumn-7 textRight">
					<?=$list->amount?>
				</div>
				<div class="tableColumn-5 textRight">
					<?=getConvertedDate($list->DateClaimed)?>
				</div>
			</div>
		<?php 			} 
					}
				} ?>
		</div>
		<?php } ?>
	</div>
	<?php
		// get list of redeptions
		// get list of all awards claimed
		//$nomUsers = new claimedRedemptionList($db);
		//$nomList = $nomUsers->getAllclaimedRedemptionsList($_SESSION['user']->EmpNum);
			//print_r($nomList);
		$numberRedeptions = 0;
	?>
	<div id="TotalSpent">
		<div class="tableRow">
			<div class="tableColumn-6 textLeft expandArrow">
				<?php if ($numberRedeptions > 0) { ?>
				<i class="icon-icons_pointright clickAble" data-type="expandArrow" data-id="TotalSpent"></i>
				<?php } ?>
				Total I've spent:
			</div>
			<div class="tableColumn-6 textRight">
				&pound;<?=$numberRedeptions?>
			</div>
		</div>
		<?php if ($numberRedeptions > 0) { ?>
		<div class="tableRow claimedAwardsExpanded">
			<div class="row">
				<div class="tableColumn-4 textRight">
					18 September 2015
				</div>
				<div class="tableColumn-4 textRight">
					&pound;20
				</div>
				<div class="tableColumn-4 textRight">
					John Lewis
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	
	<div class="tableRow">
		<div class="tableColumn-6 textLeft">
			Available to spend:
		</div>
		<div class="tableColumn-6 textRight">
			<?php
				// need to get correct balance. for now im just going to calculate positive. Need to calculate negative once redeem is done.
				$positiveBalance = getTotalUnclaimedAwards($_SESSION['user']->EmpNum) * 20;
				echo '£'.$positiveBalance;
			?>
		</div>
	</div>
	<div class="tableRow">
		<div class="tableColumn-6 textLeft">
			Unclaimed awards:
		</div>
		<div class="tableColumn-6 textRight">
			<?php echo getTotalUnclaimedAwards($_SESSION['user']->EmpNum) ?>
		</div>
	</div>
</div>
<script src="../js/cruk.js"></script>