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
	
	//we check if a username is set
	if(!isset($PAGE[1]) || empty($PAGE[1])){
		notFound404Err();
	}
	$username = cleanGET($PAGE[1]);

	require_once(ISVIPI_CLASSES_BASE .'global/getMembers_cls.php');
	require_once(ISVIPI_CLASSES_BASE .'global/getFriends_cls.php'); 
	
	$m = new getSingleMember();
	$m_info = $m->members($username,'username');
	
	$friends = new get_friends();
	
 	include_once ISVIPI_ACT_THEME.'profile.php'; 
