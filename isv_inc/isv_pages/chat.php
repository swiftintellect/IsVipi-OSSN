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
	require_once(ISVIPI_PAGES_BASE .'m_base.php');
	require_once(ISVIPI_CLASSES_BASE .'global/getMessages_cls.php'); 

	if(!isset($PAGE[1]) || empty($PAGE[1])){
		echo "
		<div class='box-header with-border'>
			<div class='box-body'>
				An error occured. Please try again.
			</div>
		</div>
		";
		exit();
	}
	
	$user = cleanGET($PAGE[1]);
	
	//extract user_id from username
	if(!id_from_username($user)){
		echo "
		<div class='box-header with-border'>
			<div class='box-body'>
				This user does not exist.
			</div>
		</div>
		";
		exit();
	}

	//get user's full name
	$full_name = full_name_from_id($user_id);
	//check if a chat between the two exists
	$ch = new get_messages();
	
	if(!$ch->chat_exists($_SESSION['isv_user_id'],$user_id)){
		echo "
		<div class='box-header with-border'>
			<div class='box-body'>
				No chat found. You can send this user a message by using the message box below.
			</div>
		</div>
		";
		exit();
	}
	
	//update unread messages as read
	$ch->update_as_read($_SESSION['isv_user_id'],$user_id);
	
	//retrieve the id of the last message between the two
	$last_msg_id = $ch->last_msg_id($_SESSION['isv_user_id'],$user_id);
	
	//load messages
	$msgs = array_filter($ch->all_messages($_SESSION['isv_user_id'],$user_id));
 	include_once ISVIPI_ACT_THEME.'pages/chat.php'; 
