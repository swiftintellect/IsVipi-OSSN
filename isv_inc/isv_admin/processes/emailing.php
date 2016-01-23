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
		$entry = "A non-admin tried to access isv_admin/processes/emailing.php file.";
		$ip = get_user_ip();
		log_entry($entry,$ip);
		notFound404Err();
	}

	//prohibit direct access to this file
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		//log this entry
		$entry = "Someone tried to access isv_admin/processes/emailing.php directly.";
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
	 
	 if ($op !== 's_email' && $op !== 'm_email'){
		 $entry = "Someone interfered with admin emails page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	//require our emails class file
	require_once ISVIPI_CLASSES_BASE . 'emails/emails_cls.php';
	$send = new emails();
	
	if ($op === 's_email'){
		//capture our post variables
		$email = cleanPOST('email');
		$subject = cleanPOST('subject');
		$message = cleanPOST('msg');
		
		if(!isset($email) || empty($email)){
			$_SESSION['isv_error'] = 'Please enter an email';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($subject) || empty($subject)){
			$_SESSION['isv_error'] = 'Please enter a subject';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($message) || empty($message)){
			$_SESSION['isv_error'] = 'Please enter a message';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//validate email
		if(!filter_var($email, FILTER_SANITIZE_EMAIL)){
			$_SESSION['isv_error'] = 'Please provide a valid email';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//check if a user with this email exists
		global $isv_db;
		
		$stmt = $isv_db->prepare("
			SELECT 
				p.fullname
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			WHERE u.email=?
		");
		$stmt->bind_param('s',$email);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($fullname); 
		$stmt->fetch();
		$stmt->close();
		
		if(!isset($fullname) || empty($fullname)){
			$name = "guest";
		} else {
			$name = $fullname;
		}
		
		//send email
		$send->send_email($email,$name,$subject,$message);
		
		//return success
		$_SESSION['isv_success'] = 'Your email has been sent';
		header('location:'.$from_url.'');
		exit();
	}
	
	if($op === 'm_emaily'){
		require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php');
		$members = new get_members();
	
		//capture our post variables
		$type = cleanPOST('type');
		$subject = cleanPOST('subject');
		$message = cleanPOST('msg');
		
		if(!isset($type) || empty($type)){
			$_SESSION['isv_error'] = 'Please select a user group to send emails to';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($subject) || empty($subject)){
			$_SESSION['isv_error'] = 'Please enter a subject';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($message) || empty($message)){
			$_SESSION['isv_error'] = 'Please enter a message';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		if($type !== "all" && $type !== "active" && $type !== "inactive" && $type !== "suspended" && $type !== "pending_deletion"){
			$_SESSION['isv_error'] = 'Please select a valid user group.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		if($members->total($type) < 1){
			$_SESSION['isv_error'] = 'There are no members in that user group and therefore no message will be sent.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//build our query
		if($type === "all"){
			$query = "";
		} else if($type === "active"){
			$query = " WHERE u.status=1 ";
		} else if($type === "inactive"){
			$query = " WHERE u.status=0 ";
		} else if($type === "suspended"){
			$query = " WHERE u.status=2 ";
		} else if($type === "pending_deletion"){
			$query = "WHERE u.status=9 ";
		}
		
		
		//extract important info from the chosen user group
		global $isv_db;
		
		$stmt = $isv_db->prepare("
			SELECT 
				u.email,
				p.fullname
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			$query
		");
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($email,$fullname); 
		
		while($stmt->fetch()){
			$m_load[] = array(
				'email' => $email,
				'fullname' => $fullname
			);
		}
		$stmt->close();
		
		//send our mail
		foreach ($m_load as $key => $mi) {
			$send->custom_email($mi['email'],$subject,$mi['fullname'],$message);
		}
		
		//return success
		$_SESSION['isv_success'] = 'Mass messages sent successfully.';
		header('location:'.$from_url.'');
		exit();
		
	}