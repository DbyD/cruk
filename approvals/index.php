<?php
	$path="../";
	include_once($path.'inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns MyAccount">
	<div class="title withStar">
		My Approvals <span class="smaller">Please approve or decline the following pending awards.</span>
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
					$nomUsers = new MyApprovalsList($db);
					$nomList = $nomUsers->getAllMyApprovalsList($_SESSION['user']->EmpNum);
					foreach ($nomList as $list){
					?>
					<div class="tableRow">
						<div class="tableColumn-3">
							<?=getName($list->NominatedEmpNum)?>
						</div>
						<div class="tableColumn-3">
							<?=getName($list->NominatorEmpNum)?>
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
<?php include_once($path.'inc/footer.php'); ?>
