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
 //We include any functions.php file in the mods folder
	getModUrls();
	while ($getModUrl->fetch()){
		if (file_exists(ISVIPI_INC_MODS.$modName.'/functions.php'))
		include_once(ISVIPI_INC_MODS.$modName.'/functions.php');
	}
function getModUrls(){
	global $db;
	global $modID,$modName,$modURL,$modDesc,$modVer,$modAuth,$modAuthURL,$modeCount,$getModUrl;
	$active = 1;
	$getModUrl = $db->prepare("SELECT id,mod_name,mod_url,description,version,author,author_url FROM mods WHERE active=?");
	$getModUrl->bind_param("i",$active);
	$getModUrl->execute();
	$getModUrl->store_result();
	$getModUrl->bind_result($modID,$modName,$modURL,$modDesc,$modVer,$modAuth,$modAuthURL);
	$modeCount = $getModUrl->num_rows();
}
?>