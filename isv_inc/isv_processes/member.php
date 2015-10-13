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
	 
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		$_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		notFound404Err();
		exit();
	 }
	 
	 $from_url = $_SERVER['HTTP_REFERER'];
	 
	 /** check if he is a logged in user **/
	 if(!isLoggedIn()){
		 $_SESSION['isv_error'] = "You must be logged in to complete this action.";
		 header('location:'.ISVIPI_URL.'sign_in');
		 exit();
	 }
	 
	 /** an extra layer of security => check if there is a session matching these details in the database **/
	 $currSession = session_id();
	 $currentUser = $_SESSION['isv_user_id'];
	 if (!isMemberSessionValid($currentUser,$currSession)){
		 $_SESSION['isv_error'] = "Your session either changed or expired. Please sign in to continue.";
		 header('location:'.ISVIPI_URL.'sign_in');
		 exit();
	 }
	 /** check if our hidden field is present */
	 if (isset($_POST['isv_op']) && !empty($_POST['isv_op'])){
		 $operation = cleanPOST('isv_op');
	 } else if(isset($PAGE[2]) && !empty($PAGE[2])){
		 $operation = cleanGET($PAGE[2]);
	 } else {
		 $_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		 header('location:'.$from_url.'');
		 exit();
	 }
	 
	 if ($operation !== 'prof_pic' && $operation !== 'cover_pic' && $operation !== 'edit_prof' && $operation !== 'c_pwd'){
		 $_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		 header('location:'.$from_url.'');
		 exit();
	}
	require_once(ISVIPI_CLASSES_BASE .'global/member_cls.php');
	
	/*** CHANGE PROFILE PICTURE **/
	if ($operation === 'prof_pic'){
		
		//check if an image is set
		if (!is_uploaded_file($_FILES['p_pic']['tmp_name'])) {
			 $_SESSION['isv_error'] = 'Please select an image to upload.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		$image = $_FILES['p_pic'];
		
		/** change profile pic **/
		$ppic = new member($_SESSION['isv_user_id']);
		$ppic->profile_pic($image);
	}
	
	/*** CHANGE COVER PICTURE **/
	if ($operation === 'cover_pic'){
		
		//check if an image is set
		if (!is_uploaded_file($_FILES['cover']['tmp_name'])) {
			 $_SESSION['isv_error'] = 'Please select an image to upload.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		$cover = $_FILES['cover'];
		
		/** change cover pic **/
		$ppic = new member($_SESSION['isv_user_id']);
		$ppic->cover_photo($cover);
	}
	
	/*** EDIT PROFILE **/
	if ($operation === 'edit_prof'){
		/** capture our fields **/
		$userFields = array (
			'Full Name' => cleanPOST('fname'),
			'Gender' => cleanPOST('gender'),
			'Date of Birth' => cleanPOST('dob'),
			'Phone' => cleanPOST('phone'),
			'Country' => cleanPOST('country'),
			'City' => cleanPOST('city'),
			'Relationship' => cleanPOST('relnship'),
			'Hobbies' => cleanPOST('hobbies')
		);
		
		/** edit profile **/
		$edit = new member($_SESSION['isv_user_id']);
		$edit->edit_profile($userFields);
	}
	
	/*** CHANGE PASSWORD **/
	if ($operation === 'c_pwd'){
		
		//capture fields
		$pwd = array (
			'Current Password' => cleanPOST('c_pwd'),
			'New Password' => cleanPOST('n_pwd'),
			'Repeat New Password' => cleanPOST('rn_pwd')
		);
		
		//check if any has not been supplied
		foreach( $pwd as $field => $value){
			if(!isSupplied($value)){
				 $_SESSION['isv_error'] = 'Please fill in '.$field.'!';
				 header('location:'.$from_url.'');
				 exit();
			}
		}
		
		//check if any is less than 8 characters long
		foreach( $pwd as $field => $value){
			if(strlen($value) < 8){
				 $_SESSION['isv_error'] = ''.$field.' must be a minimum of 8 characters.';
				 header('location:'.$from_url.'');
				 exit();
			}
		}
		
		//check if new and repeat passwords match
		if ($pwd['New Password'] !== $pwd['Repeat New Password']){
				$_SESSION['isv_error'] = 'New Password and Repeat New Password do not match.';
				header('location:'.$from_url.'');
				exit();
		}
		
		//change
		$change_pwd = new member($_SESSION['isv_user_id']);
		$change_pwd->change_pwd($pwd);
	}