<?php
$con =  mysql_connect("localhost", "root","");
 		mysql_select_db("cruk21-01-201610-44 AM",$con);
		mysql_query( 'SET NAMES UTF8' );
$menu='tblmenuleft';

class MenuGenerator {

public $menu='tblmenuleft';



 public function safe_post($value='')
 {
 	return mysql_real_escape_string($value);
 }

 public function Menu($field = "")
 {
 	$menu = $this->menu;
	$html = "";

	$listt = mysql_query("SELECT * FROM $menu WHERE parent='0' ORDER BY qu ");
	while($m = mysql_fetch_array($listt)){
		$m_id = $m['id'];
		$html .="
			

			<div class='menu-item-holder' id='holder_of_sub_id_".$m_id."' >

				
			<div class='row'>
				<div class='large-10 columns'>
					<div class='row collapse prefix-radius'>

						<div class='small-3 columns'>
							<span class='prefix menu-toggle' id='sub_id_".$m_id ."' onclick='openSubmenu(this)'>^</span>
						</div>

						<div class='small-9 columns'>
							<input type='text' value='".$m['label']."' class='prod-menu-item' onchange='updateLabel(this, ".$m_id.")'/>
						</div>

					</div>

				</div>
				<div class='large-2 columns'>
					<a href='?menu_id=".$m_id."'><img src='img/update.png' class='act-icon'/></a>
					<span><img src='img/DeleteRed.png' class='act-icon'  class='del-item' data-del_id='".$m_id."'/></span>
				</div>
			</div>

		
				
			

			<div class='sub-menu-area' >
			";

			$sub_listt = mysql_query("SELECT * FROM $menu WHERE parent='".$m_id."' ORDER BY qu ");
			while($s_m = mysql_fetch_array($sub_listt)){
				$s_m_id = $s_m['id'];
				$html .="
					<div class='menu-item-holder'>

						<input type='text' value='".$s_m['label']."' class='prod-menu-item' data-menu_id='".$s_m_id."' onchange='updateLabel(this, ".$s_m_id.")'/>
						<a href='?menu_id=".$m_id."&sub_id=".$s_m_id."'><img src='img/update.png' class='act-icon'/></a>
						<span><img src='img/DeleteRed.png' class='act-icon' class='del-item' data-del_id='".$s_m_id."'/></span>

					</div>";

			}
			$html .="
				<div class='menu-item-holder'  >
					
					<input type='text' value='' class='prod-menu-item' id='adding_new' onchange='AddHeadMenu(this, \"sub\", ".$m_id.")'/>
					<span><img src='img/ok.png' class='act-icon' class='add-item'/></span>
					
				</div>
				";

			//CLOSING DIV of Parnet
			$html .="
				</div>
			</div>	";

			


	}
	if(empty($field)){
		$html .="
				<div class='menu-item-holder'  >
					
					<input type='text' value='' class='prod-menu-item' id='adding_new' onchange='AddHeadMenu(this, \"parent\", 0)'/>
					<span><img src='img/ok.png' class='act-icon' class='add-item'/></span>
					
				</div>
				";
	}

	

			return $html;

 }

 public function AddNewMenu()
 {
 	$menu = $this->menu;
 	//folder,parent
 	if($_POST['folder']=="sub")
 		mysql_query("INSERT INTO `$menu` (`label`, `parent`) VALUES ('".$_POST['newItem']."', '".$_POST['parent']."')"); 
 	else 
 		mysql_query("INSERT INTO `$menu` (`label`) VALUES ('".$_POST['newItem']."')"); 

 	return $this->Menu();

 }

public function UpdateMenu()
{
	$menu = $this->menu;

	mysql_query("UPDATE `$menu` SET label='".$_POST['upLabel']."' WHERE id='".$_POST['id']."'"); 	
}

 public function SaveAction()
 {
 	if(isset($_POST['newItem']))
 		return $this->AddNewMenu();
 	if(isset($_POST['upLabel']))
 		return $this->UpdateMenu();
 		

 }

}

?>