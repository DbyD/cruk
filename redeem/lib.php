<?php

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

	
	$listt = getMenuRows();


	foreach($listt as $m){
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
					<span>
						<img src='img/DeleteRed.png' class='act-icon del-item' data-del_id='".$m_id."'/>
					</span>
				</div>
			</div>

		
				
			

			<div class='sub-menu-area' >
			";

			$sub_listt = getMenuWhereParent( $m_id );

			if (is_array($sub_listt) || is_object($sub_listt))
			{
			    foreach ($sub_listt as $s_m)
			    {
			        $s_m_id = $s_m['id'];
					$html .="
					<div class='menu-item-holder'>

						<input type='text' value='".$s_m['label']."' class='prod-menu-item' data-menu_id='".$s_m_id."' onchange='updateLabel(this, ".$s_m_id.")'/>
						<a href='?menu_id=".$m_id."&sub_id=".$s_m_id."'><img src='img/update.png' class='act-icon'/></a>
						<span><img src='img/DeleteRed.png' class='act-icon del-item' data-del_id='".$s_m_id."'/></span>

					</div>";
			    }
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
 		insertSub( $_POST['newItem'] , $_POST['parent']);
 	else 
 		insertMenu( $_POST['newItem'] );

 	return $this->Menu();

 }

public function UpdateMenu()
{
	$menu = $this->menu;
	updateMenuLeft($_POST['upLabel'], $_POST['id']);
}

public function DeleteMenu(){
	deleteMenu($_POST['del_id']);
}

 public function SaveAction()
 {
 	if(isset($_POST['newItem']))
 		return $this->AddNewMenu();
 	if(isset($_POST['upLabel']))
 		return $this->UpdateMenu();
 	if(isset($_POST['del_id']))
 		return $this->DeleteMenu();
 }

}

?>