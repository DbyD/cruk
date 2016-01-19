<?php
	$path="../";
	include_once($path.'inc/header.php');
?>

<div id="content" class="large-8 large-push-2 columns">
	<form action="nominate-colleague-submit.php" method="post" name="nominateColleague2" id="nominateColleague2">
		<input type="hidden" name="formName" value="nominateColleague2">
		<div class="title">
			Nominate <i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle">Colleague</span>
			<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"><?=$_SESSION['nominee']->full_name();?></span>
			<div class="titlePhoto">
				<img src="<?=HTTP_PATH.$_SESSION['nominee']->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
			</div>
		</div>
		<div class="row selectBelief">
			Please select a Belief <span class="required">*</span>
			<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-belief.php"></i>
		</div>
		<div id="beliefs" class="row">
			<div class="medium-4 columns leftnp">
				<div class="callout panel white textCenter clickAble <?php if($_SESSION['nominee']->BeliefID=='belief1') echo "selectedecard"; ?>" id="belief1" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/belief1.png" alt="belief1" />
					</div>
					A Storymaker
					<span id="belief1Text" class="showbehaviour hidden">Some text goes here so we can write a lot more</span>
				</div>
			</div>
			<div class="medium-4 columns">
				<div class="callout panel white textCenter clickAble <?php if($_SESSION['nominee']->BeliefID=='belief2') echo "selectedecard"; ?>" id="belief2" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/belief2.png" alt="belief2" />
					</div>
					United Strength
					<span id="belief2Text" class="showbehaviour hidden">Some text goes here so we can write a lot more</span>
				</div>
			</div>
			<div class="medium-4 columns rightnp">
				<div class="callout panel white textCenter clickAble <?php if($_SESSION['nominee']->BeliefID=='belief3') echo "selectedecard"; ?>" id="belief3" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/belief3.png" alt="belief3" />
					</div>
					An Accelerator
					<span id="belief3Text" class="showbehaviour hidden">Some text goes here so we can write a lot more</span>
				</div>
			</div>
			<select name="BeliefID" id="BeliefID">
				<option value=""></option>
				<option <?php if($_SESSION['nominee']->BeliefID=='belief1') echo "selected"; ?> value="belief1">belief1</option>
				<option <?php if($_SESSION['nominee']->BeliefID=='belief2') echo "selected"; ?> value="belief2">belief2</option>
				<option <?php if($_SESSION['nominee']->BeliefID=='belief2') echo "selected"; ?> value="belief3">belief3</option>
			</select>
		</div>
		<?php
				
	?>
		<div class="callout panel white contentFill" id="nominateOptions">
			<div class="row withPadding noMargin">
				<div class="medium-12 columns">
					Personal Message <span class="required">*</span>
					<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-message.php"></i>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns">
					<textarea name="personalMessage" id="personalMessage" placeholder="Example: Your dedication and passion is infectious, I am proud of you. Keep up the good work."><?=$_SESSION['nominee']->personalMessage?></textarea>
					<div class="charctersRemaining">
						Characters remaining: <span id="chars">250</span>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-little-extra.php"></i>
					Add 'A Little Extra'
					<!--<div id="littleExtraTick" class="circleTick inline smallTick clickAble" data-type="popup" data-url="little-extra.php">-->
					<div id="littleExtraTick" class="hiddenTick inline smallTick clickAble" data-type="popup" data-url="little-extra.php" data-id="littleExtra">
						<input type="checkbox" value="Yes" name="littleExtra" id="littleExtra" <?php if($_SESSION['nominee']->littleExtra=='Yes') echo "checked"; ?>>
						<label for="littleExtra"></label>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns textRight">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-volunteer.php"></i>
					Nominating for a volunteer
					<div id="volunteerTick" class="circleTick inline smallTick clickAble <?php if($_SESSION['nominee']->Volunteer) echo 'circleTickChecked'; ?>" data-type="popup" data-url="volunteer.php">
						<label for="volunteer"></label>
					</div>
					<div id="volunteerName">
						<div <?php if(!$_SESSION['nominee']->Volunteer) echo 'class="hidden"'; ?> >
							<span><?=$_SESSION['nominee']->Volunteer;?></span> 
							<i class="icon-icons_close clickAble" data-type="clear"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="row withSidePadding noMargin">
				<div class="medium-12 columns textRight">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-private.php"></i>
					Keep this award private 
					<div class="hiddenTick inline smallTick">
						<input type="checkbox" value="Yes" name="awardPrivate" id="awardPrivate" <?php if($_SESSION['nominee']->awardPrivate) echo "checked"; ?>>
						<label for="awardPrivate"></label>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin buttonRow">
				<div class="medium-8 columns">
					<a href="#" class="blueButton clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>home.php">Cancel</a>
				</div>
				<div class="medium-2 columns textRight ">
					<a href="#" class="blueButton clickAble" data-type="goback">Go Back</a>
				</div>
				<div class="medium-2 columns textRight ">
					<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateColleague2">Next</a>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
	include_once($path.'inc/footer.php');
?>
			<? print_r($_SESSION['nominee']);?>
