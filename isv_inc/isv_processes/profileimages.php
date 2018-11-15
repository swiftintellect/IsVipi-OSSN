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
		 header('location:'.$from_url.'');
		 exit();
	 }

	/*** CHANGE PROFILE PICTURE **/
		
		 //check if an image is set
		if (!isset($_POST['image-data']) || empty($_POST['image-data'])) {
			 $_SESSION['isv_error'] = "Please select an image for your cover photo.";
			 header('location:'.$from_url.'');
			 exit();
		}

		//decode image and save it
		$save_path = ISVIPI_UPLOADS_BASE .'cover/';
		
		$newfilename = str_replace('.', '', $_SESSION['isv_user_id'] . str_replace(' ', '', microtime())).'.jpg';
		$filename_path = $save_path.$newfilename; 
		$cover = base64_to_jpeg($_POST['image-data'],$filename_path);
		
		//save in the database
		$stmt = $isv_db->prepare("UPDATE user_profile SET cover_photo=? WHERE user_id=?");
		$stmt->bind_param('si',$newfilename,$_SESSION['isv_user_id']);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = "Cover photo changed successfully.";
		header('location:'.$from_url.'');
		exit();
