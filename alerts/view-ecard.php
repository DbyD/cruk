<?php
	include '../inc/config.php';
	$ecard = getNomination($_GET['id']);
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
?>

<div class="ecardPadding">
	<?php
		$ecard->Fname = getFirstName($ecard->NominatedEmpNum);
		$ecard->NomFull_name = getName($ecard->NominatorEmpNum);
		$ecard->NomFname = getFirstName($ecard->NominatorEmpNum);
		if($ecard->littleExtra == 'Yes'){
			echo indEcardExtraText($ecard);
		} else {
			echo indEcardText($ecard);
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