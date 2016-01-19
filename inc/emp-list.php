<?php
include 'dbconn.php';
if ( !isset($_REQUEST['term']) )
	exit;
	$data = array();
	$searchAllUsers = new searchAllUsers($db);
	$searchList = $searchAllUsers->getAllUserSearch($_REQUEST['term']);
	foreach ($searchList as $list){
		$data[] = array(
			'label' => $list->Fname .' '. $list->Sname  ,
			'value' => $list->Fname .' '. $list->Sname
		);
	}
	echo json_encode($data);
	flush();
?>