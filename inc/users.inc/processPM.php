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
isLoggedIn();   //We will try to integrate better security in next releases
$user = $_SESSION['user_id'];
getUserDetails($user);
$from_url = $_SERVER['HTTP_REFERER'];
include_once ISVIPI_USER_INC_BASE. 'emails/emailFunc.php';

//Define key actions
//It will return fail if no correct action is defined from a POST command
if (isset($ACTION[2])){
	$msg = $ACTION[2];
} else if (isset($_POST['msg'])){
$msg = $_POST['msg'];
}
if (!is_numeric($msg))
	{
		$_SESSION['err'] =INV_ACTION;
		header("location:".$from_url."");
		exit();
	}
if ($msg !== '0'/**Add Message**/ && $msg !== '1' /**Retrieve Message**/ && $msg !== '3' /**Delete Message**/)
	{
		$_SESSION['err'] =UNKNOWN_REQ;
		header("location:".$from_url."");
		exit();
	}
	
/////////////////////////////////////////////////////////////
//////////////// ADD PM (MSG=0) ////////////////////////////
////////////////////////////////////////////////////////////
if ($msg === '0') {
//Capture and clean recipient ID	
if (isset($_POST['recip']))
$recip = $_POST['recip'];
//Check to see whether our ID is clean
if (!is_numeric($recip))
	{
		$_SESSION['err'] =E_INV_REC_ID;
		header("location:".$from_url."");
		exit();
	}
//Capture and clean Message	
if (isset($_POST['message']))
$msg = get_post_var('message');
if (empty($msg)) 
    {
		$_SESSION['err'] =E_MSG_EMPTY;
		header("location:".$from_url."");
		exit();
	}
	$message = htmlspecialchars("".$msg."", ENT_QUOTES);
	//Check if there is any block
	isBlocked($_SESSION['user_id'],$recip);
		if ($blockCount > 0){
			$_SESSION['err'] =N_BLOCK_NOTICE;
			echo $_SESSION['err'];
			header("location:".$from_url."");
			exit();
		}
//Check if an existing conversation between the two users is available
//checkConv($user,$recip);
if (checkConv($user,$recip)){
	//When all is okay, we insert values into the database
	addPM($user,$recip,$message,$unique_id);
} else {
$unique_id = mt_rand(0,1000).rand(0,1000);
addPM($user,$recip,$message,$unique_id);
}
	if (!isOnlineNOW($recip)){
		{getUserDetails($recip);{$toUser = $username;$toEmail = $email;}}
		{getUserDetails($user);{$fromUser = $username;}}
	sendNewMsgNotif($toUser,$toEmail,$fromUser,$message);	
	}
getLastMsg ($unique_id);
updMsgUnRead($lastMsgID,$unique_id);

		$_SESSION['succ'] =S_MSG_SENT;
		header("location:".$from_url."");
		exit();
		{
    }
}

/////////////////////////////////////////////////////////////
//////////////// ADD PM (MSG=0) ////////////////////////////
////////////////////////////////////////////////////////////
if ($msg === '3') {
	global $db;
	//We collect our unique message id
	$msgID = $ACTION[3];
	//We collect other conversation user
	$otherUser = $ACTION[4];
	//we check if is clean
	if (!is_numeric($otherUser))
	{
		$_SESSION['err'] =INV_ACTION;
		header("location:".$from_url."");
		exit();
	}
	//we then check if it is clean
	if (!is_numeric($msgID))
	{
		$_SESSION['err'] =INV_ACTION;
		header("location:".$from_url."");
		exit();
	}
	//we first check if an existing conversation between the two exists
	if (!checkConv($_SESSION['user_id'],$otherUser)){
		$_SESSION['err'] =NO_SUCH_CONV;
		header("location:".$from_url."");
		exit();
	}
	//then we check if either of the users has previously deleted the conversation
		$prevDel = $db->prepare("SELECT pm_deleted FROM pm WHERE (unique_id=? AND pm_deleted=?)");
		$prevDel->bind_param("ii",$msgID,$otherUser);
		$prevDel->execute();
		$prevDel->store_result();
		$prevDel->bind_result($unique_id);
		$prevDel->fetch();
			if ($prevDel->num_rows > 0){
				//we first delete the messages the other user had already deleted
				$stmt = $db->prepare('DELETE from pm where (unique_id=? AND pm_deleted=?)');
				$stmt->bind_param('ii', $msgID,$otherUser);
				$stmt->execute();
				$stmt->close();
				//then we delete the ones from his own end that the other user hasn't deleted
				$zero = 0;
				$stmt = $db->prepare('UPDATE pm set pm_deleted=? where (unique_id=? AND pm_deleted=?)');
				$stmt->bind_param('iii', $_SESSION['user_id'],$msgID,$zero);
				$stmt->execute();
				$stmt->close();
			} else {
				$newStatus = $_SESSION['user_id'];
				//we then update our database
				$stmt = $db->prepare('UPDATE pm set pm_deleted=? where (unique_id=?)');
				$stmt->bind_param('si', $newStatus,$msgID);
				$stmt->execute();
				$stmt->close();
			}
		$prevDel->free_result();
		$prevDel->close();
	
	
		//we then echo our success message
		$_SESSION['succ'] =S_SUCCESS;
		header("location:".$from_url."");
		exit();
	
}
?>