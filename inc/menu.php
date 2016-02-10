<li class="clickAble" data-type="gourl" data-url="<?=HTTP_PATH?>home.php"><i class="icon-icons_home"></i>Home</li>
<li class="clickAble <?php getCurrentFolder('nominate'); ?>" data-type="gourl" data-url="<?=HTTP_PATH?>nominate"><i class="icon-icons_nominate"></i>Nominate</li>
<li class="clickAble <?php getCurrentFolder('my-account'); ?>" data-type="gourl" data-url="<?=HTTP_PATH?>my-account"><i class="icon-icons_account"></i>My Account</li>
<li class="clickAble <?php getCurrentFolder('winners-wall'); ?>" data-type="gourl" data-url="<?=HTTP_PATH?>winners-wall"><i class="icon-icons_trophy"></i>Wall of Fame</li>
<li class="clickAble <?php getCurrentFolder('redeem'); ?>" data-type="gourl" data-url="<?=HTTP_PATH?>redeem"><i class="icon-icons_redeem"></i>Redeem</li>
<?php if($_SESSION['user']->approver() == 'YES' || $_SESSION['user']->administrator == 'YES') { ?>
<li class="clickAble <?php getCurrentFolder('approvals'); ?>" data-type="gourl" data-url="<?=HTTP_PATH?>approvals"><i class="icon-icons_tickinbox"></i>Approvals</li>
<?php }
	if($_SESSION['user']->SuperUser == 'YES' || $_SESSION['user']->SuperUser == 'Y') { ?>
<li class="clickAble <?php getCurrentFolder('reports'); ?>" data-type="gourl" data-url="<?=HTTP_PATH?>reports"><i class="icon-icons_report"></i>Reports</li>
<li class="clickAble <?php getCurrentFolder('admin'); ?>" data-type="gourl" data-url="<?=HTTP_PATH?>admin"><i class="icon-icons_admin"></i>Admin</li>
<?php } ?>
