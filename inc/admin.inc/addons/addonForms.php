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
if ($adm !== 'addonSett'){
	$_SESSION['err'] =UNKNOWN_REQ;
    header ('location:'.$from_url.'');
	exit();
} 
/////////////////////////////////////////////////////////////
////////////////ADDON SETTINGS /////////////////////////////
////////////////////////////////////////////////////////////
if ($adm == 'addonSett') {
	if (empty($_POST['enabAddons'])){
		$act = 0;
	} else {
$act = get_post_var('enabAddons');
	}
		//we update our database
		$uporec = $db->prepare('UPDATE general_settings set addons_enabled=? LIMIT 1');
		$uporec->bind_param('i', $act);
		$uporec->execute();
		$uporec->close();
			//We return a success message
			$_SESSION['succ'] =S_SUCCESS;
			header ('location:'.$from_url.'');
			exit();	

}


////////////////////////////////////////
///////// leave this as is /////////////
///////////////////////////////////////
} else {
	die404();
}
?>