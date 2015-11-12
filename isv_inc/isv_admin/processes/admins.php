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
	
	global $isv_siteDetails;
	
	if(!$track->admin_logged_in()){
		$entry = "A non-admin tried to access isv_admin/processes/admins.php file.";
		$ip = get_user_ip();
		log_entry($entry,$ip);
		notFound404Err();
	}

	//prohibit direct access to this file
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		//log this entry
		$entry = "Someone tried to access isv_admin/processes/admins.php directly.";
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
	 
	 if ($op !== 'edit' && $op !== 'change_pwd'){
		 $entry = "Someone interfered with admin member page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	if ($op === 'edit'){
		
		//capture our post variables
		$email = cleanPOST('email');
		$name = cleanPOST('name');
		
		if(!isset($email) || empty($email)){
			$_SESSION['isv_error'] = 'Please fill in your admin email';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($name) || empty($name)){
			$_SESSION['isv_error'] = 'Please fill in your admin name';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//update
		global $isv_db;
		$stmt = $isv_db->prepare("UPDATE isv_admin SET email=?,name=? WHERE id=?");
		$stmt->bind_param('ssi',$email,$name,$_SESSION['isv_admin_id']);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Admin details updated successfully.';
		header('location:'.$from_url.'');
		exit();
	}

	if ($op === 'change_pwd'){
		//capture our post variables
		$c_pwd = cleanPOST('c_pwd');
		$pwd = cleanPOST('pwd');
		$pwd2 = cleanPOST('pwd2');
		
		if(!isset($c_pwd) || empty($c_pwd)){
			$_SESSION['isv_error'] = 'Please enter your current password';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($pwd) || empty($pwd)){
			$_SESSION['isv_error'] = 'Please enter your new password';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($pwd2) || empty($pwd2)){
			$_SESSION['isv_error'] = 'Please enter your repeat new password';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//check if the password is long enough
		if(strlen($pwd) < 8){
			$_SESSION['isv_error'] = 'Your new password is too short. A password MUST be a minimum of 8 characters';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//check if new and repeat new passwords match
		if($pwd !== $pwd2){
			$_SESSION['isv_error'] = 'Your new password and repeat new password do not match.';
		 	header('location:'.$from_url.'');
		 	exit();
			
		}
		
		//check if the new password matches the old one
		if($pwd === $c_pwd){
			$_SESSION['isv_error'] = 'Your new password matches your old password.';
		 	header('location:'.$from_url.'');
		 	exit();
			
		}
		
		//get the admins password from the db
		global $isv_db;
		
		$stmt = $isv_db->prepare("SELECT email,pwd FROM isv_admin WHERE id=?");
		$stmt->bind_param('i',$_SESSION['isv_admin_id']);
		$stmt->execute(); 
		$stmt->store_result();
		$stmt->bind_result($db_email,$db_pwd);
		$stmt->fetch();
		
		//check if current password matches old password
		if (!password_verify($c_pwd, $db_pwd)) {
			$_SESSION['isv_error'] = 'Your current password does not match the one in the database';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//hash the new password
		$new_pwd = password_hash($pwd, PASSWORD_DEFAULT);
		
		//update new password
		$stmt = $isv_db->prepare("UPDATE isv_admin SET pwd=? WHERE id=?");
		$stmt->bind_param('si',$new_pwd,$_SESSION['isv_admin_id']);
		$stmt->execute();
		$stmt->close();
		
		//email admin
		$msg = "Your password was changed to $pwd. If you did not make this change, please log into your admin account and change the password.";
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: '.$isv_siteDetails['s_title'].' <'.$isv_siteDetails['s_email'].'>' . "\r\n";
		// send email
		mail($db_email,"Admin Password Changed",$msg,$headers);
		
		//return success
		header('location:'.ISVIPI_ACT_ADMIN_URL.'log_out');
		exit();
	}