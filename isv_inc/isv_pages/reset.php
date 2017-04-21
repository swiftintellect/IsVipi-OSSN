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
	require_once(ISVIPI_PAGES_BASE .'base.php'); 
	if (!isset($PAGE[1]) || empty($PAGE[1])){
		$_SESSION['isv_error'] = 'Password reset code not found';
		header('location:'.ISVIPI_URL .'404/');
		exit();
	}
	$rCode = cleanGET($PAGE[1]);
	
	//check to see if the reset code exists
	if(!valid_codeExists($rCode,'code')){
		$_SESSION['isv_error'] = 'No such password reset code found in our database';
		header('location:'.ISVIPI_URL .'404/');
		exit();
	}
	$_SESSION['isv_pwd_change_eml'] = $exstEmail;
	$_SESSION['isv_pwd_code'] = $rCode;
	
 	include_once ISVIPI_ACT_THEME.'reset.php'; 
