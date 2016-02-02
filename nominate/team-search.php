<?php
include '../inc/config.php';
if ($_POST['searchTeamAuto']){
	$search = $_POST['searchTeamAuto'];
	$searchUsers = new searchUsers($db);
	$searchList = $searchUsers->getAllSearch($search);
	print_r( $searchList);
}
echo $_POST['searchTeamAuto'];
?>