<?php
	include '../inc/config.php';
	require_once('ImageManipulator.php');
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
			$manipulator->save(LOCAL_PATH_ROOT.'/photos/'.$newNamePrefix.$_FILES['myphoto']['name']);
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
<link rel="stylesheet" href="<?=HTTP_PATH?>css/foundation.css" />
<link rel="stylesheet" href="<?=HTTP_PATH?>css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="<?=HTTP_PATH?>css/smoothness/jquery-ui-1.8.2.custom.css" /> 
<link rel="stylesheet" href="<?=HTTP_PATH?>css/styles.css">
<link rel="stylesheet" href="<?=HTTP_PATH?>css/sitespecific.css">
<script src="<?=HTTP_PATH?>js/vendor/modernizr.js"></script>
<link rel="shortcut icon" href="<?=HTTP_PATH?>favicon.ico"> 
</head>
<body>
<div id="alert" class="">
	<div id="alertbox" class="forPhoto">
		<div id="alertContent"></div>
		<div id="closealert" data-type="close" data-id="3" class="clickAble closealert"><i class="icon-icons_close"></i></div>
	</div>
</div>
<div id="alertTitle" class="title smallPopupTitle">
	<div class="row withPadding">
		<div class="medium-12 columns">
			Upload Photo
		</div>
	</div>
</div>
<div id="alertBody" class="alertBody">
	<div class="tableRow">
		<img src="<?=HTTP_PATH.$_SESSION['user']->Photo?>" onerror="this.src='<?=HTTP_PATH?>images/no-photo.png';" alt="<?=$_SESSION['user']->Fname?>" />
		<form method="post" action="upload-photo.php" enctype="multipart/form-data" name="uploadPhoto" id="uploadPhoto">
			<div class="custom-upload">
				<input type="file" name="myphoto" id="myphoto">
				<div class="fake-file">
					<input disabled="disabled" name="thisphoto" this="thisphoto" value="" placeholder="Click to Browse">
				</div>
			</div>
			<div class="row valign-middle">
				<a href="#" class="blueButton clickAble" data-type="submit" data-url="uploadPhoto">Upload</a>
			</div>
		</form>
	</div>
</div>
<script src="<?=HTTP_PATH?>js/vendor/jquery.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="<?=HTTP_PATH?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=HTTP_PATH?>js/jquery.validate.min.js"></script>
<script src="<?=HTTP_PATH?>js/foundation.min.js"></script>
<script src="<?=HTTP_PATH?>js/cruk.js"></script>
<script>
	parent.$('.portfolioPhoto').attr("src", '<?=HTTP_PATH.$_SESSION['user']->Photo?>')
</script>
</body>
</html>