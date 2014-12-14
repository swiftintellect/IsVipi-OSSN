<?php
function getMembersFrom($ipCountry){
	global $db,$userC_ID,$userC_gender,$userC_city,$userC_thumbnail,$getMcountry;
	$getMcountry = $db->prepare("SELECT user_id,gender,city,thumbnail FROM member_sett WHERE country=? ORDER BY id DESC LIMIT 6");
	$getMcountry -> bind_param('s',$ipCountry);
	$getMcountry->execute();
	$getMcountry->store_result();
	$getMcountry->bind_result($userC_ID,$userC_gender,$userC_city,$userC_thumbnail);
}

//Get member details
function sideBarUserDet($value){
	global $db;
	global $s_name;
	global $s_gender;
	global $s_dob;
	global $s_age;
	global $s_city;
	global $s_country;
	global $s_phone;
	global $s_thumbnail;
	$stmt = $db->prepare("SELECT d_name,gender,dob,city,country,phone,thumbnail FROM member_sett WHERE user_id=?");
	$stmt->bind_param("i",$value);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($s_name,$s_gender,$s_dob,$s_city,$s_country,$s_phone,$s_thumbnail);
	$stmt->fetch();
	$stmt->close();
		$now      = new DateTime();
		$birthday = new DateTime($s_dob);
		$interval = $now->diff($birthday);
		$s_age = $interval->format('%y '.YEARS_OLD.''); 
}

function GetUsernameOnly($value){
	global $db;
	global $usrname;
	$getusrst = $db->prepare("SELECT username FROM members WHERE id=?");
	$getusrst->bind_param("i",$value);
	$getusrst->execute();
	$getusrst->store_result();
	$getusrst->bind_result($usrname);
	$getusrst->fetch();
	$getusrst->close();
}

function settingsAvailable($user){
	global $db;
	$stmt = $db->prepare("SELECT id FROM membersettings WHERE user_id=?");
	$stmt->bind_param("i",$user);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows();
	$stmt->close();
	if ($count > 0){
		return TRUE;
	} else {
		return FALSE;
	}
}

function getPersonalSettings($user){
	global $db,$view_profile,$act_timeline;
	$stmt = $db->prepare("SELECT view_profile,act_timeline FROM membersettings WHERE user_id=?");
	$stmt->bind_param("i",$user);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($view_profile,$act_timeline);
	$stmt->fetch();
	$stmt->close();
}

function funcMemberListCount(){
	global $db,$member_count;
	$active = '1';
	$stmt = $db->prepare("SELECT id FROM members where active=?");
	$stmt->bind_param('i', $active);
	$stmt->execute();
	$stmt->store_result();
	$member_count = $stmt->num_rows();
}

function funcMemberList(){
	global $db;
	global $getmembers;
	global $id;
	global $profile_name;
	global $m_count;
	$active = '1';
	$getmembers = $db->prepare("SELECT id,username FROM members where active=?");
	$getmembers->bind_param('i', $active);
	$getmembers->execute();
	$getmembers->store_result();
	$getmembers->bind_result($id,$profile_name);
	$m_count = $getmembers->num_rows();
}

function getMyFriendsSidebar($user){
	global $db;
	global $getfriends;
	global $id;
	global $MyfriendCount;
	$getfriends = $db->prepare("SELECT user2 FROM my_friends WHERE user1=? LIMIT 10");
	$getfriends->bind_param('i', $user);
	$getfriends->execute();
	$getfriends->store_result();
	$getfriends->bind_result($id);
	$MyfriendCount = $getfriends->num_rows();
}

function myPersonalSettings($value){
	global $db,$FriendsOnlyViewProfile,$FriendsOnlyComment;
	$stmt = $db->prepare("SELECT view_profile,act_timeline FROM membersettings WHERE user_id=?");
	$stmt->bind_param("i",$value);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($FriendsOnlyViewProfile,$FriendsOnlyComment);
	$stmt->fetch();
	$stmt->close();
}