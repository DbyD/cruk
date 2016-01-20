<?php
	include '../inc/dbconn.php';
	echo $_GET['id'];
	$ecard = getEcard($_GET['id']);
?>
<p>ecard design goes here</p>
<p> <?php echo $ecard->personalMessage; ?>
<script src="../js/cruk.js"></script>