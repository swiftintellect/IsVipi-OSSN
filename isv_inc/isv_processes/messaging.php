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
	 require_once(ISVIPI_CLASSES_BASE .'global/messaging_cls.php'); 
	 require_once(ISVIPI_CLASSES_BASE .'utilities/encrypt_decrypt.php'); 
	 $converter = new Encryption;
	
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
	 
	 if ($operation !== 'send_pm' && $operation !== 'last_msg_id'){
		 $_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	/*** ADD MESSAGE **/
	if ($operation === 'send_pm'){
		
		$message = cleanPOST('msg');
		$message = str_replace("  ","",$message);
		$message = preg_replace('/^[ \t]*[\r\n]+/m', '', $message);
		
		//check if message is supplied
		if(!isset($message) || empty($message) || ctype_space($message)){
			$_SESSION['isv_error'] = 'You cannot send a blank message';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		$message = nl2br($message);
		
		//check if the user to is supplied
		if(!isset($_POST['to']) || empty($_POST['to'])){
			$_SESSION['isv_error'] = 'Message recipient not specified.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		$to = cleanPOST('to');
		$to_msg = $converter->decode($to);
		
		//instantiate our message class	
		
		$pm = new message();
		$pm->send_message($message,$to_msg);	
	}
	
	/*** CHECK LAST MESSAGE ID **/
	if ($operation === 'last_msg_id'){
		$other_user = cleanPOST('other_user');
		//check is the user we are chatting with is set
		if(!isset($other_user) || empty($other_user)){
			exit();
		}
		
		//instantiate our class
		require_once(ISVIPI_CLASSES_BASE .'global/getMessages_cls.php'); 
		$pm = new get_messages();
		$id_from_db = $pm->last_msg_id($_SESSION['isv_user_id'],$other_user);
		
		echo $id_from_db;
	
		exit();
	}