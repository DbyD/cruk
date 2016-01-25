<?php
	include_once('inc/header.php');
?>
	<div id="content" class="large-8 large-push-2 columns">
		<div class="row winners-header">
			<h2>Wall of Fame</h2>
		</div>
		<?php 
			if(function_exists('getAllEmployees')){
				$employees = getAllEmployees();
				/*echo "<pre>";
				var_dump($employees);
				echo "</pre>";*/
				if( $employees != 0 ){
					echo '<div class="row">';
					foreach ($employees as  $employee):

						// Photo,Fname,Belief,NominatedEmpNum
						// echo $employee["Photo"];
						// echo $employee["Fname"];
						// echo $employee["Belief"];
						// echo $employee["EmpNum"];
						// echo $employee["NominatedEmpNum"];

						if(!file_exists($employee["Photo"])){
							$employee["Photo"] =  "images/no-photo.png";
						}

						?>
						
						<div class="small-2 large-3 columns">
							<div id="nominateEmployeeImage">
								<img src="<?php echo $employee["Photo"];?>">
								<p><?php echo $employee["name"]; ?></p>
							</div>
							<div id="content-nominate">
								<p>Belief</p>
								<p><?php echo $employee["Belief"]; ?></p>
								<p>Nominated By:</p>
								<p><?php echo $employee["NominatedEmpNum"]; ?>
									<input type="hidden" id="sender" value="<?php echo $_SESSION['user']->EmpNum ?>">
									<input type="hidden" id="recipient" value="<?php echo $employee["EmpNum"]; ?>">

									<i class="icon-icons_mail large right sendMail"></i>
								</p>
							</div>
						</div>

					<?php endforeach;
					echo "</div>";
				}
			}
		?>
		

  		<a href="#" data-reveal-id="myModal" id="modalForSendMail">Click Me For A Modal</a>

		<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		  <h2 id="modalTitle">Send message.</h2>
		 
		  <form>
			  <div class="row">
			    <div class="large-12 columns">
			      <label>Your message
			        <textarea placeholder="" id="mailToEmploye"></textarea>
			        <p class="hide error">Textarea is empty!</p>
			      </label>
			    </div>
			  </div>
			  <input type="hidden" id="senderModal">
			  <input type="hidden" id="recipientModal">
			 
			  
			</form>
			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
			<button id="sendButton" class="right">Send</button>
		</div>
	</div>
	<?php// print_r($_SESSION['user']); ?>
<?php
	include_once('inc/footer.php');
?>