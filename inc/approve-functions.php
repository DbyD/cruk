<?php
////////////////////////////////////////////////////////////////////////////////////
function getWorkAwards(){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblworkawards');
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function workAwardType($id){
	global $db;
	$stmt = $db->prepare('SELECT type FROM tblworkawards WHERE id = :id');
	$stmt->execute(array('id' => $id));
	return $stmt->fetch(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function getMyWorkAwards($nominationID){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblworknominations wn INNER JOIN tblworkawards wa WHERE nominationID = :nominationID');
	$stmt->execute(array('nominationID' => $nominationID));
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}
////////////////////////////////////////////////////////////////////////////////////
function getNomination($ID){
	global $db;
	$stmt = $db->prepare('SELECT * FROM tblnominations WHERE ID = :ID');
	$stmt->execute(array('ID' => $ID));
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Award');
	return $stmt->fetch();
}
?>