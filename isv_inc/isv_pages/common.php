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
	 require_once(ISVIPI_ADMIN_CLS_BASE .'init.cls.php');
	$admin = new admin_security();
	global $PAGE,$p;
	if(!isset($PAGE[0]) || empty($PAGE[0])){
		$p = '';
	} else {
		$p = $PAGE[0];
	}
	
	/** Page Manager **/
	$pageManager = new pageManager();
	$s_m = $pageManager->siteMeta();
	
	//load page depending on the logged in status of the user
	if (!isLoggedIn() && !$admin->admin_logged_in()){
		//this page will loaded when the user is not logged in
		include_once ISVIPI_ACT_THEME.'blank.php'; 
	} else {
		
		//check if the user has status active
		if (!isStatusActive() && !$admin->admin_logged_in()){
			$_SESSION['isv_error'] = 'Prohibitted! Possible reasons: Account Suspended or Scheduled for deletion. Please contact an admin for help.';
			
			if(isset($_SESSION['isv_user_id'])){
				unset($_SESSION['isv_user_id']);
			}
			header('location:'.ISVIPI_URL.'');
			exit();
		} else {
			
		//this page will be loaded when the user is logged in
		include_once ISVIPI_ACT_THEME.'blank.php'; 
		
		}
	}