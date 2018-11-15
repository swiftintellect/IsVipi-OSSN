<?php
	/*******************************************************
	 *   Copyright (C) 2014  http://isvipi.org
	
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
	require_once(ISVIPI_PAGES_BASE .'m_base.php'); 
	require_once(ISVIPI_PLUGINS_BASE.'groups/functions.php');
	//require our groups class
	require_once(ISVIPI_PLUGINS_BASE.'groups/classes/class.groups.php');
	$grps = new groups();
	
	//require discussions class
	require_once(ISVIPI_PLUGINS_BASE.'groups/classes/class.discussions.php');
	$disc = new discussions();
	
	if(!isset($PAGE[1])){
		 echo "<div class='list-group-item'> Something went wrong. Please try again. </div>";
		 exit();
	}
	//capture group ID
	$gid = cleanGET($PAGE[1]);
	$gid = $converter->decode($gid); 
	
	if(!is_numeric($gid)){
		 $_SESSION['isv_error'] = "Invalid Group ID supplied. Please try again.";
		 header('location:'.$from_uri.'');
		 exit();
	}
	
	//Groups I admin
	$grpinfo = $grps->groups_info($gid);
	
	if(!is_array($grpinfo)){
		 $_SESSION['isv_error'] = "Something went wrong. Please try again.";
		 header('location:'.$from_uri.'');
		 exit();
	}
	
	//check if the user has been banned from this group
	if(banned_from_group($grpinfo['id'],$_SESSION['isv_user_id'])){
		 $_SESSION['isv_error'] = "You were banned from this group and therefore access has been denied!";
		 header('location:'.ISVIPI_URL.'groups/discover/');
		 exit();
	}
 	include_once ISVIPI_PLUGINS_BASE.'groups/remote/discussions.php'; 
