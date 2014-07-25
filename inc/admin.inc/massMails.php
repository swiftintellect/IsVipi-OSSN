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
include_once ISVIPI_ADMIN_INC_BASE. 'adminFunc.php';
$from_url = $_SERVER['HTTP_REFERER'];
if (isset($ACTION[2])){
$action = $ACTION[2];	
} else{
$action = get_post_var('action');
}
if ($action !== 'sEmail' && $action !=='singleMsg'){
	$_SESSION['err'] =UNKNOWN_REQ;
    header ('location:'.$from_url.'');
	exit();
} 
/////////////////////////////////////////////////////////////
//////////////// SEND MASS EMAIL ///////////////////////////
////////////////////////////////////////////////////////////
if ($action == 'sEmail') {
		$to = get_post_var('to');
		$subject = get_post_var('subject');
		$message = get_post_var('message');	
		if (empty($to)||empty($subject)||empty($message)) {
			$_SESSION['err'] ="Please check to ensure all fields are filled in";
			header ('location:'.$from_url.'');
			exit();
		}
		//Let us retrieve all emails based on $to value
		getAllEmails($to);
		while ($stmt->fetch()){
		global $site_email;
		$from = $site_email; // sender
		$message = wordwrap($message, 70);
			// send mail
			mail($usrEmail,$subject,$message,"From: $from\n");
			//Record sent messages
			recordSentMsgs($usrID,$subject,$message);
		}
			//Notification
			$_SESSION['succ']="Success";
			header ('location:'.$from_url.'');
			exit();
}

/////////////////////////////////////////////////////////////
//////////////// SEND MASS EMAIL ///////////////////////////
////////////////////////////////////////////////////////////
if ($action == 'singleMsg') {
	$to = get_post_var('to');
	$subject = get_post_var('subject');
	$from = $site_email; // sender
	$message = get_post_var('message');	
		if (empty($to)||empty($subject)||empty($message)) {
			$_SESSION['err'] ="Please check to ensure all fields are filled in";
			header ('location:'.$from_url.'');
			exit();
		}
		$stmt = $db->prepare("SELECT id,email FROM members WHERE username=?");
		$stmt ->bind_param('s',$to);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($usrID,$usrEmail);
		$stmt->fetch();
		$found=$stmt->num_rows();
		$stmt->close();
		if ($found >0){
		// send mail
		mail($usrEmail,$subject,$message,"From: $from\n");
		//Record sent messages
		recordSentMsgs($usrID,$subject,$message);
			$_SESSION['succ']="Success";
			header ('location:'.$from_url.'');
			exit();
		} else {
			$_SESSION['err']="No such user found";
			header ('location:'.$from_url.'');
			exit();
		}
	
}
?>