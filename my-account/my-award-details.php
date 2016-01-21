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
			print_r($nomList);


foreach($nomList as $key =>$value){ 
  echo $nomList[$key]->amount;
}

if (in_object('20',$nomList)){ echo "yes"; }

		?>
			<div class="tableColumn-6 textLeft expandArrow">
				<i class="icon-icons_pointright clickAble" data-type="expand" data-id="AwardsClaimed"></i>Awards I've Claimed:
			</div>
			<div class="tableColumn-6 textRight">
				<?=count((array)$nomList)?>
			</div>
		</div>
		<div class="tableRow claimedAwardsExpanded">
			<div class="row subTitle">
				<div class="tableColumn-6 textLeft">
					&pound;20 Vouchers
				</div>
				<div class="tableColumn-6 textRight">
					3
				</div>
			</div>
		<?php
			foreach($nomList as $key =>$value){
				if($nomList[$key]->amount =='20'){
		?>
			<div class="row">
				<div class="textRight">
					<?=$nomList[$key]->DateClaimed?>
				</div>
			</div>
		<?php } 
			}?>
		</div>
		<div class="tableRow claimedAwardsExpanded">
			<div class="row subTitle">
				<div class="tableColumn-6 textLeft">
					Work-related awards:
				</div>
				<div class="tableColumn-6 textRight">
					3
				</div>
			</div>
		<?php
			foreach($nomList as $key =>$value){
				if($nomList[$key]->amount !='20'){
		?>
			<div class="row">
				<div class="tableColumn-4 textRight">
					<?=$nomList[$key]->amount?>
				</div>
				<div class="tableColumn-4 textRight">
					<?=$nomList[$key]->DateClaimed?>
				</div>
			</div>
		<?php } 
			}?>
	</div>
	<div id="TotalSpent">
		<div class="tableRow">
			<div class="tableColumn-6 textLeft expandArrow">
				<i class="icon-icons_pointright clickAble" data-type="expand" data-id="TotalSpent"></i>Total I've spent:
			</div>
			<div class="tableColumn-6 textRight">
				&pound;25
			</div>
		</div>
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
	</div>
	<div class="tableRow">
		<div class="tableColumn-6 textLeft">
			Available to spend:
		</div>
		<div class="tableColumn-6 textRight">
			<?php echo getTotalAwards($_SESSION['user']->EmpNum) ?>
		</div>
	</div>
	<div class="tableRow">
		<div class="tableColumn-6 textLeft">
			Unclaimed awards:
		</div>
		<div class="tableColumn-6 textRight">
			<?php echo getTotalAwards($_SESSION['user']->EmpNum) ?>
		</div>
	</div>
</div>
<script src="../js/cruk.js"></script>