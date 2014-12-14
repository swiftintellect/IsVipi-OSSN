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
include_once(ISVIPI_THEMES_BASE.'functions.php');
if (isset($_SERVER['HTTP_REFERER'])){
	$from_url = $_SERVER['HTTP_REFERER'];
} else {
	$from_url = ISVIPI_URL.'home';
}

$action = get_post_var('p_settings');
if ($action !== 'yes' && $action !== 'login'){
	$_SESSION['err'] =UNKNOWN_REQ;
    header ('location:'.$from_url.'');
	exit();
} 
/////////////////////////////////////////////////////////////
//////////////// Personal Settings /////////////////////////
////////////////////////////////////////////////////////////
if ($action === 'yes') {
	if (isset($_POST['view_profile'])){
		$viewProfile = get_post_var('view_profile');
	} else {
		$viewProfile = 0;
	}
	if (isset($_POST['act_timeline'])){
		$postTimeline = get_post_var('act_timeline');
	} else {
		$postTimeline = 0;
	}
	if (!is_numeric($viewProfile)){
		$_SESSION['err'] = N_NUMBERS_ONLY;
		header ('location:'.$from_url.'');
		exit();
	}
	if (!is_numeric($postTimeline)){
		$_SESSION['err'] = N_NUMBERS_ONLY;
		header ('location:'.$from_url.'');
		exit();
	}
	
	//check if the user is already in our membersettings table
	if (settingsAvailable($_SESSION['user_id'])){
		global $db;
		$stmt = $db->prepare('UPDATE membersettings set view_profile=?,act_timeline=? where user_id=?');
		$stmt->bind_param('iii', $viewProfile,$postTimeline,$_SESSION['user_id']);
		$stmt->execute();
		$stmt->close();
	} else {
		global $db;
		$stmt = $db->prepare('insert into membersettings (user_id,view_profile,act_timeline) values (?,?,?)');
		$stmt->bind_param('iii', $_SESSION['user_id'],$viewProfile, $postTimeline);
		$stmt->execute();
		$stmt->close();
	}
	$_SESSION['succ'] =S_SUCCESS;
    header ('location:'.$from_url.'');
	exit();
}
