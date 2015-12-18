<div class="photo">
	<img src="<?=$_SESSION['user']->Photo?>" onerror="this.src='images/no-photo.png';" alt="<?=$_SESSION['user']->Fname?>" />
	<a href="upload-photo.php" class="uploadPhoto"><i class="icon-icons_person"></i></a>
</div>
<div class="title">
	Hello <?=$_SESSION['user']->Fname?>!
</div>
