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
	 
	 if ($operation !== 'prof_pic' && $operation !== 'cover_pic'){
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