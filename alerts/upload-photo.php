<?php
	include '../inc/dbconn.php';
	require_once('ImageManipulator.php');
	$path = "../";
	if ($_FILES) {
		$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
		$fileExtension = strrchr($_FILES['myphoto']['name'], ".");
		if (in_array($fileExtension, $validExtensions)) {
			
			$uploaddir = 'photos/';
			$newNamePrefix = time() . '_';
			$Photo = $uploaddir.$newNamePrefix.$_FILES['myphoto']['name'];
			$manipulator = new ImageManipulator($_FILES['myphoto']['tmp_name']);
       		$newImage = $manipulator->resample(250, 250);
			$width  = $manipulator->getWidth();
			$height = $manipulator->getHeight();
			$centreX = round($width / 2);
			$centreY = round($height / 2);
			$x1 = $centreX - 125;
			$y1 = $centreY - 125;
			$x2 = $centreX + 125;
			$y2 = $centreY + 125;
			$newImage = $manipulator->crop($x1, $y1, $x2, $y2);
			$manipulator->save($path.$uploaddir.$newNamePrefix.$_FILES['myphoto']['name']);
			$stmt = $db->prepare('UPDATE tblempall SET Photo = :Photo WHERE EmpNum = :EmpNum');
			$stmt->execute(array('Photo' => $Photo, 'EmpNum' => $_SESSION['user']->EmpNum));
			$_SESSION['user']->Photo = $Photo;
		} else {
			echo 'You must upload an image...';
		}
	}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Our Heroes</title>
<link rel="stylesheet" href="<?=$path?>css/foundation.css" />
<link rel="stylesheet" href="<?=$path?>css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="<?=$path?>css/smoothness/jquery-ui-1.8.2.custom.css" /> 
<link rel="stylesheet" href="<?=$path?>css/styles.css">
<link rel="stylesheet" href="<?=$path?>css/sitespecific.css">
<script src="<?=$path?>js/vendor/modernizr.js"></script>
<link rel="shortcut icon" href="<?=$path?>favicon.ico"> 
</head>
<body>
<div id="alertTitle" class="title">
	Upload Photo
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<img src="<?=$path.$_SESSION['user']->Photo?>" onerror="this.src='<?=$path?>images/no-photo.png';" alt="<?=$_SESSION['user']->Fname?>" />
		<form method="post" action="upload-photo.php" enctype="multipart/form-data" name="uploadPhoto" id="uploadPhoto">
			<div class="custom-upload">
				<input type="file" name="myphoto" id="myphoto">
				<div class="fake-file">
					<input disabled="disabled" name="thisphoto" this="thisphoto" value="">
				</div>
			</div>
			<div class="row valign-middle textRight">
				<a href="#" class="purpleButton clickAble" data-type="submit" data-url="uploadPhoto">Upload</a>
			</div>
		</form>
	</div>
</div>
<script src="<?=$path?>js/vendor/jquery.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="<?=$path?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=$path?>js/jquery.validate.min.js"></script>
<script src="<?=$path?>js/cruk.js"></script>
<script src="<?=$path?>js/foundation.min.js"></script>
<script>
	$(document).foundation();
    (function($){
        $(window).load(function(){
            $(".content").mCustomScrollbar();
        });
    })(jQuery);
	parent.$('.portfolioPhoto').attr("src", '<?=$path.$_SESSION['user']->Photo?>')
</script>
</body>
</html>