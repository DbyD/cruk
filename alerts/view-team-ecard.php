<?php
	include '../inc/config.php';
	$ecard = getTeamNomination($_GET['id']);
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
	
	$searchList = array_to_object(getThisTeamMembers($ecard->ID));
	foreach ($searchList as $list){
		$teamEmailList .= getName($list->EmpNum).", ";
		if(!isset($firstPersonEmpNum)){
			$firstPersonEmpNum = $list;
		}
	}
	$teamEmailList = chop($teamEmailList,", ");
	$teamEmailList = strrev(implode(strrev(' and'), explode(',', strrev($teamEmailList), 2)));
	$ecard->teamEmailList = $teamEmailList;
?>

<div class="ecardPadding">
	<?php
		// get first team member
		$ecard->full_name = $firstPersonEmpNum->Fname.' '.$firstPersonEmpNum->Sname;
		$ecard->Fname = $ecard->Team;
		if ($ecard->Volunteer !='') {
			$ecard->NomFull_name = $ecard->Volunteer;
		} else {
			$ecard->NomFull_name = getName($ecard->NominatorEmpNum);
		}
		$ecard->NomFname = getFirstName($ecard->NominatorEmpNum);
		if($ecard->littleExtra == 'Yes'){
			echo indEcardTeamExtraText($ecard);
		} else {
			echo indEcardTeamText($ecard);
		}
	?>
	<p>Thank you and well done!</p>
	<p><b>Our Heroes Team</b></p>
	<p class="small">Xexec ref: <?=$ecard->ID?></p>
	</div>
	<div class="ourheroes">
		<img class="emailCruklogo" src="<?=HTTP_PATH?>images/emails/Cancer-Research-UK.png" alt="Cancer Research UK">
		<img src="<?=HTTP_PATH?>images/emails/our-heroes.png" alt="Cancer Research UK">
	</div>
</div>
<script src="../js/cruk.js"></script>