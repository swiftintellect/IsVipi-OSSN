<?php
if (isset($_SESSION['admin_id'])){
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 ******************************************************/ 
include_once ISVIPI_ADMIN_INC_BASE. 'adminFunc.php';
$from_url = $_SERVER['HTTP_REFERER'];
if (isset($ACTION[2])){
	$action = $ACTION[2];
} else {
	$_SESSION['err'] =UNKNOWN_REQ;
    header ('location:'.$from_url.'');
	exit();
}
if ($action !== 'deac' && $action !== 'act' && $action !== 'inst' && $action !== 'uninst' && $action !== 'del'){
	$_SESSION['err'] =UNKNOWN_REQ;
    header ('location:'.$from_url.'');
	exit();
} 
/////////////////////////////////////////////////////////////
//////////////// DEACTIVATE AN ADDON ////////////////////////
////////////////////////////////////////////////////////////
if ($action == 'deac') {
	if(!is_numeric($ACTION[3])){
		$_SESSION['err'] =UNKNOWN_REQ;
		header ('location:'.$from_url.'');
		exit();
	}
	$status = 0;
	$stmt = $db->prepare("UPDATE mods SET active=? WHERE id=?");
	$stmt->bind_param("ii", $status,$ACTION[3]);
	$stmt->execute();
	$stmt->close();	
		//We return success notice
		$_SESSION['succ'] =S_SUCCESS;
		header ('location:'.$from_url.'');
		exit();
}

/////////////////////////////////////////////////////////////
//////////////// ACTIVATE AN ADDON /////////////////////////
////////////////////////////////////////////////////////////
if ($action == 'act') {
	if(!is_numeric($ACTION[3])){
		$_SESSION['err'] =UNKNOWN_REQ;
		header ('location:'.$from_url.'');
		exit();
	}
	$status = 1;
	$stmt = $db->prepare("UPDATE mods SET active=? WHERE id=?");
	$stmt->bind_param("ii", $status,$ACTION[3]);
	$stmt->execute();
	$stmt->close();	
		//We return success notice
		$_SESSION['succ'] =S_SUCCESS;
		header ('location:'.$from_url.'');
		exit();
}

/////////////////////////////////////////////////////////////
//////////////// INSTALL AN ADDON ///////////////////////////
////////////////////////////////////////////////////////////
if ($action == 'inst') {
	$addon = $ACTION[3];
	
		//Check if it is a genuine addon
		if (!$getContent = @file_get_contents(''.ISVIPI_INC_MODS.''.$addon.'/index.php',1000)){
			$_SESSION['err'] =E_INVAL_ADDON;
				header ('location:'.$from_url.'');
				exit();	
		}
		if (!$tokens = token_get_all($getContent)){
				$_SESSION['err'] =E_INVAL_ADDON;
				header ('location:'.$from_url.'');
				exit();	
			
		}
					$AddonDet = array($tokens);
			foreach($tokens as $token) {
					if($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
						$AddonDet = explode("\n", $token[1]);
						if (!isset($AddonDet)){
							$_SESSION['err'] =E_INVAL_ADDON;
								header ('location:'.$from_url.'');
								exit();
						}
						if (isset($AddonDet)){
							
							$AddonName = preg_split("/:/", $AddonDet[1]); //$AddonName[1]
							$AddonName[1] = str_replace(' ', '', $AddonName[1]);;
							$AddonName[1] = strip_tags(preg_replace('/\s+/', '', $AddonName[1]));
							$AddonURI = preg_split("/:/", $AddonDet[2],2); //$AddonURI[1]
							$AddonDesc = preg_split("/:/", $AddonDet[3]); //$AddonDesc[1]
							$AddonVer = preg_split("/:/", $AddonDet[4]); //$AddonVer[1]
							$AddonAuthor = preg_split("/:/", $AddonDet[5]); //$AddonAuthor[1]
							$AuthorURI = preg_split("/:/", $AddonDet[6],2); //$AuthorURI[1]*/
							
			//We check if an addon with a similar name is installed
			$stmt = $db->prepare("SELECT id FROM mods WHERE mod_name=?"); 
			$stmt->bind_param('s',$AddonName[1]);
			$stmt->execute();
			$stmt->store_result();
			$count = $stmt->num_rows();
			if ($count >0 ){
				//We print an  error message
				$_SESSION['err'] =E_ADDON_EXISTS;
				header ('location:'.$from_url.'');
				exit();	
				
			}
			//If no error, we add these values to our database
			$status = 0;
			$stmt = $db->prepare('insert into mods (mod_name,mod_url,description,version,author,author_url,active) 
			values (?,?,?,?,?,?,?)');
			$stmt->bind_param('sssssss', strtolower($AddonName[1]),strip_tags($AddonURI[1]),strip_tags($AddonDesc[1]),strip_tags($AddonVer[1]),strip_tags($AddonAuthor[1]),strip_tags($AuthorURI[1]),strip_tags($status));
			$stmt->execute();
			$stmt->close();
			
			//Then we look for the initialize file that will tell us if a database table has to be created
			if (file_exists(ISVIPI_INC_MODS.$addon.'/'.$addon.'.php')){
				//We create a session variable that will tell our file that we are installing the addon
				
				$_SESSION['addon_action'] = "install";
				include_once(ISVIPI_INC_MODS.$addon.'/'.$addon.'.php');
			}
			
				//We print a success message
				$_SESSION['succ'] =S_SUCCESS;
				header ('location:'.$from_url.'');
				exit();
						}
								
					} 
					
			}
}

/////////////////////////////////////////////////////////////
//////////////// UNINSTALL AN ADDON ////////////////////////
////////////////////////////////////////////////////////////
if ($action == 'uninst') {
	$addon = $ACTION[3];
	//The first thing we do is delete any entries in the database
		if (file_exists(ISVIPI_INC_MODS.$addon.'/'.$addon.'.php')){
		
		//We create a session variable that will tell our file that we are uninstalling the addon
				$_SESSION['addon_action'] = "uninstall";
				include_once(ISVIPI_INC_MODS.$addon.'/'.$addon.'.php');
			}
		//Once that is done, we delete the addon from our addons table
		global $db;
		$stmt = $db->prepare('DELETE from mods WHERE mod_name=?');
		$stmt->bind_param('s',$addon);
		$stmt->execute();
		$stmt->close();
		
		//If all is well, we print a success message
		$_SESSION['succ'] =S_SUCCESS;
		header ('location:'.$from_url.'');
		exit();
}

/////////////////////////////////////////////////////////////
//////////////// UNINSTALL AN ADDON ////////////////////////
////////////////////////////////////////////////////////////
if ($action == 'del') {
	$addon = str_replace("%20"," ",$ACTION[3]);
	
	//We delete the addon's files from the mods folder
	chmod(ISVIPI_INC_MODS.$addon, 0777);
	unlink(ISVIPI_INC_MODS.$addon);
	
	//If all is well, we print a success message
		$_SESSION['succ'] =S_SUCCESS;
		header ('location:'.$from_url.'');
		exit();
	
	
}

////////////////////////////////////////////////////
////////////// Leave this as is ////////////////////
///////////////////////////////////////////////////
} else {
	die404();
}
?>