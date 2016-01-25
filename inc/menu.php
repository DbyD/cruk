
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>home.php"><i class="icon-icons_home"></i>Home</li>
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>nominate"><i class="icon-icons_nominate"></i>Nominate</li>
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>my-account"><i class="icon-icons_account"></i>My Account</li>
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>winners-wall"><i class="icon-icons_winners"></i>Winners Wall</li>
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>redeem"><i class="icon-icons_redeem"></i>Redeem</li>
<?php if($_SESSION['user']->approver() == 'YES') { ?>
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>approvals"><i class="icon-icons_trophy"></i>Approvals</li>
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>reports"><i class="icon-icons_report"></i>Reports</li>
<?php }
	if($_SESSION['user']->SuperUser == 'YES') { ?>
<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>admin"><i class="icon-icons_admin"></i>Admin</li>
<?php } ?>
