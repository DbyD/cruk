
<li class="clickAble" data-url="home.php"><i class="icon-icons_home"></i>Home</li>
<li class="clickAble" data-url="nominate.php"><i class="icon-icons_nominate"></i>Nominate</li>
<li class="clickAble" data-url="my-account.php"><i class="icon-icons_account"></i>My Account</li>
<li class="clickAble" data-url="winners-wall.php"><i class="icon-icons_winners"></i>Winners Wall</li>
<li class="clickAble" data-url="redeem.php"><i class="icon-icons_redeem"></i>Redeem</li>
<?php if($_SESSION['user']->approver() == 'YES') { ?>
<li class="clickAble" data-url="approvals.php"><i class="icon-icons_trophy"></i>Approvals</li>
<li class="clickAble" data-url="reports.php"><i class="icon-icons_report"></i>Reports</li>
<?php }
	if($_SESSION['user']->SuperUser == 'YES') { ?>
<li class="clickAble" data-url="admin"><i class="icon-icons_admin"></i>Admin</li>
<?php } ?>
