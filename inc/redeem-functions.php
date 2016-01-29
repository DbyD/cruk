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

function getMenuAllRows(){
	global $db;


	$stmt = $db->prepare("SELECT * FROM tblmenuleft ORDER BY qu");

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

function getMenuRows(){
	global $db;


	$stmt = $db->prepare("SELECT * FROM tblmenuleft WHERE parent='0' ORDER BY qu");

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

function getMenuWhereParent( $m_id ){

	global $db;


	$stmt = $db->prepare("SELECT * FROM tblmenuleft WHERE parent=:parent ORDER BY qu");
	$stmt->bindValue(':parent',$m_id, PDO::PARAM_INT);
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

function insertSub($label, $parent){

	global $db;

	
	$stmt = $db->prepare("INSERT INTO tblmenuleft (label, parent) VALUES (:label, :parent)");
	

	$stmt->bindValue(':label',$label, PDO::PARAM_STR);
	$stmt->bindValue(':parent', $parent, PDO::PARAM_INT);
	

	$stmt->execute(); 
}

function insertMenu( $label ){

	global $db;


	$stmt = $db->prepare("
INSERT INTO tblmenuleft 
	(label) 
VALUES 
	(:label)");
	

	$stmt->bindValue(':label',$label, PDO::PARAM_STR);
	

	$stmt->execute(); 
}

function updateMenuLeft($label, $id){
	global $db;

	$sql = "
UPDATE tblmenuleft 
SET label = :label
WHERE id = :id";	
	$stmt = $db->prepare($sql);

	$stmt->bindValue(':label',$label, PDO::PARAM_STR);
	$stmt->bindValue(':id',$id, PDO::PARAM_INT);

	$stmt->execute(); 
}

function getProductByID( $prID ){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblproducts WHERE prID = :prID');
	$stmt->execute(array('prID' => $prID));
	if ($result = $stmt->fetch( PDO::FETCH_ASSOC )){
		return $result;
	} else{
		return 0;
	}
}

function addBasket( $data ){
	
	global $db;

	
	$stmt = $db->prepare("INSERT INTO tblbasket (prID, aPrice, employeID) VALUES (:prID, :aPrice, :employeID)");
	

	$stmt->bindValue(':prID',$data["prID"], PDO::PARAM_INT);
	$stmt->bindValue(':aPrice', $data["aPrice"], PDO::PARAM_INT);
	$stmt->bindValue(':employeID', $data["employeID"], PDO::PARAM_INT);
	

	return $stmt->execute(); 
}

function getBasket( $empID ){
	global $db;


	$stmt = $db->prepare("SELECT * FROM tblbasket WHERE employeID=:employeID");
	$stmt->bindValue(':employeID',$empID, PDO::PARAM_INT);
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

function deleteBasketItem( $baID ){
	global $db;
	$stmt = $db->prepare("DELETE FROM tblbasket WHERE baID = :baID");
	$stmt->bindValue(':baID',$baID, PDO::PARAM_INT);
	$res = $stmt->execute();
	return $res;
}
////////////////////////////////////////////////////////////////////////////////////
function deleteMenu( $id ){
	global $db;
	$stmt = $db->prepare("DELETE FROM tblmenuleft WHERE id = :id");
	$stmt->bindValue(':id',$id, PDO::PARAM_INT);
	$res = $stmt->execute();
	return $res;
}
////////////////////////////////////////////////////////////////////////////////////
function getMenuSubs( $id ){
	global $db;

	$sql = 'SELECT * FROM tblmenuleft WHERE parent = :parent';

	$stmt = $db->prepare( $sql );
	$stmt->execute( array('parent' => $id) );

	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arr[] = $result;
	}

	return $arr;
}
///////////////////////////////////////////////////////////////////////////////////
function updateSubImage( $link,$id ){

	global $db;

	$sql = "
UPDATE tblmenuleft 
SET sub_image = :sub_image
WHERE id = :id";	
	$stmt = $db->prepare($sql);

	$stmt->bindValue(':sub_image', $link, PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	$stmt->execute(); 

} 
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

?>