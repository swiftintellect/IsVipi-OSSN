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
global $PAGE,$p;
	if(!isset($PAGE[0]) || empty($PAGE[0])){
		$p = '';
	} else {
		$p = $PAGE[0];
	}
	
	//if logged in, redirect to member page
	if (!isLoggedIn()){
		$_SESSION['isv_error'] = '404 Error: The page you are looking for could not be found or you go not have permission to view it.';
		header('location:'.ISVIPI_URL.'err_404/');
		exit();
	}
	
	/** instantiate site_settings */
	$siteInfo = new siteManager();
	$isv_siteDetails = $siteInfo->getSiteInfo();
	$isv_siteSettings = $siteInfo->getSiteSettings();
	
	/** require our members class **/
	require_once(ISVIPI_CLASSES_BASE .'global/member_cls.php');
	$member = new member($_SESSION['isv_user_id']);
	$memberinfo = $member->memberDetails();

	/** Page Manager **/
	$pageManager = new pageManager();
	$s_m = $pageManager->siteMeta();

 	include_once ISVIPI_ACT_THEME.'err_404.php'; 
