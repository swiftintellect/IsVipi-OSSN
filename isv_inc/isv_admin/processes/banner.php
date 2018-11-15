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
		$entry = "A non-admin tried to access isv_admin/processes/news.php file.";
		$ip = get_user_ip();
		log_entry($entry,$ip);
		notFound404Err();
	}

	//prohibit direct access to this file
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		//log this entry
		$entry = "Someone tried to access isv_admin/processes/news.php directly.";
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
	 
	 if ($op !== 'new' && $op !== 'delete'){
		 $entry = "Someone interfered with admin banner page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	if ($op === 'new'){
		$link = cleanPOST('link');
		
		if(!isset($_POST['ntab'])){
			$ntab = 0;
		} else {
			$ntab = 1;
		}
		
		//upload file
		if(!file_exists($_FILES['banner']['tmp_name']) || !is_uploaded_file($_FILES['banner']['tmp_name'])){
			$_SESSION['isv_error'] = 'Please select a banner image to upload';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		$target_dir = ISVIPI_UPLOADS_BASE."banners/";
		$newfilename = str_replace('.', '', str_replace(' ', '', microtime()) . 'banner').'.jpg';
		$target_file = $target_dir . $newfilename;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$_SESSION['isv_error'] = 'Only JPG, JPEG, PNG & GIF files are allowed.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		if (!move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
			$_SESSION['isv_error'] = 'An error occurred while uploading the file. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//save the news item
		$stmt = $isv_db->prepare("INSERT INTO isv_banners (banner,link,ntab,uploadtime) VALUES (?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('ssi',$newfilename,$link,$ntab);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'The banner has been uploaded successfully';
		header('location:'.$from_url.'');
		exit();
	}
	
	if ($op === 'delete'){
		$bid = cleanGET($PAGE[3]);
		
		if(empty($bid)){
			$_SESSION['isv_error'] = 'The banner ID is missing. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		$bid = $converter->decode($bid);
		
		//check if is numeric
		if(!is_numeric($bid)){
			$_SESSION['isv_error'] = 'The banner id supplied is invalid. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//get banner image
		$stmt = $isv_db->prepare("SELECT banner from isv_banners WHERE id=?");
		$stmt->bind_param('i',$bid);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($banner);
		$stmt->fetch();
		$stmt->close();
		
		//delete banner image if present
		if(file_exists(ISVIPI_UPLOADS_BASE . 'banners/'.$banner)){
			unlink(ISVIPI_UPLOADS_BASE . 'banners/'.$banner);
		}
		
		//delete
		$stmt = $isv_db->prepare("DELETE FROM isv_banners WHERE id=?");
		$stmt->bind_param('i',$bid);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'The banner has been deleted successfully';
		header('location:'.$from_url.'');
		exit();
	}