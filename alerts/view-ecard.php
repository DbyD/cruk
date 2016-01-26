<?php
	include '../inc/config.php';
	$ecard = getNomination($_GET['id']);
	$ecardImage = str_replace(' ','-',strtolower($ecard->BeliefID));
?>

<div class="ecardPadding">
	<div class="ourheroes">
		<img src="<?=HTTP_PATH?>images/emails/our-heroes.png" alt="Cancer Research UK">
	</div>
	<?php
		$ecard->Fname = getFirstName($ecard->NominatedEmpNum);
		if($ecard->littleExtra == 'Yes'){
			echo indEcardExtraText($ecard);
		} else {
			echo indEcardText($ecard);
		}
	?>
	<img class="emailCruklogo" src="<?=HTTP_PATH?>images/emails/Cancer-Research-UK.png" alt="Cancer Research UK">
	<p>Regards</p>
	<p><b>Cancer Research</b></p>
</div>
<script src="../js/cruk.js"></script>