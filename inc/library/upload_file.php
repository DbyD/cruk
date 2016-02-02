<?php 

function insertFile( $menu_id, $sub_id ){
	$uploadOk = 1;
	$imageFileType = pathinfo(basename($_FILES["fileImage"]["name"]),PATHINFO_EXTENSION);


	

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileImage"]["tmp_name"]);
	    if($check !== false) {
	        // echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	
	// Check file size
	if ($_FILES["fileImage"]["size"] > 500000) {
	    
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    
	    $uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		$target_dir = "../images/menu_".$menu_id."/sub_".$sub_id . "/products/";
		
		
		$time = time();
		$hash = md5($time);

		$target_file = $target_dir . $hash . ".".$imageFileType;//
		
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}
		

		// Check if file already exists
	
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}

	    if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file)) {
	        $arr = explode("../", $target_file);
	        return end($arr);
	    }
	    
	}
}

function insertImageSub( $file, $sub_id, $menu_id){

	$error = false;
	$arr = explode( '.', $file["name"] );

	$imageFileType = end( $arr );

	if ( $file["size"] > 500000 ) {
	    $error = true;
	}

	if( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	    $error = true;
	}

	if ( !$error ){
		$target_dir = "../images/menu_" . $menu_id. "/sub_".$sub_id . "/";

		$target_file = $target_dir  . "logo.".$imageFileType;//
		
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		if (file_exists($target_file)) {
		    unlink($target_file);
		}

	    if (move_uploaded_file($file["tmp_name"], $target_file)) {
	        $arr = explode("../", $target_file);
	        return end( $arr );
	    }
		
	} else {
		return false;
	}
}

?>