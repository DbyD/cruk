<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	unset($_SESSION['alreadydone']);
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
			NNominate <i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle">Team</span>
			<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"><?=getmyTeamName($_SESSION['teamnominee']->teamID);?></span>
		</div>
	<div class="row">
		<div class="callout panel white contentFill">
			<div class="row withPadding ">
				<div class="medium-12 columns">
					<p>&nbsp;</p>
					<?php	if ($_SESSION['teamnominee']->Volunteer !='') {?>
					<p>Thank You for completing this award on behalf of <?=$_SESSION['teamnominee']->Volunteer;?>.</p>
					<?php	} else { ?>
					<p>Thank You for completing this award.</p>
					<?php	} ?>
					<?php	if($_SESSION['teamnominee']->littleExtra=='Yes' && ($_SESSION['teamnominee']->AppEmpNum != $_SESSION['user']->EmpNum)){ ?>
					<p>As you've added 'A Little Extra', your award has gone to <?=$_SESSION['teamnominee']->full_App_name;?> for approval.</p>
					<p>You will be notified of the result.</p>
					<?php	} elseif($_SESSION['teamnominee']->littleExtra=='Yes' && ($_SESSION['teamnominee']->AppEmpNum == $_SESSION['user']->EmpNum)){?>
					<p>As you are also the assigned Approver for this nomination, this award has automatically be approved and your Thank You Certificates have been sent to <?=$_SESSION['teamnominee']->teamEmailList;?>.</p>
					<?php } else { ?>
					<p>Your Thank You Certificates have been sent to <?=$_SESSION['teamnominee']->teamEmailList;?>.</p>
					<?php } ?>
					<? //print_r($_SESSION['teamnominee']);?>
					<p>A history of all your nominations can be viewed in the My Awards > <a href="<?=HTTP_PATH?>my-account/my-nominees.php">My Nominees</a> section</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	unset($_SESSION['teamnominee']);
	unset($_SESSION['TeamMembers']);
	unset($_SESSION['teamid']);
	include_once('../inc/footer.php');
?>