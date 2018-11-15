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
	require_once(ISVIPI_PLUGINS_BASE.'pages/functions.php');
	//require our groups class
	require_once(ISVIPI_PLUGINS_BASE.'pages/classes/class.pages.php');
	$pages = new pages();
	
	//require posts class
	require_once(ISVIPI_PLUGINS_BASE.'pages/classes/class.posts.php');
	$posts = new posts();
	
	if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		$_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		notFound404Err();
		exit();
	}
	 
	$from_uri = $_SERVER['HTTP_REFERER'];
	
	if(!isset($PAGE[1])){
		 $_SESSION['isv_error'] = "Page ID is missing. Please try again.";
		 header('location:'.$from_uri.'');
		 exit();
	}
	//capture group ID
	$pid = cleanGET($PAGE[1]);
	$pid = $converter->decode($pid); 
	
	if(!is_numeric($pid)){
		 $_SESSION['isv_error'] = "Invalid Page ID supplied. Please try again.";
		 header('location:'.$from_uri.'');
		 exit();
	}
	
	$pageinfo = $pages->page_info($pid);
	
	if(!is_array($pageinfo)){
		 $_SESSION['isv_error'] = "Something went wrong. Please try again.";
		 header('location:'.$from_uri.'');
		 exit();
	}
	
	//check if the user has been banned from this group
	if(banned_from_page($pageinfo['id'],$_SESSION['isv_user_id'])){
		 $_SESSION['isv_error'] = "You were banned from this group and therefore access has been denied!";
		 header('location:'.ISVIPI_URL.'pages/discover/');
		 exit();
	}
 	include_once ISVIPI_PLUGINS_BASE.'pages/page.php'; 
