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
	 $array = array();
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		$from_url = ISVIPI_URL;
	 } else {
	 	$from_url = $_SERVER['HTTP_REFERER'];
	 }
	 /** check if our hidden field is present */
	 if (isset($_POST['isv_op']) && !empty($_POST['isv_op'])){
		 $operation = $converter->decode(cleanPOST('isv_op'));
	 } else if(isset($PAGE[2]) && !empty($PAGE[2])){
		 $operation = $converter->decode(cleanGET($PAGE[2]));
	 } else {
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	 }
	 
	 if ($operation !== 'registration'){
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	}
	require_once(ISVIPI_CLASSES_BASE .'forms/registration_cls.php');
	
	/*** REGISTRATION **/
	if ($operation === 'registration'){
		$array = array();
		
		//check if admin has allowed new user registration
		if (ALLOW_USER_REG){
			$_SESSION['isv_error'] = "Site registration is disabled.";
			header('location:'.ISVIPI_URL.'');
			exit();
		}
		
		//check if our date of birth fields have been supplied
		if(!isset($_POST['dd']) || empty($_POST['dd'])){
			 $array['err'] = true;
			 $array['message'] = 'Please enter Day of Birth. This is required.';
			 echo json_encode($array);
			 exit();
		}
		if(!isset($_POST['mm']) || empty($_POST['mm'])){
			 $array['err'] = true;
			 $array['message'] = 'Please enter Month of Birth. This is required.';
			 echo json_encode($array);
			 exit();
		}
		if(!isset($_POST['yyyy']) || empty($_POST['yyyy'])){
			 $array['err'] = true;
			 $array['message'] = 'Please enter Year of Birth. This is required.';
			 echo json_encode($array);
			 exit();
		}
		
		if(!is_numeric($_POST['dd']) || !is_numeric($_POST['mm']) || !is_numeric($_POST['yyyy'])){
			 $array['err'] = true;
			 $array['message'] = 'Invalid input for date of birth. Only numbers are allowed!';
			 echo json_encode($array);
			 exit();
		}
		
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
			 $array['err'] = true;
			 $array['message'] = 'The Date of Birth you provided is incorrect.';
			 echo json_encode($array);
			 exit();
		}
		
		/** capture our variables **/
		$userFields = array (
			'Username' => cleanPOST('username'),
			'Full Name' => cleanPOST('name'),
			'Email' => cleanPOST('email'),
			'Password' => cleanPOST('pwd'),
			'Repeat Password' => cleanPOST('pwd2'),
			'Country' => cleanPOST('country'),
			'Date of Birth' => $d_o_b,
			'Gender' => cleanPOST('sex')
		);
		
		//register new user
		$registerUser = new userRegistration($userFields);
	}
	
	