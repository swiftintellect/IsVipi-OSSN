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
	require_once(ISVIPI_CLASSES_BASE .'global/getFriends_cls.php');
	require_once(ISVIPI_CLASSES_BASE .'forms/friends_cls.php'); 
	$m = new get_friends();
	
	// we define our order by (latest or oldest)
	if (isset($PAGE[1]) && ($PAGE[1] == 'latest' || $PAGE[1] == 'oldest')){
		$oderBY = cleanGET($PAGE[1]);
	} else {
		$oderBY = 'latest';
	}
	
	//we define how many members to load
	if (isset($PAGE[2]) && ($PAGE[2] == 25 || $PAGE[2] == 50 || $PAGE[2] == 100 || $PAGE[2] == 'all')){
		$limit = cleanGET($PAGE[2]);
	} else {
		$limit = 25;
	}
	$m_info = $m->all_friends($_SESSION['isv_user_id'],$oderBY,$limit);
	
	
 	include_once ISVIPI_ACT_THEME.'friends.php'; 
