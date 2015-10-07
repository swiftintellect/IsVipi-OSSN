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
			echo "<option value=".$countryISO.">$countryName</option>";
		}
	$stmt->close();
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