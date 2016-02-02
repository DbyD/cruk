<?php
					if ($_GET['searchTeamAuto']){
						$search = $_GET['searchTeamAuto'];
						$searchUsers = new searchUsers($db);
						$searchList = $searchUsers->getAllSearch($search);
						$x = 0 ;
						if ($searchList){
							foreach ($searchList as $list){
								$x = $x + 1 ;
				?>
			<div class="row searchResult valign-middle">
				<div class="medium-2 columns">
					<img src="<?=HTTP_PATH.$list->Photo?>" alt="" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png'"/>
				</div>
				<div class="medium-4 columns">
					<?php echo $list->Fname.' '.$list->Sname; ?>
				</div>
				<div class="medium-5 columns">
					<?php echo $list->Team; ?>
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<?php
							}
						} else {
						?>
			<div class="row searchResult valign-middle">
				<div class="medium-12 columns">
					<p>Sorry no results matching your search. Please try again.</p>
				</div>
			</div>
			<?php
						}
					} else { ?>
			<div class="row searchResult valign-middle">
				<div class="medium-12 columns">
					<p>Please enter the name of the colleague you would like to nominate in the Search box above.</p>
				</div>
			</div>
			<?php } ?>