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

function getMenuProducts( $menu_id , $sub_id ){
	global $db;
	
	$where  = 'menuID = :menuID AND subID = :subID';
	if( $sub_id === null ){
		$where  = 'menuID = :menuID AND subID IS NULL';
	}

	$stmt = $db->prepare('SELECT * FROM tblproducts WHERE ' . $where);
	
	$stmt->bindValue(':menuID',$menu_id, PDO::PARAM_INT);

	if( $sub_id !== null ){
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

function updateProduct( $data ){
	global $db;

	if( isset( $data[ "Image_name" ] ) ){
		$image_update = ',Image_name = :Image_name';
	} else {
		$image_update = '';
	}

	$sql = "
UPDATE tblproducts 
SET aTitle = :aTitle,
	aPrice = :aPrice,
	delivery = :delivery,
	aContent = :aContent,
	menuID = :menuID,
	subID = :subID " . $image_update . "
WHERE prID = :prID";

	$stmt = $db->prepare( $sql );
	
	
	$stmt->bindValue(':aTitle',$data["aTitle"], PDO::PARAM_STR);
	$stmt->bindValue(':aPrice', $data["aPrice"], PDO::PARAM_STR);
	$stmt->bindValue(':delivery',$data["delivery"] , PDO::PARAM_STR);
	$stmt->bindValue(':aContent',$data["aContent"] , PDO::PARAM_STR);
	$stmt->bindValue(':menuID',$data["menuID"] , PDO::PARAM_INT);
	$stmt->bindValue(':subID', $data["subID"] , PDO::PARAM_INT);

	if( isset( $data[ "Image_name" ] ) ){
		$stmt->bindValue(':Image_name',$data["Image_name"] , PDO::PARAM_STR);
	}
	
	$stmt->bindValue(':prID',$data["prID"] , PDO::PARAM_INT);
	

	$stmt->execute();
} 

function addBasketOrders( $data ){
	global $db;

	$stmt = $db->prepare("
INSERT INTO tblbasketorders (	phone, adress1, adress2, town, postcode, date, EmpNum, totalPrice) 
VALUES (	:phone, :adress1, :adress2, :town, :postcode, :date, :EmpNum, :totalPrice)");

	$stmt->bindValue(':phone',$data["telephone"], PDO::PARAM_STR);
	$stmt->bindValue(':adress1', $data["address1"], PDO::PARAM_STR);
	$stmt->bindValue(':adress2',$data["address2"] , PDO::PARAM_STR);
	$stmt->bindValue(':town',$data["town"] , PDO::PARAM_STR);
	$stmt->bindValue(':postcode',$data["postcode"] , PDO::PARAM_INT);
	$stmt->bindValue(':date',$data["date"] , PDO::PARAM_INT);
	$stmt->bindValue(':EmpNum',$data["EmpNum"] , PDO::PARAM_STR);
	$stmt->bindValue(':totalPrice',$data["totalPrice"] , PDO::PARAM_INT);

	$stmt->execute();
	$lastId = $db->lastInsertId();
	return $lastId;
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

function getMenuRows( $id = null ){
	global $db;

    if($id != null){
        $where  = "id = :id";
    } else {
        $where = "1=1";
    }

	$stmt = $db->prepare("SELECT * FROM tblmenuleft WHERE parent='0' AND " . $where . " ORDER BY qu");


    if($id != null){
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
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

	
	$stmt = $db->prepare("INSERT INTO tblbasket (prID, aPrice, EmpNum, status) VALUES (:prID, :aPrice, :EmpNum, 'in the basket')");
	

	$stmt->bindValue(':prID',$data["prID"], PDO::PARAM_INT);
	$stmt->bindValue(':aPrice', $data["aPrice"], PDO::PARAM_INT);
	$stmt->bindValue(':EmpNum', $data["EmpNum"], PDO::PARAM_STR);
	

	return $stmt->execute(); 
}

function getBasket( $empID ){
	global $db;


	$stmt = $db->prepare("SELECT * FROM tblbasket WHERE EmpNum=:EmpNum AND status='in the basket'");
	$stmt->bindValue(':EmpNum',$empID, PDO::PARAM_INT);
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

function updateBasketStatus( $empID, $orderID ){
	global $db;

	$sql = "
UPDATE tblbasket 
SET status = 'order', orderID = :orderID
WHERE EmpNum = :EmpNum AND status='in the basket'";	
	$stmt = $db->prepare($sql);

	$stmt->bindValue(':EmpNum',$empID, PDO::PARAM_STR);
	$stmt->bindValue(':orderID',$orderID, PDO::PARAM_INT);
	$stmt->execute(); 
}

function getBasketByID( $b_id ){
	global $db;


	$stmt = $db->prepare("SELECT * FROM tblbasket WHERE baID=:baID");
	$stmt->bindValue(':baID',$b_id, PDO::PARAM_INT);
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
/////////////////,///////////////////////////////////////////////////////////////////
function deleteMenu( $id ){
	global $db;
	$stmt = $db->prepare("DELETE FROM tblmenuleft WHERE id = :id");
	$stmt->bindValue(':id',$id, PDO::PARAM_INT);
	$res = $stmt->execute();
	return $res;
}
////////////////////////////////////////////////////////////////////////////////////
function getMenuSub( $sub_id ){
    global $db;

    $sql = 'SELECT * FROM tblmenuleft WHERE id = :id AND parent>0';

    $stmt = $db->prepare( $sql );
    $stmt->execute( array('id' => $sub_id) );

    $arr = array();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $arr[] = $result;
    }

    return $arr;
}
////////////////////////////////////////////////////////////////////////////////////
function getMenuSubs( $parent_id ){
	global $db;

	$sql = 'SELECT * FROM tblmenuleft WHERE parent = :parent';

	$stmt = $db->prepare( $sql );
	$stmt->execute( array('parent' => $parent_id) );

	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arr[] = $result;
	}

	return $arr;
}
///////////////////////////////////////////////////////////////////////////////////
function updateSubImage( $link, $id ){
	var_dump($link, ',',$id );

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
function getAvailable($empnum){
	global $db;
	$stmt = $db->prepare("SELECT SUM(amount) FROM tblnominations WHERE NominatedEmpNum = :EmpNum AND amount='20' AND AwardClaimed='Yes'");

	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetchColumn()){
		return $result;
	} else{
		return 0;
	}

} 

///////////////////////////////////////////////////////////////////////////////////
function getEmpBasketOrdersSum( $empnum ){
	global $db;
	$stmt = $db->prepare("SELECT SUM(totalPrice) FROM tblbasketorders WHERE EmpNum = :EmpNum ORDER BY id DESC");

	$stmt->execute(array('EmpNum' => $empnum));
	if ($result = $stmt->fetchColumn()){
		return $result;
	} else{
		return 0;
	}
}
///////////////////////////////////////////////////////////////////////////////////
function insertCreditCard( $data ) {
	global $db;
	$data["amount"] = 0;
	$data["EmpNum"] = $_SESSION["user"]->EmpNum;


	$stmt = $db->prepare("
INSERT INTO tblcreditcard 
	(firstname, surname, address1, 	address2, town, postcode, telephone, email, amount, EmpNum) 
VALUES 
	(:firstname, :surname, :address1, :address2, :town, :postcode, :telephone, :email, :amount, :EmpNum)");
	

	$stmt->bindValue(':firstname',$data["firstname"], PDO::PARAM_STR);
	$stmt->bindValue(':surname', $data["surname"], PDO::PARAM_STR);
	$stmt->bindValue(':address1',$data["address1"] , PDO::PARAM_STR);
	$stmt->bindValue(':address2',$data["address2"] , PDO::PARAM_STR);
	$stmt->bindValue(':town',$data["town"] , PDO::PARAM_STR);
	$stmt->bindValue(':postcode',$data["postcode"] , PDO::PARAM_INT);
	$stmt->bindValue(':telephone',$data["telephone"] , PDO::PARAM_STR);
	$stmt->bindValue(':email',$data["email"] , PDO::PARAM_STR);
	$stmt->bindValue(':amount',$data["amount"] , PDO::PARAM_INT);
	$stmt->bindValue(':EmpNum',$data["EmpNum"] , PDO::PARAM_INT);

	$stmt->execute();
	$lastId = $db->lastInsertId();
	return $lastId;
}
///////////////////////////////////////////////////////////////////////////////////
function updateCreditCardAmount( $amount , $resultCardRequest ) {
	global $db;
	
	$sql = "
UPDATE  
	tblcreditcard AS a
        INNER JOIN
	        (
	            SELECT MAX(id) as id 
	            FROM tblcreditcard 
	            GROUP BY EmpNum
	        ) 
	AS b 
	ON  a.id = b.id
SET     a.amount = :amount,a.resultCardRequest = :resultCardRequest
WHERE   a.EmpNum = :EmpNum";


	$stmt = $db->prepare( $sql );
	

	$stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
	$stmt->bindValue(':EmpNum', $_SESSION["user"]->EmpNum, PDO::PARAM_STR);
	$stmt->bindValue(':resultCardRequest', $resultCardRequest, PDO::PARAM_STR);
	$stmt->execute();
	
}
///////////////////////////////////////////////////////////////////////////////////
function getCreditCard( $empnum ) {
	global $db;
	$stmt = $db->prepare("SELECT SUM( amount ) FROM tblcreditcard WHERE EmpNum = :EmpNum");

	$stmt->execute(array('EmpNum' => $empnum));

	if ($result = $stmt->fetchColumn()){
		return $result;
	} else{
		return 0;
	}
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

?>