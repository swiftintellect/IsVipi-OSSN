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
	
	//force sign in if the user is not signed in already
	if (!isLoggedIn() && !$admin->admin_logged_in()){
		$linkTo = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['isv_pre_signIn_url'] = $linkTo;
		$_SESSION['isv_error'] = 'You must be signed in to view this page.';
		require_once(ISVIPI_PAGES_BASE .'sign_in.php');
		exit();
	}
	
	//check if the user has status active
	if (!isStatusActive() && !$admin->admin_logged_in()){
		$_SESSION['isv_error'] = 'Prohibitted! Possible reasons: Account Suspended or Scheduled for deletion. Please contact an admin for help.';
		
		if(isset($_SESSION['isv_user_id'])){
			unset($_SESSION['isv_user_id']);
		}
		header('location:'.ISVIPI_URL.'');
		exit();
	}
	
	/** require our members class **/
	require_once(ISVIPI_CLASSES_BASE .'global/member_cls.php');
	$member = new member($_SESSION['isv_user_id']);
	$memberinfo = $member->memberDetails();

	/** Page Manager **/
	$pageManager = new pageManager();
	$s_m = $pageManager->siteMeta();
	
	/** Site Details & Settings */
	$siteInfo = new siteManager();
	$isv_siteDetails = $siteInfo->getSiteInfo();
	$isv_siteSettings = $siteInfo->getSiteSettings();
	
	/*** check if the site is active or on maintenance mode */
	$siteInfo->maintenanceMode();
