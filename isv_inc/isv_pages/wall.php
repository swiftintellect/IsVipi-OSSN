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
	require_once(ISVIPI_CLASSES_BASE .'global/getWall_cls.php'); 
	require_once(ISVIPI_CLASSES_BASE .'global/getFriends_cls.php'); 
	require_once(ISVIPI_CLASSES_BASE .'utilities/encrypt_decrypt.php'); 
	$converter = new Encryption;
	$friends = new get_friends();
	
	//get the user id
	if(!isset($PAGE[1])){
		exit();
	}
	
	$user = $PAGE[1];
	//check if it is numeric
	if(!is_numeric($user)){
		exit();
	}
	$getFeeds = new getFeeds($user);
	$feed = $getFeeds->allFeeds($user);

 	include_once ISVIPI_ACT_THEME.'wall.php'; 
