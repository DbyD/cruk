<div class="photo">
	<img src="<?=HTTP_PATH.$_SESSION['user']->Photo?>" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png';" alt="<?=$_SESSION['user']->Fname?>" class="portfolioPhoto" />
</div>
<a href="#" data-type="popup" data-id="<?=HTTP_PATH?>" data-url="<?=HTTP_PATH?>alerts/photo-upload.php" class="clickAble uploadPhoto"><i class="icon-icons_person"></i></a>
<div class="title">
	<div class="awardStar">
		<i class="icon-icons_star"></i><span><?php echo getTotalAwards($_SESSION['user']->EmpNum) ?></span>
	</div>
	Hello
	<?php
	if($_SESSION['user']->PreferredFname =='') {
		echo trim($_SESSION['user']->Fname);
	} else {
		echo trim($_SESSION['user']->PreferredFname);
	}?>!
</div>
