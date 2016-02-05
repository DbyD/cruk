<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	unset($_SESSION['alreadydone']);
	unset($_SESSION['nominee']);
	$teamid =$_POST['myTeamName'];
	$_SESSION['TeamMembers'] =  getThisTeamMembers($teamid);
	$_SESSION['teamnominee']->teamID = $teamid;
?>

<div id="content" class="large-8 large-push-2 columns">
	<form action="nominate-submit.php" method="post" name="nominateColleague2" id="nominateColleague2">
		<input type="hidden" name="formName" value="nominateColleague2">
		<div class="title">
			Nominate <i class="icon-icons_thickrightarrow smalli"></i> <span class="subTitle">Team</span>
			<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle"><?=getmyTeamName($_SESSION['teamnominee']->teamID);?></span>
		</div>
		<div class="row selectBelief">
			Please select a Belief <span class="required">*</span>
			<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-belief.php"></i>
		</div>
		<div id="beliefs" class="row">
			<div class="medium-4 columns leftnp">
				<div class="callout panel white textCenter clickAble <?php if($_SESSION['teamnominee']->BeliefID=='Be Brave') echo "selectedecard"; ?>" id="Be Brave" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/be-brave.png" alt="Be Brave" />
					</div>
					<span id="Be BraveText" class="showbehaviour hidden"><p>Be Brave</p>Our heroes act with conviction and push for better results.</span>
				</div>
			</div>
			<div class="medium-4 columns">
				<div class="callout panel white textCenter clickAble <?php if($_SESSION['teamnominee']->BeliefID=='Be Sharp') echo "selectedecard"; ?>" id="Be Sharp" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/be-sharp.png" alt="Be Sharp" />
					</div>
					<span id="Be SharpText" class="showbehaviour hidden"><p>Be Sharp</p>Our heroes are smart, innovative thinkers.</span>
				</div>
			</div>
			<div class="medium-4 columns rightnp">
				<div class="callout panel white textCenter clickAble <?php if($_SESSION['teamnominee']->BeliefID=='Be United') echo "selectedecard"; ?>" id="Be United" data-type="select" data-id="beliefs">
					<div class="tickedbox">
						<i class="icon-icons_tickinbox"></i>
					</div>
					<div class="image">
						<img src="../images/be-united.png" alt="Be United" />
					</div>
					<span id="Be UnitedText" class="showbehaviour hidden"><p>Be United</p>Our heroes are outstanding team players – building strong, productive and collaborative relationships inside and outside the organisation.</span>
				</div>
			</div>
			<select name="BeliefID" id="BeliefID">
				<option value=""></option>
				<option <?php if($_SESSION['teamnominee']->BeliefID=='Be Brave') echo "selected"; ?> value="Be Brave">Be Brave</option>
				<option <?php if($_SESSION['teamnominee']->BeliefID=='Be Sharp') echo "selected"; ?> value="Be Sharp">Be Sharp</option>
				<option <?php if($_SESSION['teamnominee']->BeliefID=='Be United') echo "selected"; ?> value="Be United">Be United</option>
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
					<textarea name="personalMessage" id="personalMessage" placeholder="Example: Your dedication and passion is infectious, I am proud of you. Keep up the good work."><?=$_SESSION['teamnominee']->personalMessage?></textarea>
					<div class="charctersRemaining">
						Characters remaining: <span id="chars">250</span>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-team-little-extra.php"></i>
					Add 'A Little Extra'
					<div id="littleExtraTick" class="circleTick inline smallTick clickAble <?php if($_SESSION['teamnominee']->littleExtra=='Yes') echo 'circleTickChecked'; ?>" data-type="popup" data-url="team-little-extra.php">
						<label for="Volunteer"></label>
					</div>
					<div id="littleExtraMessage">
						<input type="hidden" value="<?php if($_SESSION['teamnominee']->littleExtra=='Yes') echo 'Yes'; ?>" name="littleExtra" id="littleExtra"> 
						<div <?php if($_SESSION['teamnominee']->littleExtra!='Yes') echo 'class="hidden"'; ?> >
							<span><?=$_SESSION['teamnominee']->Reason;?></span> 
							<i class="icon-icons_close clickAble" data-type="clear" data-id="lexm"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin">
				<div class="medium-12 columns textRight">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-volunteer.php"></i>
					Nominating for a Volunteer
					<div id="volunteerTick" class="circleTick inline smallTick clickAble <?php if($_SESSION['teamnominee']->Volunteer) echo 'circleTickChecked'; ?>" data-type="popup" data-url="volunteer.php">
						<label for="Volunteer"></label>
					</div>
					<div id="volunteerName">
						<div <?php if(!$_SESSION['teamnominee']->Volunteer) echo 'class="hidden"'; ?> >
							<span><?=$_SESSION['teamnominee']->Volunteer;?></span> 
							<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="row withSidePadding noMargin">
				<div class="medium-12 columns textRight">
					<i class="icon-icons_i clickAble" data-type="alert" data-url="alert-private.php"></i>
					Keep this award private 
					<div class="hiddenTick inline smallTick">
						<input type="checkbox" value="Yes" name="awardPrivate" id="awardPrivate" <?php if($_SESSION['teamnominee']->awardPrivate) echo "checked"; ?>>
						<label for="awardPrivate"></label>
					</div>
				</div>
			</div>
			<div class="row withPadding noMargin buttonRow">
				<div class="medium-6 columns">
					<a href="#" class="blueButton clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>home.php">Cancel</a>
				</div>
				<div class="medium-6 columns textRight">
					<a href="#" class="blueButton clickAble" data-type="goback">Go Back</a> &nbsp; 
					<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateColleague2">Submit Nomination</a>
				</div>
			</div>
		</div>
	</form>
</div>
<?php include_once('../inc/footer.php'); ?>
			<? print_r($_SESSION['teamnominee']);?>
			<? print_r($_SESSION['nominee']);?>
