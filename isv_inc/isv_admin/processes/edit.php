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
	 
	 if ($op !== 'c_username' && $op !== 'c_email' && $op !== 'c_other' && $op !== 'profile'){
		 $entry = "Someone interfered with admin member page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	//require our admin.cls file
	require_once(ISVIPI_ADMIN_CLS_BASE .'edit_member.cls.php');
	$edit = new edit();
	
	if ($op === 'c_username'){
		if(!isset($_POST['username']) || empty($_POST['username'])){
			$_SESSION['isv_error'] = 'Please enter a username';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'No user id supplied';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$user_id = cleanPOST('user_id');
		$id = $converter->decode($user_id);
		
		$username = cleanPOST('username');
		
		//check length of the username (Minimum 6 characters)
		if(strlen($username) < 6 ){
			$_SESSION['isv_error'] = 'Username must be a minimum of 6 characters.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		$edit->change_username($username,$id);
		
	}
	
	if ($op === 'c_email'){
		if(!isset($_POST['email']) || empty($_POST['email'])){
			$_SESSION['isv_error'] = 'Please enter a email';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'No user id supplied';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$user_id = cleanPOST('user_id');
		$id = $converter->decode($user_id);
		
		$email = cleanPOST('email');
		
		//check length of the username (Minimum 6 characters)
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$_SESSION['isv_error'] = 'Wrong email format supplied.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		$edit->change_email($email,$id);
		
	}
	
	if ($op === 'c_other'){
		
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'No user id supplied';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$user_id = cleanPOST('user_id');
		$id = $converter->decode($user_id);
		
		$hobbies = cleanPOST('hobbies');
		$rel = cleanPOST('rel');
		
		$det = array(
			'hobbies' => $hobbies,
			'rel' => $rel,
			'user_id' => $id
		);
		$edit->change_other($det);
		
	}
	
	if ($op === 'profile'){
		//require our member class
		require_once(ISVIPI_CLASSES_BASE .'global/member_cls.php');
		
		//check if our variables have been supplied
		if(!isset($_POST['name']) || empty($_POST['name'])){
			$_SESSION['isv_error'] = 'Please enter member full name. This is required.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		if(!isset($_POST['dd']) || empty($_POST['dd'])){
			$_SESSION['isv_error'] = 'Please enter Day of Birth. This is required.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($_POST['mm']) || empty($_POST['mm'])){
			$_SESSION['isv_error'] = 'Please enter Month of Birth. This is required.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($_POST['yyyy']) || empty($_POST['yyyy'])){
			$_SESSION['isv_error'] = 'Please enter Year of Birth. This is required.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!is_numeric($_POST['dd']) || !is_numeric($_POST['mm']) || !is_numeric($_POST['yyyy'])){
			$_SESSION['isv_error'] = 'Invalid input for date of birth. Only numbers are allowed!';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
			$_SESSION['isv_error'] = 'No user id supplied';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//capture our POST variables
		$user_id = cleanPOST('user_id');
		$id = $converter->decode($user_id);
		
		$fullname = cleanPOST('name');
		$gender = cleanPOST('gender');
		$country = cleanPOST('country');
		$city = cleanPOST('city');
		$phone = cleanPOST('phone');
		
		//format date of birth
		$dd = cleanPOST('dd');
		
		//if day has only one character, we prepend 0
		if(strlen($dd) < 2){
			$dd = "0".$dd;
		}
		
		//if month has only one character, we prepend 0
		$mm = cleanPOST('mm');
		if(strlen($mm) < 2){
			$mm = "0".$mm;
		}
		$yyyy = cleanPOST('yyyy');
		
		//we join our date
		$d_array = array($dd,$mm,$yyyy);
		$d_o_b = implode('/',$d_array);
		
		//we then check if the date is correct
		if(!properDate($d_o_b, 'd/m/Y')){
			$_SESSION['isv_error'] = 'The Date of Birth you provided is incorrect.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//dump our variables into an array
		$det = array(
			'Full Name' => $fullname,
			'Gender' => $gender,
			'Date of Birth' => $d_o_b,
			'Country' => $country,
			'City' => $city,
			'Phone' => $phone,
		);
		
		//instantiate our class and update
		$update = new member($id);
		$update->edit_profile($det);
		
		//return success
		$_SESSION['isv_success'] = 'Profile Details updated successfully.';
		header('location:'.$from_url.'');
		exit();
		
	}