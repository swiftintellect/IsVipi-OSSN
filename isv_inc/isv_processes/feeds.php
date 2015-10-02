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
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	 }
	 
	 if ($operation !== 'new-feed' && $operation !== 'img-feed'){
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	}
	require_once(ISVIPI_CLASSES_BASE .'forms/feeds_cls.php');
	
	/*** NEW TEXT FEED **/
	if ($operation === 'new-feed'){
		if (!isset($_POST['feed']) || empty($_POST['feed'])){
			 $array['err'] = true;
			 $array['message'] = 'You cannot submit an empty feed.';
			 echo json_encode($array);
			 exit();
		}
		
		/** clean our variable and format it accordingly **/
		$newFeed = cleanPOST('feed');
		$newFeed = str_replace("  ","",$newFeed);
		$newFeed = nl2br($newFeed);
		
		/** add our feed **/
		$addFeed = new feeds($newFeed,'text');
		
	}
	
	/** NEW IMAGE FEED **/
	if ($operation === 'img-feed'){
		
		//check if there is any text attached to this post
		if (!isset($_POST['feed']) || empty($_POST['feed'])){
			$feed = "";
		} else {
			$feed = cleanPOST('feed');
		}
		if (!is_uploaded_file($_FILES['feedImg']['tmp_name'])) {
		   	 $array['err'] = true;
			 $array['message'] = 'Please select an image to upload';
			 echo json_encode($array);
			 exit();
		}
		
		$image = $_FILES['feedImg'];
		
		$post = array(
			'text' => $feed,
			'image' => $image
		);
		
		/** add our feed **/
		$addPhotoFeed = new feeds($post,'img');
		
		
	}