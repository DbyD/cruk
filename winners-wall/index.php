<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
?>
			<div id="content" class="large-8 large-push-2 columns">
				<div class="row winners-header">
					<h2>Our Heroes Wall of Fame</h2>
				</div>
				<div id="winnerswall" class="row mCustomScrollbar height590" data-mcs-theme="dark-2">
				<?php 
				if(function_exists('getAllEmployees')){
					$employees = getAllEmployees();
					if( $employees != 0 ){
						foreach ($employees as  $employee){
							$class = str_replace(' ','',$employee["BeliefID"]);
							if(!file_exists($employee["Photo"])){
								$employee["Photo"] =  "images/no-photo.png";
							}
				?>
					<div class="callout panel tableColumn-3 <?=$class?>">
						<div class="clickAble" id="wall<?php echo $employee["ID"]; ?>" data-type="donothing">
							<div class="nominateEmployeeImage">
								<img src="<?php echo HTTP_PATH.$employee["Photo"];?>">
								<p><?php echo $employee["name"].' '.$employee["Sname"]; ?></p>
							</div>
							<div class="content-nominate">
								<p>Belief
									<input type="hidden" id="sender" value="<?php echo $_SESSION['user']->EmpNum; ?>">
									<input type="hidden" id="recipient" value="<?php echo $employee["EmpNum"]; ?>">
									<input type="hidden" id="senderName" value="<?php echo getName($_SESSION['user']->EmpNum); ?>">
									<input type="hidden" id="recipientName" value="<?php echo getName($employee["EmpNum"]); ?>"> 
									<i class="icon-icons_mail right sendMail"></i></p>
								<p><?php echo $employee["BeliefID"]; ?></p>
								<p>Nominated By:</p>
								<p><?php echo getname($employee["NominatedEmpNum"]); ?></p>
							</div>
							<span id="wall<?php echo $employee["ID"]; ?>Text" class="showbehaviour hidden"><?php echo $employee["personalMessage"]; ?></span>
						</div>
					</div>
				<?php	}
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
									 <textarea placeholder="" id="mailToEmployee" class="hide"> </textarea>
									<p id="messageError" class="hidden error">Textarea is empty!</p>
									</label>
								</div>
							</div>
							<input type="hidden" id="senderModal">
							<input type="hidden" id="recipientModal">
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
			</div>
<?php
	include_once('../inc/footer.php');
?>