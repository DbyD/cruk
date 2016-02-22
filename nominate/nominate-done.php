<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
			Nominate <i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle">Colleague</span>
			<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"><?=$_SESSION['nominee']->full_name();?></span>
			<div class="titlePhoto">
				<img src="<?=HTTP_PATH.$_SESSION['nominee']->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
			</div>
		</div>
	<div class="row">
		<div class="callout panel white contentFill">
			<div class="row withPadding ">
				<div class="medium-12 columns">
					<p>&nbsp;</p>
					<?php	if ($_SESSION['nominee']->Volunteer !='') {?>
					<p>Thank You for completing this award on behalf of <?=$_SESSION['nominee']->Volunteer;?>.</p>
					<?php	} else { ?>
					<p>Thank You for completing this award.</p>
					<?php	} ?>
					<?php	if($_SESSION['nominee']->littleExtra=='Yes' && ($_SESSION['nominee']->AppEmpNum != $_SESSION['user']->EmpNum)){ ?>
					<p>As you've added 'A Little Extra', your award has gone to <?=$_SESSION['nominee']->full_App_name();?> for approval.</p>
					<p>You will be notified of the result.</p>
					<?php	} elseif($_SESSION['nominee']->littleExtra=='Yes' && ($_SESSION['nominee']->AppEmpNum == $_SESSION['user']->EmpNum)){?>
					<p>As you are also the assigned Approver for this nomination, this award has automatically be approved and your Thank You Certificate has been sent to <?=$_SESSION['nominee']->full_name();?>.</p>
					<?php } else { ?>
					<p>Your Thank You Certificate has been sent to <?=$_SESSION['nominee']->full_name();?>.</p>
					<?php } ?>
					<? //print_r($_SESSION['nominee']);?>
					<p>A history of all your nominations can be viewed in the My Awards > <a href="<?=HTTP_PATH?>my-account/my-nominees.php">My Nominees</a> section.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	unset($_SESSION['nominee']);
	include_once('../inc/footer.php');
?>