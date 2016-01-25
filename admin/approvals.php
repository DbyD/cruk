<?php include_once('../inc/header.php'); ?>

<div id="content" class="large-8 large-push-2 columns MyAccount">
	<div class="title withStar">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">Admin</div> <i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Approvals</span>
		<span class="smaller">Please approve or decline the following pending awards.</span>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp fillHeight">
			<div class="callout panel fillHeight white">
				<div class="tableTitle">
					<div class="tableColumn-3">
						Nominee
					</div>
					<div class="tableColumn-3">
						Nominated by
					</div>
					<div class="tableColumn-3">
						Date
					</div>
					<div class="tableColumn-3 doubleLine">
						Category
						<div class="smaller">click to approve/decline</div>
					</div>
				</div>
				<div class="row mCustomScrollbar height555" data-mcs-theme="dark-2">
					<?php 
					// Get List for My Awards
					$nomUsers = new allApprovalsList($db);
					$nomList = $nomUsers->getAllApprovalsList();
					//print_r($nomList);
					foreach ($nomList as $list){
					?>
					<div class="tableRow">
						<div class="tableColumn-3">
							<?=getName($list->NominatedEmpNum)?>
						</div>
						<div class="tableColumn-3">
						<?php
							if ($list->Volunteer != '') {
								echo $list->Volunteer;
							} else {
								echo getName($list->NominatorEmpNum);
							}
						?>
						</div>
						<div class="tableColumn-3">
							<?=getConvertedDate($list->NomDate)?>
						</div>
						<div class="tableColumn-3">
						<?php if($list->teamID == ''){ ?>
								<div class="clickAble" data-type="popup" data-id="<?=$list->ID?>" data-url="<?=HTTP_PATH?>approvals/individual-award.php">Individual Award</div>
						<?php } else { ?>
								<div class="clickAble" data-type="popup" data-id="<?=$list->ID?>" data-url="<?=HTTP_PATH?>approvals/team-award.php">Team Award</div>
						<?php } ?>
						</div>
					</div>
					<?php	} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
