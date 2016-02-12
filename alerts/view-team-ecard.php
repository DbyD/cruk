<?php
	include '../inc/config.php';
	$ecard = getTeamNomination($_GET['id']);
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	
	$searchList = array_to_object(getThisTeamMembers($ecard->TeamID));
	foreach ($searchList as $list){
		$teamEmailList .= getName($list->EmpNum).", ";
	}
	$teamEmailList = chop($teamEmailList,", ");
	$teamEmailList = strrev(implode(strrev(' and'), explode(',', strrev($teamEmailList), 2)));
	$ecard->teamEmailList = $teamEmailList;
?>

<div class="ecardPadding">
	<div class="ourheroes">
		<img src="<?=HTTP_PATH?>images/emails/our-heroes.png" alt="Cancer Research UK">
	</div>
	<?php
		$ecard->full_name = $_SESSION['user']->full_name();
		$ecard->Fname = $_SESSION['user']->Fname;
		$ecard->NomFull_name = getName($ecard->NominatorEmpNum);
		$ecard->NomFname = getFirstName($ecard->NominatorEmpNum);
		if($ecard->littleExtra == 'Yes'){
			echo indEcardTeamExtraText($ecard);
		} else {
			echo indEcardTeamText($ecard);
		}
	?>
	<img class="emailCruklogo" src="<?=HTTP_PATH?>images/emails/Cancer-Research-UK.png" alt="Cancer Research UK">
	<p>Regards</p>
	<p><b>Cancer Research</b></p>
</div>
<script src="../js/cruk.js"></script>