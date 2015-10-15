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
		$from_url = ISVIPI_URL;
	 }
	 $from_url = $_SERVER['HTTP_REFERER'];
	 /** check if our hidden field is present */
	 if (isset($_POST['isv_op']) && !empty($_POST['isv_op'])){
		 $operation = cleanPOST('isv_op');
	 } else if(isset($PAGE[2]) && !empty($PAGE[2])){
		 $operation = cleanGET($PAGE[2]);
	 } else {
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	 }
	 
	 if ($operation !== 'registration' && $operation !== 'validate' && $operation !== 'reset' && $operation !== 'change' && $operation !== 'signin' && $operation !== 'resend_activation'){
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	}
	require_once(ISVIPI_CLASSES_BASE .'forms/registration_cls.php');
	
	/*** REGISTRATION **/
	if ($operation === 'registration'){
		$array = array();
		//check if this option enabled
		if ($isv_siteSettings['user_reg'] === 0){
			$_SESSION['isv_error'] = "Site registration is disabled.";
			notFound404Err();
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
			'Date of Birth' => cleanPOST('dob'),
			'Gender' => cleanPOST('sex')
		);
		
		$registerUser = new userRegistration($userFields);
	}
	
	/** EMAIL ACCOUNT VALIDATION **/
	if ($operation === 'validate'){
		if (!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION['isv_error'] = 'No validation code was provided. Please check your email for the correct link.';
			notFound404Err();
			exit();
		}
		$code = cleanGET($PAGE[3]);
		$validate = new userValidation($code);
	}
	
	/*** RESET PASSWORD */
	if ($operation === 'reset'){
		require_once(ISVIPI_CLASSES_BASE .'forms/reset_cls.php');
		
		if (!isset($_POST['user']) || empty($_POST['user'])){
			$_SESSION['isv_error'] = 'Please enter your username or email address registered with us.';
			header('location:'.$from_url.'');
			exit();
		}
		$user = cleanPOST('user');
		if (emailOrUsername($user) == 'email'){
			$userType = 'email';
		} else {
			$userType = 'username';
		}
		
		$resetPWD = new resetPassword;
		$sendEmail = $resetPWD->resetPWD($user,$userType);
	}
	
	/*** CHANGE PASSWORD */
	if ($operation === 'change'){
		if ((!isset($_SESSION['isv_pwd_change_eml']) || empty ($_SESSION['isv_pwd_change_eml'])) 
		&& (!isset($_SESSION['isv_pwd_code']) || empty($_SESSION['isv_pwd_code']))){
			$_SESSION['isv_error'] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		$code = $_SESSION['isv_pwd_code'];
		$email = $_SESSION['isv_pwd_change_eml'];
		
		unset($_SESSION['isv_pwd_code'],$_SESSION['isv_pwd_change_eml']);
		
		//if someone managed to bypass the earlier check, we check again if the email and code supplied match our records
		global $isv_db;
		$stmt = $isv_db->prepare("SELECT id FROM user_validations WHERE code=? AND email=?");
		$stmt->bind_param('ss', $code,$email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($resetID);
		$stmt->fetch();
			if ($stmt->num_rows() < 1){
				$_SESSION['isv_error'] = 'An error occurred. Either your details were changed during processing or you supplied wrong details. Please try again.';
				header('location:'.$from_url.'');
				exit();
			}
		
		//check and capture our POST variables
		if ((!isset($_POST['pwd']) || empty($_POST['pwd'])) || (!isset($_POST['pwd2']) || empty($_POST['pwd2']))){
			$_SESSION['isv_error'] = 'Please check and ensure that you filled in the New Password and Repeat New Password fields.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$pwd = cleanPOST('pwd');
		$pwd2 = cleanPOST('pwd2');
		
		//check if the two match
		if ($pwd !== $pwd2){
			$_SESSION['isv_error'] = 'Your passwords do not match.';
			header('location:'.$from_url.'');
			exit();
		}
		
		//get user id from email
		$stmt->prepare("SELECT id FROM users WHERE email=?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($userID);
		$stmt->fetch();
		$stmt->close();
		
		//instantiate our password change class
		require_once(ISVIPI_CLASSES_BASE .'forms/changePWD_cls.php');
		$changePWD = new changePassword($userID,$pwd);
		
		//delete our password reset code
		$delCode = $changePWD->deleteResetCode($code);
		
		//return success
		$_SESSION['isv_success'] = 'Password changed successfully. You can now sign in with your new password.';
		header('location:'.ISVIPI_URL.'');
		exit();
	}
	
	/*** SIGN IN **/
	if ($operation === 'signin'){
		if(!isset($_POST['user']) || empty($_POST['user'])){
			$_SESSION['isv_error'] = 'Please enter your username or email.';
			header('location:'.ISVIPI_URL.'');
			exit();
		}
		if(!isset($_POST['pwd']) || empty($_POST['pwd'])){
			$_SESSION['isv_error'] = 'Please enter your password.';
			header('location:'.ISVIPI_URL.'');
			exit();
		}
		
		$user = cleanPOST('user');
		$pwd = cleanPOST('pwd');
		
		//check if it is email or username
		if (emailOrUsername($user) == 'email'){
			$userType = 'email';
		} else {
			$userType = 'username';
		}
		
		//instantiate our class
		require_once(ISVIPI_CLASSES_BASE .'forms/signin_cls.php');
		$signIn = new signIn($userType,$user,$pwd);
	}
	
	/*** RESEND ACTIVATION CODE **/
	if ($operation === 'resend_activation'){
		//check if our session exists
		if(!isset($_SESSION['act_email']) && empty($_SESSION['act_email'])){
			$_SESSION['isv_error'] = 'An error occured. Please try to sign in again and click activate to retry.';
			header('location:'.ISVIPI_URL.'');
			exit();
		}
		
		//resend activation email
		require_once(ISVIPI_CLASSES_BASE .'forms/signin_cls.php');
		$s = new resendActEmail();
	}