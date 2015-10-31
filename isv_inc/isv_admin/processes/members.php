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
	$track = new admin_security();
	
	require_once(ISVIPI_CLASSES_BASE .'utilities/encrypt_decrypt.php'); 
	$converter = new Encryption;
	
	if(!$track->admin_logged_in()){
		$entry = "A non-admin tried to access isv_admin/processes/members.php file.";
		$ip = get_user_ip();
		log_entry($entry,$ip);
		notFound404Err();
	}

	//prohibit direct access to this file
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		//log this entry
		$entry = "Someone tried to access isv_admin/processes/members.php directly.";
		$ip = get_user_ip();
		log_entry($entry,$ip);
		notFound404Err();
	 }
	 
	 $from_url = $_SERVER['HTTP_REFERER'];
	 
	 /** check if our hidden field is present */
	 if (isset($_POST['aop']) && !empty($_POST['aop'])){
		 $op = cleanPOST('aop');
	 } else if(isset($PAGE[2]) && !empty($PAGE[2])){
		 $op = $converter->decode($PAGE[2]);
	 } else {
		 $_SESSION['isv_error'] = 'An error occured. Invalid alterations detected.';
		 header('location:'.$from_url.'');
		 exit();
	 }
	 
	 if ($op !== 'act' && $op !== 'sus' && $op !== 'unsus' && $op !== 'del' && $op !== 'undel' && $op !== 'mass-act' && $op !== 'mass-sus' && $op !== 'mass-unsus' && $op !== 'mass-del' && $op !== 'mass-undel'){
		 $entry = "Someone interfered with admin member page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	//require our admin.cls file
	require_once(ISVIPI_ADMIN_CLS_BASE .'members.cls.php');
	$member = new member();
	
	if ($op === 'act'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION['isv_error'] = 'An error occured. User id was not supplied.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$m_id = $converter->decode($PAGE[3]);
		
		if(!is_numeric($m_id)){
			$_SESSION['isv_error'] = 'The supplied user id is incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$member->activate($m_id);
	}
	
	if ($op === 'sus'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION['isv_error'] = 'An error occured. User id was not supplied.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$m_id = $converter->decode($PAGE[3]);
		
		if(!is_numeric($m_id)){
			$_SESSION['isv_error'] = 'The supplied user id is incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$member->suspend($m_id);
	}
	
	if ($op === 'unsus'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION['isv_error'] = 'An error occured. User id was not supplied.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$m_id = $converter->decode($PAGE[3]);
		
		if(!is_numeric($m_id)){
			$_SESSION['isv_error'] = 'The supplied user id is incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$member->unsuspend($m_id);
	}
	
	if ($op === 'del'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION['isv_error'] = 'An error occured. User id was not supplied.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$m_id = $converter->decode($PAGE[3]);
		
		if(!is_numeric($m_id)){
			$_SESSION['isv_error'] = 'The supplied user id is incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$member->delete($m_id);
	}
	
	if ($op === 'undel'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION['isv_error'] = 'An error occured. User id was not supplied.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$m_id = $converter->decode($PAGE[3]);
		
		if(!is_numeric($m_id)){
			$_SESSION['isv_error'] = 'The supplied user id is incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$member->undelete($m_id);
	}
	
	
	if ($op === 'mass-act'){
		
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'Please select users to activate';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$users = cleanPOST('user_id');
		
		$member->mass_activate($users);
	}
	
	if ($op === 'mass-sus'){
		
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'Please select users to activate';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$users = cleanPOST('user_id');
		
		$member->mass_suspend($users);
		
	}
	
	if ($op === 'mass-unsus'){
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'Please select users to activate';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$users = cleanPOST('user_id');
		
		$member->mass_unsuspend($users);
		
	}
	
	if ($op === 'mass-del'){
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'Please select users to activate';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$users = cleanPOST('user_id');
		
		$member->mass_delete($users);
		
	}
	
	if ($op === 'mass-undel'){
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'Please select users to activate';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$users = cleanPOST('user_id');
		
		$member->mass_undelete($users);
		
	}