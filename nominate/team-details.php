<?php
	include '../inc/config.php';
?>

<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Find/Ceate Team
			<div class="small">
				Search for an existing team (e.g. 'Payroll') or for individual colleagues
			</div>
		</div>
		<div class="medium-12 columns">
			<div class="searchTeamInput">
				<form action="team-details.php" method="POST" name="searchTeam" id="searchTeam">
					<div class="medium-9 columns noPadding">
						<input type="text" name="searchTeamAuto" id="searchTeamAuto" value="" class="search" />
					</div>
					<div class="medium-3 columns noPadding">
						<div class="purpleButton clickAble" data-type="submit" data-url="searchTeam">
							Search
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<div class="row mCustomScrollbar height175 scrollBar" data-mcs-theme="dark-2">
		<form action="team-details.php" method="post" name="nominateTeamMember" id="nominateTeamMember">
			<input type="hidden" name="formName" value="nominateTeamMember">
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/photos/1453464437_AASmall.jpg" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					EmployeeA A
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/photos/1452861767_197gkt72jr0e1jpg.jpg" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					EmployeeB B
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					EmployeeC C
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempA surA
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempB surB
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempC surC
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempLina surnameA
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempLineB surnameB
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempLineC surnameC
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempAppA TempAppAsname
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
			<div class="row searchResult valign-middle">
				<div class="medium-1 columns noPadding">
					<img src="http://cruk.xexec.dev/images/no-photo.png" alt="" onerror="this.src='http://cruk.xexec.dev/images/no-photo.png'">
				</div>
				<div class="medium-4 columns">
					TempAppC TempAppCsname
				</div>
				<div class="medium-5 columns">
					TRADING REGION 2
				</div>
				<div class="medium-1 columns textRight">
					<div id="teamTick" class="circleTick inline smallTick clickAble" data-type="submit" data-url="team-details.php">
						<label for="teamTick"></label>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div id="teamMembers" class="greyBox">
	<div class="row mCustomScrollbar height120 scrollBar" data-mcs-theme="dark-2">
		<div class="row withPadding">
			<div class="medium-12 columns">
				<div class="small">
					This team currently includes
				</div>
			</div>
			<div class="medium-12 columns">
				<div class="row valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<div class="row valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<div class="row  valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<div class="row  valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<div class="row  valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<div class="row  valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<div class="row  valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
				<div class="row  valign-middle">
					<div class="medium-5 columns">
						EmployeeA A
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
					<div class="medium-4 columns">
						EmployeeB B
					</div>
					<div class="medium-1 columns">
						<i class="icon-icons_close clickAble" data-type="clear" data-id="v"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="alertTitle" class="row title smallPopupTitle">
	<div class="medium-12 columns">
		<div class="small">
			Choose an appropriate team name, then add colleagues. The team name will be visible on the Wall of Fame
		</div>
	</div>
	<div class="medium-12 columns">
		<div class="TeamInputName">
			<form action="team-details.php" method="POST" name="TeamName" id="TeamName">
				<input type="text" name="team" id="team" value="" class="" />
			</form>
		</div>
	</div>
</div>
<div id="buttonRow" class="row buttonRow">
	<div class="row searchResult noBorder valign-middle">
		<div class="medium-12 columns textRight ">
			<a href="#" class="pinkButton clickAble" data-type="submit" data-url="nominateTeamMember">Confirm</a>
		</div>
	</div>
</div>
<script src="../js/cruk.js"></script>