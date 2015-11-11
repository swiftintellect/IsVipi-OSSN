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
 	global $PAGE,$p,$siteInfo;
	
	if(!isset($PAGE[0]) || empty($PAGE[0])){
		$p = '';
	} else {
		$p = $PAGE[0];
	}
	
	//if logged in, redirect to member page
	if (isLoggedIn()){
		header('location:'.ISVIPI_URL.'home/');
		exit();
	}
	
	/** instantiate pageManager **/
	$pageManager = new pageManager();
	$s_m = $pageManager->siteMeta();
	
	/** instantiate site_settings */
	$siteInfo = new siteManager();
	$isv_siteDetails = $siteInfo->getSiteInfo();
	$isv_siteSettings = $siteInfo->getSiteSettings();
	
	/*** check if the site is active or on maintenance mode */
	$siteInfo->maintenanceMode();
