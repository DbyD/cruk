<div class="photo">
	<img src="<?=$path.$_SESSION['user']->Photo?>" onerror="this.src='<?=$path?>images/no-photo.png';" alt="<?=$_SESSION['user']->Fname?>" class="portfolioPhoto" />
	<a href="#" data-type="popup" data-url="<?=$path?>alerts/photo-upload.php" class="clickAble uploadPhoto"><i class="icon-icons_person"></i></a>
</div>
<div class="title">
	Hello <?=trim($_SESSION['user']->Fname)?>!
</div>
