<?php
function getTotalProducts(){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblproducts');
	$stmt->execute();

	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arr[] = $result;
	}

	if( count($arr) == 0){
		return 0;
	}

	return $arr;
}

function getMenuProducts($menu_id , $sub_id ){
	global $db;

	$where  = 'menuID = :menuID';
	if($sub_id != null){
		$where .= ' AND subID = :subID';
	}

	$stmt = $db->prepare('SELECT * FROM tblproducts WHERE ' . $where);

	$stmt->bindValue(':menuID',$menu_id, PDO::PARAM_INT);

	if($sub_id != null){
		$stmt->bindValue(':subID', $sub_id, PDO::PARAM_INT);
	}

	$stmt->execute();

	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arr[] = $result;
	}

	if( count($arr) == 0){
		return 0;
	}

	return $arr;
}

function insertProduct( $data ){
	global $db;


	$stmt = $db->prepare("
INSERT INTO tblproducts 
	(aTitle, aPrice, delivery, aContent, menuID, subID, Image_name) 
VALUES 
	(:aTitle, :aPrice, :delivery, :aContent, :menuID, :subID, :Image_name )");
	

	$stmt->bindValue(':aTitle',$data["aTitle"], PDO::PARAM_STR);
	$stmt->bindValue(':aPrice', $data["aPrice"], PDO::PARAM_STR);
	$stmt->bindValue(':delivery',$data["delivery"] , PDO::PARAM_STR);
	$stmt->bindValue(':aContent',$data["aContent"] , PDO::PARAM_STR);
	$stmt->bindValue(':menuID',$data["menuID"] , PDO::PARAM_INT);
	$stmt->bindValue(':subID',$data["subID"] , PDO::PARAM_INT);
	$stmt->bindValue(':Image_name',$data["Image_name"] , PDO::PARAM_STR);

	$stmt->execute();
} 
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
?>