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
		$entry = "A non-admin tried to access isv_admin/processes/inquiry.php file.";
		$ip = get_user_ip();
		log_entry($entry,$ip);
		notFound404Err();
	}

	//prohibit direct access to this file
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		//log this entry
		$entry = "Someone tried to access isv_admin/processes/inquiry.php directly.";
		$ip = get_user_ip();
		log_entry($entry,$ip);
		notFound404Err();
	 }
	 
	 $from_url = $_SERVER['HTTP_REFERER'];
	 
	 /** check if our hidden field is present */
	 if (isset($_POST['aop']) && !empty($_POST['aop'])){
		 $op = $converter->decode(cleanPOST('aop'));
	 } else if(isset($PAGE[2]) && !empty($PAGE[2])){
		 $op = $converter->decode($PAGE[2]);
	 } else {
		 $_SESSION['isv_error'] = 'An error occured. Invalid alterations detected.';
		 header('location:'.$from_url.'');
		 exit();
	 }
	 
	 if ($op !== 'inquiry'){
		 $entry = "Someone interfered with admin emails page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
		require_once ISVIPI_CLASSES_BASE . 'emails/emails_cls.php';
		$send = new emails();
	
		//capture our post variables
		$replyTo = cleanPOST('replyTo');
		$email = "support@isvipi.org";
		$subject = cleanPOST('subject');
		$message = cleanPOST('msg');
		$name = "IsVipi OSSN";
		
		if(!isset($replyTo) || empty($replyTo)){
			$_SESSION['isv_error'] = 'Please enter the Reply To Email.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($subject) || empty($subject)){
			$_SESSION['isv_error'] = 'Please enter the subject of your inquiry';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($message) || empty($message)){
			$_SESSION['isv_error'] = 'Please enter the message of your inquiry';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$message = html_entity_decode ( $message );
		//validate email
		if(!filter_var($replyTo, FILTER_SANITIZE_EMAIL)){
			$_SESSION['isv_error'] = 'Please provide a valid Reply To Email';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$nmsg = "$message <br/>
		==================== <br/>
		Reply To: $replyTo
		";
		
		//send email
		$send->send_email($replyTo,$name,$subject,$nmsg);
		
		//return success
		$_SESSION['isv_success'] = 'Your inquiry has been sent';
		header('location:'.$from_url.'');
		exit();
