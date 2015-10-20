<?php
function cleanPOST($var){
	$val = @$_POST[$var];
	if (get_magic_quotes_gpc())
		$val = stripslashes($val);
	return $val;
}

function cleanGET($var){
		return stripslashes($var);
}

function isSupplied($var){
	if (isset($var) && !empty($var)){
		return TRUE;
	} else {
		return FALSE;
	}
}
function notFound404Err(){
	require_once(ISVIPI_PAGES_BASE .'404.php');
}

function siteTitle($p){
	$page = new pageManager;
	echo $page->siteTitle($p);
}

function footerCopyright(){
	$page = new pageManager;
	$loadCopyright = $page->footerText();
}

function checkUserSession($sess_id){
	global $isv_db,$sessFound;
	$stmt = $isv_db->prepare("SELECT id FROM sessions where sess_id=?");
	$stmt->bind_param('s',$sess_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($foundSess_id);
	$stmt->fetch();
	$sessFound = $stmt->num_rows();
	$stmt->close();
}

function isStatusActive(){
	global $isv_db;
	$stmt = $isv_db->prepare("SELECT last_activity FROM users where id=? AND status=1");
	$stmt->bind_param('i',$_SESSION['isv_user_id']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($lastActivity);
	$stmt->fetch();
		if ($stmt->num_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	$stmt->close();
	
}

function regCountrySelectOptions(){
	global $isv_db,$countryISO,$countryName,$countryPhoneCode;
	$stmt = $isv_db->prepare("SELECT iso,nicename,phonecode FROM countries");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($countryISO,$countryName,$countryPhoneCode);
		while ($stmt->fetch()){
			echo "<option value=".$countryName.">$countryName</option>";
		}
	$stmt->close();
}

function memberCountry($country){
	global $isv_db,$countryISO,$countryName,$countryPhoneCode;
	$stmt = $isv_db->prepare("SELECT iso,nicename,phonecode FROM countries");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($countryISO,$countryName,$countryPhoneCode);
		while ($stmt->fetch()){
			echo "<option " .$countryName . ( $country == $countryName ? ' selected' : '' ) . ">$countryName</option>";
		}
	$stmt->close();
}

function relOptions($rel){
	$statuses = array( 
		'Single', 
		'Married', 
		'In a relationship',
		'Divorced',
		'It is Complicated',
		'Open Relationship',
		'Forever Alone'
	 );
	 
	 foreach ( $statuses as $status ) {
		echo '<option' . ( $rel == $status ? ' selected' : '' ) . '>';
		echo $status;
		echo '</option>';
	}
}

function isLoggedIn(){
	if (isset($_SESSION['isv_user_id']) && !empty($_SESSION['isv_user_id'])){
		return TRUE;
	} else {
		return FALSE;
	}
}

function valid_codeExists($term,$type){
	global $isv_db,$exstEmail,$exstCode;
	if ($type == 'code'){
		$stmt = $isv_db->prepare("SELECT email FROM user_validations WHERE code=?");
		$stmt->bind_param('s', $term);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($exstEmail);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close();
	} else if($type == 'email'){
		$stmt = $isv_db->prepare("SELECT code FROM user_validations WHERE email=?");
		$stmt->bind_param('s', $term);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($exstCode);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close();
	}
}

function randomCode($var,$length){
	$characters = md5(microtime().session_id().$var);
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function notifyAdmin($name,$type,$sEmail,$sTitle){
	// the message
	$msg = "A new user, ".$name.", has registered on your site.";
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: '.$sTitle.' <'.$sEmail.'>' . "\r\n";
	// send email
	mail($sEmail,$type,$msg,$headers);
}

function emailOrUsername($value){
	if(filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return 'email';
    }
    else {
        return 'username';
    }
}

function UTC2Local($value){
	$time = strtotime($value.' UTC');
	return date("F j, Y", $time);
}

function isMemberSessionValid($currentUser,$currSession){
	global $isv_db;
	
	$stmt = $isv_db->prepare("SELECT id FROM sessions WHERE sess_id=? AND user_id=?");
	$stmt->bind_param('si', $currSession,$currentUser);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($sessID);
	$stmt->fetch();
		if($stmt->num_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	$stmt->close();
}

function elapsedTime($dbTime){
	$timeOffset = date('O');
	$offSetSign = $timeOffset[0];

	//convert offset to seconds
	$timeOffset = $timeOffset * 60 * 60;
	$timeOffset = $timeOffset / 100;
	$time = strtotime($dbTime);
	if ($offSetSign === '+'){
		$time = (time() - $time) - $timeOffset; // we subtract if the offset is positive
	} else {
		$time = (time() - $time) + $timeOffset; // we add if offset is negative
	}
	
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'') .' ago';
    }
}

function userGender($user_id){
	global $isv_db,$userGender;
	
	$stmt = $isv_db->prepare("SELECT gender FROM user_profile WHERE user_id=?");
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($userGender);
	$stmt->fetch();
	$stmt->close();
	
	return $userGender;
}

function age($dob){
	 $date = new DateTime($dob);
	 $now = new DateTime();
	 $interval = $now->diff($date);
	 return $interval->y .' years old';
}

function user_pic($pic){
	if(empty($pic)){
		return ISVIPI_STYLE_URL . 'site/user.jpg';
	} else if (!empty($pic) && !file_exists(ISVIPI_UPLOADS_BASE . 'ppics/'.ISVIPI_THUMBS.$pic)){
		return ISVIPI_STYLE_URL . 'site/user.jpg';
	} else if (!empty($pic) && file_exists(ISVIPI_UPLOADS_BASE . 'ppics/'.ISVIPI_THUMBS.$pic)){
		return ISVIPI_UPLOADS_URL . 'ppics/'.ISVIPI_THUMBS.$pic;
	}
}

function user_cover_pic($pic){
	if(empty($pic)){
		return ISVIPI_STYLE_URL . 'site/cover.jpg';
	} else if (!empty($pic) && !file_exists(ISVIPI_UPLOADS_BASE . 'cover/'.$pic)){
		ISVIPI_STYLE_URL . 'site/cover.jpg';
	} else if (!empty($pic) && file_exists(ISVIPI_UPLOADS_BASE . 'cover/'.$pic)){
		return ISVIPI_UPLOADS_URL . 'cover/'.$pic;
	}
}

function is_online($last_activity){
	$timeOffset = date('O');
	$offSetSign = $timeOffset[0];

	//convert offset to seconds
	$timeOffset = $timeOffset * 60 * 60;
	$timeOffset = $timeOffset / 100;
	$time = strtotime($last_activity);
	if ($offSetSign === '+'){
		$time = (time() - $time) - $timeOffset; // we subtract if the offset is positive
	} else {
		$time = (time() - $time) + $timeOffset; // we add if offset is negative
	}
	
	$time_offline = 10; //considered to be offline if inactive for 10 minutes
	if($time > ($time_offline * 60)){
		//is offline so show nothing
		//echo "<i class='fa fa-circle text-red offline-online'></i>";
	} else {
		//is online
		echo "<i class='fa fa-circle text-green offline-online'></i>";
	}
}

function user_friends($user){
	global $isv_db;
	
	$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friends WHERE user1=?"); 
	$stmt->bind_param('i', $user);
	$stmt->execute();  
	$stmt->bind_result($totalCount); 
	$stmt->fetch();
	$stmt->close();
		
	return $totalCount;
}

function user_friend_requests_count($user){
	global $isv_db;
	
	$unread = 1;
	$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friend_requests WHERE to_id=? AND status=?"); 
	$stmt->bind_param('ii', $user,$unread);
	$stmt->execute();  
	$stmt->bind_result($totalCount); 
	$stmt->fetch();
	$stmt->close();
		
	return $totalCount;
}

function user_friend_req_notices($user,$type,$limit){
	global $isv_db;
	
	if($type === 'all'){
		$query = '';
	} else if($type === "active"){
		$query = "AND fr.status=1";
	}
	
	if($limit === 5){
		$limit = 'LIMIT 5';
	} else if($limit === 'all'){
		$limit = '';
	}
	
	$stmt = $isv_db->prepare ("
	SELECT 
		fr.id,
		fr.from_id,
		fr.to_id,
		fr.status,
		fr.time,
		u.username,
		p.fullname,
		p.profile_pic
		FROM friend_requests fr 
		LEFT JOIN users u ON fr.from_id = u.id
		LEFT JOIN user_profile p ON p.user_id = u.id
		WHERE fr.to_id=? $query $limit
	
	"); 
	$stmt->bind_param('i', $user);
	$stmt->execute(); 
	$stmt->store_result();
	$stmt->bind_result($fr_id,$fr_from_id,$fr_to_id,$fr_status,$fr_time,$fr_username,$fr_fullname,$fr_profile_pic);
	if($stmt->num_rows() > 0) {
		while($stmt->fetch()){
			$resultArray[] = array(
					'id' => $fr_id,
					'from_id' => $fr_from_id,
					'to_id' => $fr_to_id,
					'status' => $fr_status,
					'time' => $fr_time,
					'username' => $fr_username,
					'fullname' => $fr_fullname,
					'profile_pic' => $fr_profile_pic
				);
			
		}
	} else {
		$resultArray[] = array();
	}
	$stmt->close();
	
	return $resultArray;
}

function user_feed_notices_count($user){
	global $isv_db;
	
	$unread = 1;
	$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_notices WHERE feed_owner=? AND status=?"); 
	$stmt->bind_param('ii', $user,$unread);
	$stmt->execute();  
	$stmt->bind_result($totalCount); 
	$stmt->fetch();
	$stmt->close();
		
	return $totalCount;
}

function user_feed_notices($user,$type,$limit){
	global $isv_db;
	
	if($type === 'all'){
		$query = '';
	} else if($type === "active"){
		$query = "AND fn.status=1";
	}
	
	if($limit === 5){
		$limit = 'LIMIT 5';
	} else if($limit === 'all'){
		$limit = '';
	}
	
	$stmt = $isv_db->prepare ("
	SELECT 
		fn.id,
		fn.user_id,
		fn.feed_owner,
		fn.feed_id,
		fn.notice,
		fn.status,
		fn.time,
		u.username,
		p.fullname,
		p.profile_pic
		FROM feed_notices fn 
		LEFT JOIN users u ON fn.user_id = u.id
		LEFT JOIN user_profile p ON p.user_id = u.id
		WHERE fn.feed_owner=? $query ORDER BY fn.id DESC $limit
	
	"); 
	$stmt->bind_param('i', $user);
	$stmt->execute(); 
	$stmt->store_result(); 
	$stmt->bind_result($fn_id,$fn_user_id,$fn_feed_owner,$fn_feed_id,$fn_notice,$fn_status,$fn_time,$fn_username,$fn_fullname,$fn_profile_pic);
	if($stmt->num_rows() > 0){
		while($stmt->fetch()){
			$resultArray[] = array(
					'id' => $fn_id,
					'user_id' => $fn_user_id,
					'feed_owner' => $fn_feed_owner,
					'feed_id' => $fn_feed_id,
					'notice' => $fn_notice,
					'status' => $fn_status,
					'time' => $fn_time,
					'username' => $fn_username,
					'fullname' => $fn_fullname,
					'profile_pic' => $fn_profile_pic
				);
		}
	} else {
		$resultArray[] = array();
	}
		//print_r($resultArray);exit();
	$stmt->close();
	
	return $resultArray;
}

function user_unread_message_count($user){
	global $isv_db;
	
	$delBy = 0;
	$stmt = $isv_db->prepare ("SELECT id FROM user_pm WHERE (to_id=?) AND (read_time = '' OR read_time IS NULL) AND (deleted_by=?) GROUP BY from_id"); 
	$stmt->bind_param('ii', $user,$delBy);
	$stmt->execute();  
	$stmt->store_result();
	$stmt->bind_result($id); 
	$total = $stmt->num_rows();
	$stmt->fetch();
	$stmt->close();
		
	return $total;
}

function unread_msgs_from($user){
	global $isv_db;
	
	$delBy = 0;
	$stmt = $isv_db->prepare ("SELECT id FROM user_pm WHERE (from_id=? AND to_id=?) AND (read_time = '' OR read_time IS NULL) AND (deleted_by=?)"); 
	$stmt->bind_param('iii', $user,$_SESSION['isv_user_id'],$delBy);
	$stmt->execute();  
	$stmt->store_result();
	$stmt->bind_result($id); 
	$total = $stmt->num_rows();
	$stmt->fetch();
	$stmt->close();
		
	return $total;
}

function user_unread_messages($user,$limit){
	global $isv_db;
	
	$delBy = 0;
	$stmt = $isv_db->prepare ("
	SELECT 
		pm.id,
		pm.from_id,
		pm.to_id,
		u.username,
		p.fullname
		FROM user_pm pm 
		LEFT JOIN users u ON pm.from_id = u.id
		LEFT JOIN user_profile p ON p.user_id = pm.from_id
		WHERE (pm.to_id=?) AND (pm.read_time = '' OR pm.read_time IS NULL) AND (pm.deleted_by=?) GROUP BY pm.from_id ORDER BY pm.id DESC LIMIT $limit
	
	"); 
	$stmt->bind_param('ii', $user,$delBy);
	$stmt->execute(); 
	$stmt->store_result(); 
	$stmt->bind_result($pm_id,$pm_from_id,$pm_to_id,$pm_username,$pm_fullname);
	if($stmt->num_rows() > 0){
		while($stmt->fetch()){
			$resultArray[] = array(
					'id' => $pm_id,
					'from_id' => $pm_from_id,
					'to_id' => $pm_to_id,
					'username' => $pm_username,
					'fullname' => $pm_fullname
				);
		}
	} else {
		$resultArray[] = array();
	}
	$stmt->close();
	
	//print_r($resultArray);exit();
	return $resultArray;

}

function update_feed_as_read($feed_id){
	global $isv_db;
	
	$read = 0;
	$stmt = $isv_db->prepare ("UPDATE feed_notices SET status=? WHERE feed_id=?"); 
	$stmt->bind_param('ii', $read,$feed_id);
	$stmt->execute();  
	$stmt->close();
}

function update_all_feeds_as_read($user){
	global $isv_db;
	
	$read = 0;
	$stmt = $isv_db->prepare ("UPDATE feed_notices SET status=? WHERE feed_owner=?"); 
	$stmt->bind_param('ii', $read,$user);
	$stmt->execute();  
	$stmt->close();
}