<?php
include 'config.php';
if ( !isset($_REQUEST['term']) )
	exit;
	$data = array();
	$searchUsers = new searchUsers($db);
	$searchList = $searchUsers->getAllTeamSearch($_REQUEST['term']);
	foreach ($searchList as $list){
		$data[] = array(
			'label' => $list->Team,
			'value' => $list->Team
		);
	}
	$searchList = $searchUsers->getAllUserSearch($_REQUEST['term']);
	foreach ($searchList as $list){
		$data[] = array(
			'label' => $list->Fname .' '. $list->Sname,
			'value' => $list->Fname .' '. $list->Sname
		);
	}
	echo json_encode($data);
	flush();
?>