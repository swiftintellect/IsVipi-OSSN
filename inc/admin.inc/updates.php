<?php
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
if ($action !== 'dbupdate'){
	$_SESSION['err'] =UNKNOWN_REQ;
    header ('location:'.$from_url.'');
	exit();
} 

/////////////////////////////////////////////////////////////
//////////////// UPDATE DATABASE ////////////////////////////
////////////////////////////////////////////////////////////
	if ($action == 'dbupdate') {
		if (file_exists(ISVIPI_ADMIN_BASE.'/update/update.php')){
			//we include our database update file that will run all sqls we need
			include_once (ISVIPI_ADMIN_BASE.'/update/update.php');
			//then we change site status from maintenance mode
			upSiteStatus('1');
			//lastly we return our success message
			$_SESSION['succ'] ="Site update complete";
			$_SESSION['up-to-date'] = true;
			$_SESSION['upd_succ'] = true;
			header ('location:'.ISVIPI_URL.$adminPath.'/sys_management'.'');
			exit();
		} else {
			//we return an error message that the required include file was not found
			$_SESSION['err'] ="The required database upgrade file was not found. Please make sure that you have downloaded the latest package will all its files.";
			header ('location:'.$from_url.'');
			exit();
		}
	}
?>