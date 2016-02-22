<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>
			<div id="content" class="large-8 large-push-2 columns">
				<div class="title">
					Wall of Fame <span class="smaller">See all nominees, most recent first.</span>
				</div>
				<div id="winnerswall" class="row mCustomScrollbar height605" data-mcs-theme="dark-2">
				<?php 
				if(function_exists('getAllEmployees')){
					$employees = getAllEmployees();
					if( $employees != 0 ){
						foreach ($employees as  $employee){
							$class = str_replace(' ','',$employee["BeliefID"]);
							if($employee["Type"]=='Team'){ 
				?>
					<div class="callout panel tableColumn-3 <?=$class?>">
						<div class="mouseOver" id="wallT<?php echo $employee["ID"]; ?>">
							<div class="nominateEmployeeImage">
								<i class="icon-icons_mail right sendTeamMail">
									<input type="hidden" id="sender" value="<?php echo $_SESSION['user']->EmpNum; ?>">
									<input type="hidden" id="recipientTeam" value="<?php echo $employee["ID"]; ?>">
									<input type="hidden" id="senderName" value="<?php echo getName($_SESSION['user']->EmpNum); ?>">
								</i>
								<img src="<?=HTTP_PATH?>images/winners-wall-team.png" class="<?=$class?>">
								<p><?php echo $employee["name"] ?></p>
							</div>
							<div class="content-nominate">
								<p>Belief: <?php echo $employee["BeliefID"]; ?></p>
								<p>Nominated By:<br><b><?php echo getname($employee["NominatorEmpNum"]); ?></b></p>
							</div>
							<span id="wallT<?php echo $employee["ID"]; ?>Text" class="showbehaviour hidden mCustomScrollbar height260" data-mcs-theme="dark-2">
								<?php
									echo "<b>Team Members:</b><br>";
									$TeamMembers = getThisTeamMembers($employee['ID']);
									foreach ($TeamMembers as $list){
										echo getName($list['EmpNum']).'<br>';
									}
									echo "<hr><b>Award message:</b><br>";
									echo $employee["personalMessage"];
								?>
							</span>
						</div>
					</div>
					<?php } else { ?>
					<div class="callout panel tableColumn-3 <?=$class?>">
						<div class="mouseOver" id="wall<?php echo $employee["ID"]; ?>">
							<div class="nominateEmployeeImage">
								<i class="icon-icons_mail right sendMail">
									<input type="hidden" id="sender" value="<?php echo $_SESSION['user']->EmpNum; ?>">
									<input type="hidden" id="recipient" value="<?php echo $employee["EmpNum"]; ?>">
									<input type="hidden" id="senderName" value="<?php echo getName($_SESSION['user']->EmpNum); ?>">
									<input type="hidden" id="recipientName" value="<?php echo $employee["name"]; ?>"> 
									<input type="hidden" id="Department" value="<?php echo $employee["Department"]; ?>"> 
								</i>
								<img src="<?php echo HTTP_PATH.$employee["Photo"];?>" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'">
								<div><?php echo $employee["name"].' '.$employee["Sname"]; ?><div class="small"><?php echo $employee["DirectorateInitials"]; ?></div></div>
							</div>
							<div class="content-nominate">
								<p>Belief: <?php echo $employee["BeliefID"]; ?></p>
								<p>Nominated By:<br><b><?php echo getname($employee["NominatorEmpNum"]); ?></b></p>
							</div>
							<span id="wall<?php echo $employee["ID"]; ?>Text" class="showbehaviour hidden mCustomScrollbar height260" data-mcs-theme="dark-2">
								<?php echo $employee["personalMessage"]; ?>
							</span>
						</div>
					</div>
				<?php		}	
						}
					}
				}
				// need to fix modal not what we want.
				?>
				</div>
				<a href="#" data-reveal-id="myModal" id="modalForSendMail">Click Me For A Modal</a>
				<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
					<h2 id="modalTitle">Send message</h2>
					<div class="withPadding">
						<form>
							<div class="row">
								<div class="large-12 columns">
									<label>
									<p>Click 'Send' to have the following congratulatory message delivered to your colleague by email:</p>
									<div id="messageModal" class="blueText"></div>
									</label>
								</div>
							</div>
							<input type="hidden" id="senderModal">
							<input type="hidden" id="recipientModal">
							<input type="hidden" id="DepartmentModal">
							<textarea placeholder="" id="mailToEmployee" class="hide"> </textarea>
						</form>
						<p>&nbsp;</p>
						<div class="row">
							<div class="large-12 columns">
								<button id="sendButton" class="right blueButton">Send</button>
							</div>
						</div>
					</div>
					<a class="close-reveal-modal" aria-label="Close"><i class="icon-icons_close"></i></a>
				</div>
				
				
				<a href="#" data-reveal-id="myTeamModal" id="modalForsendTeamMail">Click Me For A Modal</a>
				<div id="myTeamModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
					<h2 id="modalTitle">Send message</h2>
					<div class="withPadding">
						<form>
							<div class="row">
								<div class="large-12 columns">
									<label>
									<p>Click 'Send' to have the following congratulatory message delivered by email to each recipient of this team award:</p>
									<div id="messageTeamModal" class="blueText"></div>
									</label>
								</div>
							</div>
							<input type="hidden" id="senderTeamModal">
							<input type="hidden" id="recipientTeamModal">
						</form>
						<p>&nbsp;</p>
						<div class="row">
							<div class="large-12 columns">
								<button id="sendTeamButton" class="right blueButton">Send</button>
							</div>
						</div>
					</div>
					<a class="close-reveal-modal" aria-label="Close"><i class="icon-icons_close"></i></a>
				</div>
				
			</div>
<?php
	include_once('../inc/footer.php');
?>