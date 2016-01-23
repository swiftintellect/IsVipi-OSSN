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
		 $operation = $converter->decode(cleanPOST('isv_op'));
	 } else if(isset($PAGE[2]) && !empty($PAGE[2])){
		 $operation = $converter->decode(cleanGET($PAGE[2]));
	 } else {
		 $_SESSION['isv_error'] = 'Action not Allowed!';
		 header('location:'.$from_url.'');
		 exit();
	 }
	 
	 if ($operation !== 'f_req' && $operation !== 'f_accept' && $operation !== 'f_ignore' 
	 && $operation !== 'f_remove' && $operation !== 'f_block' && $operation !== 'f_unblock' && $operation !== 'f_delete'){
		 $_SESSION['isv_error'] = 'Action not Allowed!';
		 header('location:'.$from_url.'');
		 exit();
	}
	require_once(ISVIPI_CLASSES_BASE .'forms/friends_cls.php');
	
	/*** SEND FRIEND REQUEST **/
	if ($operation === 'f_req'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION[''] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$user_to_id = $converter->decode(cleanGET($PAGE[3]));
		
		//strip non numeric characters
		$user_to_id = preg_replace('/[^0-9,.]+/i', '', $user_to_id);
		
		/** send the friend request **/
		$f_rquest = new friends();
		$f_rquest->sendFriendReq($user_to_id);
		
	}

	/*** ACCEPT FRIEND REQUEST **/
	if ($operation === 'f_accept'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION[''] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$fr_req_id = $converter->decode(cleanGET($PAGE[3]));
		$userSent = $converter->decode(cleanGET($PAGE[4]));
		
		//strip non numeric characters
		$fr_req_id = preg_replace('/[^0-9,.]+/i', '', $fr_req_id);
		$userSent = preg_replace('/[^0-9,.]+/i', '', $userSent);
		
		/** accept the friend request **/
		$f_rquest = new friends();
		$f_rquest->acceptFriendReq($fr_req_id,$userSent);
	}
	
	/*** IGNORE FRIEND REQUEST **/
	if ($operation === 'f_ignore'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION[''] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$fr_req_id = $converter->decode(cleanGET($PAGE[3]));
		
		//strip non numeric characters
		$fr_req_id = preg_replace('/[^0-9,.]+/i', '', $fr_req_id);
		
		/** ignore the friend request **/
		$f_ignore = new friends();
		$f_ignore->ignoreFriendReq($fr_req_id);
	}
	
	/*** REMOVE FRIEND/UNFRIEND **/
	if ($operation === 'f_remove'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION[''] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$friend_id = $converter->decode(cleanGET($PAGE[3]));
		
		/** unfriend the user **/
		$f_remove = new friends();
		$f_remove->un_friend($friend_id);
	}
	
	/*** BLOCK USER **/
	if ($operation === 'f_block'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION[''] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$user_id = $converter->decode(cleanGET($PAGE[3]));
		
		/** block this user **/
		$block = new friends();
		$block->block_user($user_id);
	}
	
	/*** UNBLOCK USER **/
	if ($operation === 'f_unblock'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION[''] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$user_id = $converter->decode(cleanGET($PAGE[3]));
		
		/** unblock this user **/
		$unblock = new friends();
		$unblock->unblock_user($user_id);
	}
	
	/*** DELETE FRIEND REQUEST **/
	if ($operation === 'f_delete'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			$_SESSION[''] = 'An error occurred. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		$fr_id = $converter->decode(cleanGET($PAGE[3]));
		
		/** delete friend request **/
		$del_fr = new friends();
		$del_fr->delete_friend_request($fr_id);
	}
