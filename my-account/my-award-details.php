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
			$awards = new claimedAwardsList($db);
			$nomList = $awards->getAllclaimedAwardsList($_SESSION['user']->EmpNum);
			//print_r($nomList);
			$numberPound = 0;
			$numberWork = 0;
			//print_r($nomList);
			foreach($nomList as $list){
				if( $list->amount == 20){
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
		<div class="tableRow claimedAwardsExpanded hide">
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
							$amountEarned += $list->amount;
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
		$redeemList = $awards->getAllredeemedList($_SESSION['user']->EmpNum);
		//print_r($redeemList);
		//$totalRedemtions = count($redeemList);
		foreach($redeemList as $list){
			$totalRedemtions += $list->totalPrice;
		}
	?>
	<div id="TotalSpent">
		<div class="tableRow">
			<div class="tableColumn-6 textLeft expandArrow">
				<?php if ($totalRedemtions > 0) { ?>
				<i class="icon-icons_pointright clickAble" data-type="expandArrow" data-id="TotalSpent"></i>
				<?php } ?>
				Total I've spent:
			</div>
			<div class="tableColumn-6 textRight">
				&pound;<?=$totalRedemtions?>
			</div>
		</div>
		<?php if ($totalRedemtions > 0) { ?>
		<div class="tableRow claimedAwardsExpanded hide">
				<?php
					foreach($redeemList as $list){
				?>
			<div class="row">
				<div class="tableColumn-4 textRight">
					<?=getConvertedDate($list->DateClaimed)?>
				</div>
				<div class="tableColumn-3 textRight">
					<?php echo '£'.$list->totalPrice?>
				</div>
				<div class="tableColumn-5 textRight">
					<?php
					$basket = getBasketByOrder($list->id);
					//print_r($basket);
					foreach ($basket as $pr_b){	
						$pr_info = getProductByID( $pr_b["prID"] );
						echo $pr_info['aTitle'].' - £'.$pr_b['aPrice'].'<br>';
					}
					?>
				</div>
			</div>
		<?php	} ?>
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
				$positiveBalance = $amountEarned - $totalRedemtions;
				//getTotalUnclaimedAwards($_SESSION['user']->EmpNum) * 20;
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