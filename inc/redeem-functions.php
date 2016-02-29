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
	$where = 'menuID = :menuID AND subID = :subID';
	if( $sub_id === null )
	{
		$where = 'menuID = :menuID AND subID IS NULL';
	}

	if($_SESSION['user']->administrator == 'NO')
		$where .= " AND showID = 'yes'";

	$stmt = $db->prepare("SELECT * FROM tblproducts WHERE " . $where);
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

/*
	Insert a product into shop 
*/
function insertProduct( $data ){
	global $db;
	$sub_key = $sub_value = '';

	if($data["subID"] != 'other')
	{
		$sub_key = 'subID,';
		$sub_value = ':subID,';
	}

	$stmt = $db->prepare("
		INSERT INTO tblproducts 
			(aTitle, aPrice, showID, delivery, aContent, menuID, " . $sub_key . " Image_name) 
		VALUES 
			(:aTitle, :aPrice, :showID, :delivery, :aContent, :menuID, " . $sub_value . " :Image_name )");

	$stmt->bindValue(':aTitle',$data["aTitle"], PDO::PARAM_STR);
	$stmt->bindValue(':aPrice', $data["aPrice"], PDO::PARAM_STR);
	$stmt->bindValue(':showID', $data["showID"], PDO::PARAM_STR);
	$stmt->bindValue(':delivery',$data["delivery"] , PDO::PARAM_STR);
	$stmt->bindValue(':aContent',$data["aContent"] , PDO::PARAM_STR);
	$stmt->bindValue(':menuID',$data["menuID"] , PDO::PARAM_INT);

	if($data["subID"] != 'other')
	{
		$stmt->bindValue(':subID',$data["subID"] , PDO::PARAM_INT);
	}

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
			showID = :showID,
			aContent = :aContent,
			menuID = :menuID,
			subID = :subID " . $image_update . "
		WHERE prID = :prID";
	$stmt = $db->prepare( $sql );
	
	$stmt->bindValue(':aTitle',$data["aTitle"], PDO::PARAM_STR);
	$stmt->bindValue(':aPrice', $data["aPrice"], PDO::PARAM_STR);
	$stmt->bindValue(':delivery',$data["delivery"] , PDO::PARAM_STR);
	$stmt->bindValue(':showID',$data["showID"] , PDO::PARAM_STR);
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
		INSERT INTO tblbasketorders ( phone, address1, address2, town, postcode, date, EmpNum, totalPrice) 
		VALUES ( :phone, :address1, :address2, :town, :postcode, :date, :EmpNum, :totalPrice)");
	
	$stmt->bindValue(':phone',$data["telephone"], PDO::PARAM_STR);
	$stmt->bindValue(':address1', $data["address1"], PDO::PARAM_STR);
	$stmt->bindValue(':address2',$data["address2"] , PDO::PARAM_STR);
	$stmt->bindValue(':town',$data["town"] , PDO::PARAM_STR);
	$stmt->bindValue(':postcode',$data["postcode"] , PDO::PARAM_INT);
	$stmt->bindValue(':date',$data["date"] , PDO::PARAM_STR);
	$stmt->bindValue(':EmpNum',$data["EmpNum"] , PDO::PARAM_STR);
	$stmt->bindValue(':totalPrice',$data["totalPrice"] , PDO::PARAM_INT);
	$stmt->execute();
	// print_r( $stmt->errorInfo() );
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
	$where = "id = :id";
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
function updateSubImageAndName( $res ){
	global $db;
	$string = '';
	if($res['sub_image'] != false){
		$string = ',sub_image = :sub_image';
	}
	$sql = "
		UPDATE tblmenuleft 
		SET label = :label " . $string . " 
		WHERE id = :id";
	$stmt = $db->prepare($sql);
	if($res['sub_image'] != false){
		$stmt->bindValue(':sub_image', $res['sub_image'], PDO::PARAM_STR);
	}
	$stmt->bindValue(':label', $res['label'], PDO::PARAM_STR);
	$stmt->bindValue(':id', $res['id'], PDO::PARAM_INT);
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
	$stmt = $db->prepare("
	INSERT INTO tblcreditcard 
		(firstname, surname, address1, 	address2, town, postcode, telephone, email, amount, EmpNum, orderID, resultCardRequest) 
	VALUES 
		(:firstname, :surname, :address1, :address2, :town, :postcode, :telephone, :email, :amount, :EmpNum, :orderID, :resultCardRequest)");
	$stmt->bindValue(':firstname',$data["firstname"], PDO::PARAM_STR);
	$stmt->bindValue(':surname', $data["surname"], PDO::PARAM_STR);
	$stmt->bindValue(':address1',$data["address1"] , PDO::PARAM_STR);
	$stmt->bindValue(':address2',$data["address2"] , PDO::PARAM_STR);
	$stmt->bindValue(':town',$data["town"] , PDO::PARAM_STR);
	$stmt->bindValue(':postcode',$data["postcode"] , PDO::PARAM_INT);
	$stmt->bindValue(':telephone',$data["telephone"] , PDO::PARAM_STR);
	$stmt->bindValue(':email',$data["email"] , PDO::PARAM_STR);
	$stmt->bindValue(':amount',$data["amount"] , PDO::PARAM_INT);
	$stmt->bindValue(':EmpNum',$data["EmpNum"] , PDO::PARAM_STR);
	$stmt->bindValue(':orderID',$data["orderID"] , PDO::PARAM_INT);
	$stmt->bindValue(':resultCardRequest',$data["resultCardRequest"] , PDO::PARAM_STR);
	$stmt->execute();
	return $data["orderID"];
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
			ON a.id = b.id
		SET	 a.amount = :amount,a.resultCardRequest = :resultCardRequest
		WHERE a.EmpNum = :EmpNum";

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
function getBasketByOrder($ord_id) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblbasket WHERE orderID = :orderID');
	$stmt->execute(array('orderID' => $ord_id));
	$arr = array();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arr[] = $result;
	}
	if( count($arr) == 0){
		return 0;
	}
	return $arr;
}
///////////////////////////////////////////////////////////////////////////////////
function createSignature(array $data, $key) {
	// echo $key;
	ksort($data);
	$ret = http_build_query($data, '', '&');
	$ret = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $ret);
	return hash('SHA512', $ret . $key);
}
///////////////////////////////////////////////////////////////////////////////////
function SendMail($args = array()){
	$tel_number = $args['tel_number'];
	$delivery_address = $args["delivery_address"];
	$email_order_code = $args["email_order_code"];
	$content = get_content_email($email_order_code, $tel_number, $delivery_address);					
	$sendEmail = new StdClass();
	$sendEmail->Content = $content;
	$sendEmail->emailTo = $_SESSION['user']->Eaddress;
	$sendEmail->subject = 'CRUK Shop Order';
	$sendEmail->Bcc = 'retailvouchers@xexec.com';
	$email = sendEmail($sendEmail,'');
}
///////////////////////////////////////////////////////////////////////////////////
function get_content_email( $email_order_code, $tel_number, $delivery_address) {
	$arr = array();
	$i = $total_price = 0;
	$basket = getBasketByOrder( $email_order_code );
	foreach ($basket as $pr_b){	
		$pr_info = getProductByID( $pr_b["prID"] );
		$total_price += $pr_b['aPrice'];
			if( $i == 0 ){
				$arr[ $i ]['baID'] = $pr_b['baID'];
				$arr[ $i ]['aPrice'] = $pr_b['aPrice'];
				$arr[ $i ]['aTitle'] = $pr_info['aTitle'];
				$arr[ $i ]['prID'] = $pr_b["prID"];
				$arr[ $i ]['QTY'] = 1;
				$i++;
			} else {
				$isProduct = false;
				for( $j = 0; $j < count($arr); $j++ ){
					if( $pr_b["prID"] == $arr[ $j ]['prID'] && $pr_b["aPrice"] == $arr[ $j ]['aPrice']){
						$arr[ $j ]['QTY']++;
						$arr[ $j ]['baID'] .= ',' . $pr_b['baID'] ;
						$isProduct = true;
					} 
				}
				if( !$isProduct ){
					$arr[ $i ]['baID'] = $pr_b['baID'];
					$arr[ $i ]['aPrice'] = $pr_b['aPrice'];
					$arr[ $i ]['aTitle'] = $pr_info['aTitle'];
					$arr[ $i ]['prID'] = $pr_b["prID"];
					$arr[ $i ]['QTY'] = 1;
					$i++;
				}
			}
		}
		$i = 1;
		$table_body = '';
		foreach( $arr as $b ){
			$table_body .= '<tr>
								<td>' . $b['QTY'] .'</td>
								<td class="textLeft">' . $b['aTitle'] . '</td>
								<td>&pound;' . $b['aPrice'] . '</td>
							</tr>';
			$i++;
		}
		$table_body .= '<tr>
							<td></td>
							<td class="textRight"><b>Total</b></td>
							<td><b>&pound;' . $total_price . '</b></td>
						</tr>';
	// you need to add content here.
	$content =	'<p>Dear '.$_SESSION['user']->Fname.'</p>
				<p>Thank you for your recent purchase.</p>
				<p><b>Items Purchased</b></p>';
	$content .= '<table id="table_basket" class="invoice" border="0" cellpadding="2" cellspacing="0" >
						<tr>
							<th width="100">QTY</th>
							<th class="textLeft">PRODUCT NAME</th>
							<th width="125">PRICE</th>
						</tr>
						' . $table_body . '
				</table><br>&nbsp;';
	//add shopping basket here in a table
	$content .= '<table id="table_basket" class="details" border="0" cellpadding="2" cellspacing="0" >
					<tr>
						<td width="150"><b>Your order code:</b></td>
						<td> CR' . $email_order_code .  ' </td>
					</tr>
					<tr>
						<td><b>Name:</b></td>
						<td>' . $_SESSION['user']->Fname . ' ' . $_SESSION['user']->Sname . '</td>
					</tr>
					<tr>
						<td><b>Email:</b></td>
						<td>' . $_SESSION['user']->Eaddress . '</td>
					</tr>
					<tr>
						<td><b>Telephone Number:</b></td>
						<td>' . $tel_number . '</td>
					</tr>';
		if($delivery_address!=''){
		$content .= '<tr>
						<td><b>Delivery address:</b></td>
						<td>' . $delivery_address . '</td>
					</tr>';
		}
		$content .= '</table>';
	//add order details here in a table
	$content .= '';
	$content .='<p>If you have any questions regarding your order, please email <a href="mailto:concierge@xexec.com">concierge@xexec.com</a> or<br>call +44 20 8201 6483 quoting your unique order code.</p>';
	return $content;
}
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

?>
