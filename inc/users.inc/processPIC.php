<?php
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.com

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
isLoggedIn();
$user = $_SESSION['user_id'];
getUserDetails($user);
$from_url = $_SERVER['HTTP_REFERER'];

$op = $_POST['op'];
if ($op !== 'newpic' && $op !== 'deletepic' && $op !== 'changecover')
	{
    $_SESSION['err'] =UNKNOWN_REQ;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}

/////////////////////////////////////////////////////////////
//////////////// UPLOAD PROFILE PIC //////////////////////
////////////////////////////////////////////////////////////
if ($op === 'newpic') {
function uploadFile ($file_field = null, $check_image = false, $random_name = true) {
	$from_url = $_SERVER['HTTP_REFERER'];
    if(isset($_POST['name'])){ $name = $_POST['name']; } 
  //Config Section    
  //Set file upload path
  $path = ISVIPI_USER_BASE.'thumbs/'; //with trailing slash
  //Set max file size in bytes
  $max_size = 1000000;
  $max_size2 = $max_size / 1000000;
  //Set default file extension whitelist
  $whitelist_ext = array('jpg','png','gif');
  //Set default file type whitelist
  $whitelist_type = array('image/jpeg', 'image/png','image/gif');
  $sizes = array(100 => 100, 150 => 150, 500 => 500);

  //The Validation
  // Create an array to hold any output
  $out = array('error'=>null);
               
  if (!$file_field) {
    {
    $_SESSION['err'] =E_INV_FORM_FIELD;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}           
  }

  if (!$path) {
    {
    $_SESSION['err'] =E_INV_UPL_PATH;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}               
  }
       
  //Make sure that there is a file
  if((!empty($_FILES[$file_field])) && ($_FILES[$file_field]['error'] == 0)) {
         
    // Get filename
    $file_info = pathinfo($_FILES[$file_field]['name']);
    $name = $file_info['filename'];
    $ext = $file_info['extension'];
               
    //Check file has the right extension           
    if (!in_array($ext, $whitelist_ext)) 
	{
    $_SESSION['err'] = E_WRONG_FILE_FORMAT;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}
               
    //Check that the file is of the right type
    if (!in_array($_FILES[$file_field]["type"], $whitelist_type)) {
    $_SESSION['err'] =E_WRONG_FILE_TYPE;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}
               
    //Check that the file is not too big
    if ($_FILES[$file_field]["size"] > $max_size) 
	{
    $_SESSION['err'] =E_FILE_TOO_LARGE.$max_size2."MB";
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}
               
    //If $check image is set as true
    if ($check_image) {
      if (!getimagesize($_FILES[$file_field]['tmp_name'])) 
	  {
    $_SESSION['err'] =E_INV_IMAGE;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}
    }
	$image_det = $_FILES[$file_field]['tmp_name'];
    //Create full filename including path
    if ($random_name) {
		getUserDetails($_SESSION['user_id']);
		global $username;
      // Generate random filename
      $tmp = str_replace(array('.',' '), array('',''), $username.'-'.microtime());
                       
      if (!$tmp || $tmp == '') 
	  {
    $_SESSION['err'] =E_IMG_NAME;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}
      $newname = $tmp.'.'.$ext;                                
    } else {
        $newname = $name.'.'.$ext;
    }
               
    //Check if file already exists on server
    if (file_exists($path.$newname)) 
	{
    $_SESSION['err'] =E_IMG_EXISTS;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
	}

    if (isset($_SESSION['err'])){if (count($_SESSION['err'])>0) 
	{
	$_SESSION['err'] =E_ERR_OCCUR;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
    } 
}
		foreach ($sizes as $w => $h) {
			$filept = getimagesize($_FILES[$file_field]['tmp_name']);
			$filenName = $_FILES[$file_field]['tmp_name'];
			$filenType = $_FILES[$file_field]["type"];
				$files[] = GenThumbs($w, $h, $filept, $filenName, $filenType, $newname);
			}
    //if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $path.$newname)) {
		
      //Success
     // $out['filepath'] = $path;
      //$out['filename'] = $newname;
	  global $db;
	  $user_id = get_post_var('userid');
	  $name = $newname;
	//Update thumbnail name to member_sett table
	$upoprf = $db->prepare('UPDATE member_sett set thumbnail=? where user_id=?');
		$upoprf->bind_param('si', $name,$user_id);
		$upoprf->execute();
     //return $out;
    //} else $_SESSION['err'] ="System error. Please try again";
	//$user_id = $_SESSION['user_id'];
    //header ('location:'.$from_url.'');
	//exit();
         
  } else $_SESSION['err'] =E_ERR_OCCUR;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
}
if (isset($_POST['submit'])) {
  $file = uploadFile('file', true, true);
  
     //Update timeline/activity feeds
	 getUserDetails($_SESSION['user_id']);
	 $activity = S_FEED_UPL;
	 updateTimeline($_SESSION['user_id'],$username,$activity);
	$_SESSION['succ'] =S_FILE_UPL;
	$user_id = $_SESSION['user_id'];
    header ('location:'.$from_url.'');
	exit();
  }
$db->close();
}
/////////////////////////////////////////////////////////////
//////////////// UPLOAD PROFILE PIC //////////////////////
////////////////////////////////////////////////////////////
if ($op === 'changecover') {
	function uploadFile ($file_field = null, $check_image = false, $random_name = false) {
		global $newname;
  	  $path = ISVIPI_USER_BASE.'thumbs/coverphotos/'; //with trailing slash
	  $max_size = 2000000;
	  $whitelist_ext = array('jpg','png','gif');
	  $whitelist_type = array('image/jpeg', 'image/png','image/gif');
	
	  //The Validation
	  $out = array('error'=>null);
				   
	  if (!$file_field) {
		$out['error'][] = E_IS_EMPTY;           
	  }
	
	  if (!$path) {
		$out['error'][] = E_SYS_ERR;               
	  }
		   
	  if (count($out['error'])>0) {
		return $out;
	  }
	
	  //Make sure that there is a file
	  if((!empty($_FILES[$file_field])) && ($_FILES[$file_field]['error'] == 0)) {
			 
		// Get filename
		$file_info = pathinfo($_FILES[$file_field]['name']);
		$name = $file_info['filename'];
		$ext = $file_info['extension'];
				   
		//Check file has the right extension           
		if (!in_array($ext, $whitelist_ext)) {
		  $out['error'][] = E_WRONG_FILE_FORMAT;
		}
				   
		//Check that the file is of the right type
		if (!in_array($_FILES[$file_field]["type"], $whitelist_type)) {
		  $out['error'][] = E_WRONG_FILE_TYPE;
		}
				   
		//Check that the file is not too big
		if ($_FILES[$file_field]["size"] > $max_size) {
		  $out['error'][] = E_FILE_TOO_LARGE."2MB";
		}
		
		// restrict width and height if its image or photo file
		list($width, $height, $type, $attr) = getimagesize($_FILES[$file_field]['tmp_name']);
		
		if ($width > 1000 || $height > 240){
			$out['error'][] = E_EXCEEDED_HEIGHT_WIDTH;
		}
				   
		//If $check image is set as true
		if ($check_image) {
		  if (!getimagesize($_FILES[$file_field]['tmp_name'])) {
			$out['error'][] = E_INV_IMAGE;
		  }
		}
	
		//Create full filename including path
		if ($random_name) {
		  // Generate random filename
		  $tmp = str_replace(array('.',' '), array('',''), microtime());
						   
		  if (!$tmp || $tmp == '') {
			$out['error'][] = E_SYS_ERR;
		  }     
		  $newname = $tmp.'.'.$ext;                                
		} else {
			$newname = $name.'.'.$ext;
		}
				   
		//Check if file already exists on server
		if (file_exists($path.$newname)) {
		  $out['error'][] = E_IMG_EXISTS;
		}
	
		if (count($out['error'])>0) {
		  //The file has not correctly validated
		  return $out;
		} 
	
		if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $path.$newname)) {
		  //Success
		  $out['filepath'] = $path;
		  $out['filename'] = $newname;
		  return $out;
		} else {
		  $out['error'][] = E_SYS_ERR;
		}
			 
	  } else {
		$out['error'][] = E_SYS_ERR;
		return $out;
	  }      
	}
	
	//we then upload our file
	  $file = uploadFile('cover', true, true);
	  if (is_array($file['error'])) {
		$message = '';
		foreach ($file['error'] as $msg) {
		  $_SESSION['err'] = $msg;
		  header('location:'.$from_url.'');
		  exit();   
		}
	  } else {
	  		$_SESSION['succ'] = S_SUCCESS;
			//we save in our database
			global $db;
			$stmt = $db->prepare('UPDATE member_sett set cover=? where user_id=?');
			$stmt->bind_param('si', $newname,$_SESSION['user_id']);
			$stmt->execute();
			$stmt->close();
	  }
		  header('location:'.$from_url.'');
		  exit(); 
}
?>