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
	 
	 if ($op !== 'new_news' && $op !== 'edit_news' && $op !== 'publish' && $op !== 'unpublish' && $op !== 'delete'){
		 $entry = "Someone interfered with admin news page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	if ($op === 'new_news'){
		$title = cleanPOST('title');
		$news = cleanPOST('news');
		$status = cleanPOST('status');
		
		if(!isset($title) || empty($title)){
			$_SESSION['isv_error'] = 'Please enter title';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($news) || empty($news)){
			$_SESSION['isv_error'] = 'Please enter news to publish';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($status) || empty($status)){
			$status = 0;
		} else {
			$status = 1;
		}
		
		//save the news item
		$stmt = $isv_db->prepare("INSERT INTO isv_news (title,news,status,pub_date) VALUES (?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('ssi',$title,$news,$status);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Your news item has been saved successfully';
		header('location:'.$from_url.'');
		exit();
	}
	
	if ($op === 'edit_news'){
		$title = cleanPOST('title');
		$news = cleanPOST('news');
		$news_id = cleanPOST('news_id');
		
		if(!isset($title) || empty($title)){
			$_SESSION['isv_error'] = 'Please enter title';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($news) || empty($news)){
			$_SESSION['isv_error'] = 'Please enter news to publish';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		if(!isset($news_id) || empty($news_id)){
			$_SESSION['isv_error'] = 'The news id has not been supplied';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//decode our news id
		$news_id = $converter->decode($news_id);
		
		//update
		$stmt = $isv_db->prepare("UPDATE isv_news set title=?,news=?,pub_date=UTC_TIMESTAMP() WHERE id=?");
		$stmt->bind_param('ssi',$title,$news,$news_id);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Your news item has been updated successfully';
		header('location:'.$from_url.'');
		exit();
	}
	
	if ($op === 'publish'){
		$news_id = cleanGET($PAGE[3]);
		$news_id = $converter->decode($news_id);
		
		//check if is numeric
		if(!is_numeric($news_id)){
			$_SESSION['isv_error'] = 'The news id supplied was incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//update
		$stmt = $isv_db->prepare("UPDATE isv_news set status=1 WHERE id=?");
		$stmt->bind_param('i',$news_id);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Your news item has been published successfully';
		header('location:'.$from_url.'');
		exit();
	}
	
	if ($op === 'unpublish'){
		$news_id = cleanGET($PAGE[3]);
		$news_id = $converter->decode($news_id);
		
		//check if is numeric
		if(!is_numeric($news_id)){
			$_SESSION['isv_error'] = 'The news id supplied was incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//update
		$stmt = $isv_db->prepare("UPDATE isv_news set status=0 WHERE id=?");
		$stmt->bind_param('i',$news_id);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Your news item has been unpublished successfully';
		header('location:'.$from_url.'');
		exit();
	}
	
	if ($op === 'delete'){
		$news_id = cleanGET($PAGE[3]);
		$news_id = $converter->decode($news_id);
		
		//check if is numeric
		if(!is_numeric($news_id)){
			$_SESSION['isv_error'] = 'The news id supplied was incorrect. Please try again.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		//delete
		$stmt = $isv_db->prepare("DELETE FROM isv_news WHERE id=?");
		$stmt->bind_param('i',$news_id);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Your news item has been deleted successfully';
		header('location:'.$from_url.'');
		exit();
	}