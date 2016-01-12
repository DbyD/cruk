<?php
	$path="../";
	include_once($path.'inc/header.php');
	createNominee($_POST['EmpNum']);
?>

<div id="content" class="large-8 large-push-2 columns">
	<form action="nominate-colleague.php" method="post" name="nominateColleague2" id="nominateColleague2">
		<div class="title">
			Nominate <i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle">Colleague</span>
			<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"><?=$nominee->full_name();?></span>
			<div class="titlePhoto">
				<img src="<?=$list['Photo']?>" alt="" onerror="this.src='<?=$path?>images/no-photo.png'"/>
			</div>
		</div>
		<div class="row selectBelief">
			Please select a Belief <span class="required">*</span>
			<i class="icon-icons_i clickAble" data-type="alert" data-url="<?=$path?>alerts/alert-belief.php"></i>
		</div>
		<div id="beliefs" class="row">
			<div class="medium-4 columns leftnp">
				<div class="callout panel white textCenter clickAble" id="belief1" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/belief1.png" alt="belief1" />
					</div>
					A Storymaker
				</div>
			</div>
			<div class="medium-4 columns">
				<div class="callout panel white textCenter clickAble" id="belief2" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/belief2.png" alt="belief2" />
					</div>
					United Strength
				</div>
			</div>
			<div class="medium-4 columns rightnp">
				<div class="callout panel white textCenter clickAble" id="belief3" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/belief3.png" alt="belief3" />
					</div>
					An Accelerator
				</div>
			</div>
			<select name="BeliefID" id="BeliefID">
				<option value=""></option>
				<option value="belief1">belief1</option>
				<option value="belief2">belief2</option>
				<option value="belief3">belief3</option>
			</select>
		</div>
		<?php
				
	?>
		<div class="callout panel white contentFill" id="nominateOptions">
			<div class="row withPadding noMargin">
				<div class="medium-12 columns">
					Personal Message <span class="required">*</span>
					<i class="icon-icons_i clickAble" data-type="alert" data-url="<?=$path?>alerts/alert-message.php"></i>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns">
					<textarea name="personalMessage" id="personalMessage" placeholder="Example: Your dedication and passion is infectious, I am proud of you. Keep up the good work."></textarea>
					<div class="charctersRemaining">
						Characters remaining: <span id="chars">200</span>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="<?=$path?>alerts/alert-little-extra.php"></i>
					Add 'A little Extra'
					<div class="hiddenTick inline smallTick">
						<input type="checkbox" value="Yes" name="littleExtra" id="littleExtra">
						<label for="littleExtra"></label>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns textRight">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="<?=$path?>alerts/alert-volunteer.php"></i>
					Nominating for a volunteer
					<div class="hiddenTick inline smallTick clickAble" data-type="popup" data-url="<?=$path?>alerts/alert-volunteer.php">
						<input type="checkbox" value="" name="volunteer" id="volunteer">
						<label for="volunteer"></label>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns textRight">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="<?=$path?>alerts/alert-private.php"></i>
					Keep this award private 
					<div class="hiddenTick inline smallTick">
						<input type="checkbox" value="Yes" name="awardPrivate" id="awardPrivate">
						<label for="awardPrivate"></label>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin buttonRow">
				<div class="medium-8 columns">
					<a href="#" class="blueButton clickAble" data-type="gourl" data-url="<?=$path?>home.php">Cancel</a>
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
