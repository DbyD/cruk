
<li><a href="home.php"><i class="icon-icons_home"></i>Home</a></li>
<li><a href="nominate.php"><i class="icon-icons_nominate"></i>Nominate</a></li>
<li><a href="history.php"><i class="icon-icons_account"></i>My Account</a></li>
<li><a href="winners-wall.php"><i class="icon-icons_winners"></i>Winners Wall</a></li>
<li><a href="redeem.php"><i class="icon-icons_redeem"></i>Redeem</a></li>
<?php if($_SESSION['user']->approver() == 'YES') { ?>
<li><a href="approvals.php"><i class="icon-icons_trophy"></i>Approvals</a></li>
<li><a href="reports.php"><i class="icon-icons_report"></i>Reports</a></li>
<?php }
	if($_SESSION['user']->SuperUser == 'YES') { ?>
<li><a href="admin"><i class="icon-icons_admin"></i>Admin</a></li>
<?php } ?>
