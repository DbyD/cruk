<div class="photo">
	<img src="<?=HTTP_PATH.$_SESSION['user']->Photo?>" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png';" alt="<?=$_SESSION['user']->Fname?>" class="portfolioPhoto" />
	<a href="#" data-type="popup" data-id="<?=HTTP_PATH?>" data-url="<?=HTTP_PATH?>alerts/photo-upload.php" class="clickAble uploadPhoto"><i class="icon-icons_person"></i></a>
</div>
<div class="title">
	<div class="awardStar"><i class="icon-icons_star"></i><span><?php echo getTotalAwards($_SESSION['user']->EmpNum) ?></span></div> Hello <?=trim($_SESSION['user']->Fname)?>!
</div>
