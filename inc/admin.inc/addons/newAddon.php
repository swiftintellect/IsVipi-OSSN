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
$adm = get_post_var('action');
if ($adm !== 'newAddon'){
	$_SESSION['err'] =UNKNOWN_REQ;
    header ('location:'.$from_url.'');
	exit();
} 
/////////////////////////////////////////////////////////////
//////////////// UPLOAD NEW ADDON //////////////////////////
////////////////////////////////////////////////////////////
if ($adm == 'newAddon') {
if($_FILES["new"]["name"]) {
	$filename = $_FILES["new"]["name"];
	$source = $_FILES["new"]["tmp_name"];
	$type = $_FILES["new"]["type"];
	$rName = pathinfo($_FILES['new']['name'], PATHINFO_FILENAME);
	
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
	
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$_SESSION['err'] =E_UPLOAD_ZIP;
			header ('location:'.$from_url.'');
			exit();
	}
	
	//Check if it is a genuine addon
		$AddonName = strstr($filename,'.',true);
		if (!$getContent = @file_get_contents(''.ISVIPI_INC_MODS.''.$AddonName.'/index.php',1000)){
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
						/*if (isset($AddonDet)){
							$AddonName = preg_split("/:/", $AddonDet[1]); //$AddonName[1]
							$AddonURI = preg_split("/:/", $AddonDet[2],2); //$AddonURI[1]
							$AddonDesc = preg_split("/:/", $AddonDet[3]); //$AddonDesc[1]
							$AddonVer = preg_split("/:/", $AddonDet[4]); //$AddonVer[1]
							$AddonAuthor = preg_split("/:/", $AddonDet[5]); //$AddonAuthor[1]
							$AuthorURI = preg_split("/:/", $AddonDet[6],2); //$AuthorURI[1]
							
						}*/
								
					} 
				}
	$target_path = "".ISVIPI_INC_MODS."".$filename; 
	if(move_uploaded_file($source, $target_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($target_path);
		if ($x === true) {
			$zip->extractTo("".ISVIPI_INC_MODS.""); 
			$zip->close();
			unlink($target_path);
				//We print a success message
				$_SESSION['succ'] =S_SUCCESS;
				header ('location:'.$from_url.'');
				exit();
		}
	} else {
			$_SESSION['err'] =E_SYS_ERR;
			header ('location:'.$from_url.'');
			exit();	
		}
  	}	
  }
} else {
	die404();
}
?>