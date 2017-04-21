<?php
	//prohibit direct access to this file
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		//log this entry
		$entry = "Someone tried to access isv_admin/processes/photo_albums.php directly.";
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
	 
	 if ($op !== 'new_albm' && $op !== 'add' && $op !== 'del_alb' && $op !== 'del_photo'){
		 $entry = "Someone interfered with admin member page.";
		 $ip = get_user_ip();
		 log_entry($entry,$ip);
		 
		 $_SESSION['isv_error'] = 'An error occured. Invalid entries detected.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	require_once(ISVIPI_CLASSES_BASE .'forms/photo_albums_cls.php');
	
	if ($op === 'new_albm'){
		//require our photo albums class that will give us the number of albums so far
		require_once(ISVIPI_CLASSES_BASE .'global/get_photo_albums_cls.php');
		$alb = new get_photo_albums();
		$alb_count = $alb->album_count($_SESSION['isv_user_id']);
		
		//check if the limit for user albums has been reached
		if(MAX_PHOTO_ALBMS <= $alb_count){
			$_SESSION['isv_error'] = 'Your number of albums limit has been reached. Each member is entitled to '.MAX_PHOTO_ALBMS.' albums';
			header('location:'.$from_url.'');
			exit();
		}
	
		//check if title has been entered
		$alb_title = cleanPOST('title');
		
		if(empty($alb_title)){
			//generate title
			$alb_title = date("Y-m-d H:i:s");
		}
		
		//check if image is attached
		if (empty(array_filter($_FILES['files']['tmp_name']))){
			 $_SESSION['isv_error'] = 'Please select an image to upload.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		$photos = $_FILES['files'];
		
		/** change profile pic **/
		$alb = new photo_albums();
		$alb->new_album($photos,$alb_title);

	}
	
	if ($op === 'add'){
		//require our photo albums class that will give us the number of photos in that album so far
		require_once(ISVIPI_CLASSES_BASE .'global/get_photo_albums_cls.php');
		$alb = new get_photo_albums();
		
		//capture album id
		$album_id = $converter->decode(cleanPOST('album'));
		
		//get photo count
		$count = $alb->album_photo_count($album_id);
		
		//check if the limit for user albums has been reached
		if(MAX_PHOTOS_IN_ALBM <= $count){
			
			$_SESSION['isv_error'] = 'Your number of photos limit has been reached for this album. Each member is entitled to '.MAX_PHOTOS_IN_ALBM.' photos in each album';
			header('location:'.$from_url.'');
			exit();
		} else if(MAX_PHOTOS_IN_ALBM > $count){
			//check the difference between the remaining number to hit maximum and number of file being uploaded
			$diffr = MAX_PHOTOS_IN_ALBM - $count;
			
			//capture the number of files being uploaded
			$fcount = count($_FILES['files']['name']);
			
			//check if the number of files being uploaded is bigger than the difference
			if($fcount > $diffr){
				$_SESSION['isv_error'] = 'This album can only accept '.$diffr.' more photos. Your attempt to upload '.$fcount.' photos failed. Either delete some photos in the album or upload only '.$diffr.' photos.';
			 	header('location:'.$from_url.'');
			 	exit();
			}
		}
		
		if(!is_numeric($album_id)){
			 $_SESSION['isv_error'] = 'An error occurred. It appears the album id has been altered.';
			 header('location:'.$from_url.'');
			 exit();
		}

		//check if image is attached
		if (empty(array_filter($_FILES['files']['tmp_name']))){
			 $_SESSION['isv_error'] = 'Please select an image to upload.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		$photos = $_FILES['files'];
		
		/** change profile pic **/
		$alb = new photo_albums();
		$alb->add_photos($photos,$album_id);
	}
	
	if ($op === 'del_alb'){
		//check if album id is present
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			 $_SESSION['isv_error'] = 'Album id missing. Please try again.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//capture album id
		$alb_id = $converter->decode(cleanGET($PAGE[3]));
		
		//check if is numeric
		if(!is_numeric($alb_id)){
			 $_SESSION['isv_error'] = 'An error occured. The album id supplied was incorrect. Please try again.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//instantiate our class
		$action = new album_actions();
		$action->del_album($alb_id);
		
	}
	
	if ($op === 'del_photo'){
		//check if album id is present
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			 $_SESSION['isv_error'] = 'Photo id missing. Please try again.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//capture album id
		$photo_id = $converter->decode(cleanGET($PAGE[3]));
		
		//check if is numeric
		if(!is_numeric($photo_id)){
			 $_SESSION['isv_error'] = 'An error occured. The photo id supplied was incorrect. Please try again.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//instantiate our class
		$action = new album_actions();
		$action->del_photo($photo_id);
	}
	
	
 ?>