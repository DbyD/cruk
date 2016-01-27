<?php
include('../inc/config.php');
include "lib.php";
$menu = new MenuGenerator;
echo $menu->SaveAction();

?>