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
	 if(!isset($_SERVER['HTTP_REFERER']) || empty ($_SERVER['HTTP_REFERER'])){
		exit();
	 }
	 
	 /** check if he is a logged in user **/
	 if(!isLoggedIn()){
		 exit();
	 }
	 
	 /** an extra layer of security => check if there is a session matching these details in the database **/
	 $currSession = session_id();
	 $currentUser = $_SESSION['isv_user_id'];
	 if (!isMemberSessionValid($currentUser,$currSession)){
		 exit();
	 }
	 
	 //check if action was sent
	 if(!isset($PAGE[2])){
		exit(); 
	 }
	 
	 if($PAGE[2] !== 'frequests' && $PAGE[2] !== 'messages' && $PAGE[2] !== 'notices' && $PAGE[2] !== 'global'){
		 exit();
	 }
	 
	 //if friend requests
	 if($PAGE[2] === 'frequests'){
		 
		//update all as read
		/*$newStatus = 0;
		$oldStatus = 1;
	 	$stmt = $isv_db->prepare ("UPDATE friend_requests SET status=? WHERE status=?"); 
		$stmt->bind_param('ii', $newStatus,$oldStatus);
		$stmt->execute();  
		$stmt->close();*/
		
	 } else if($PAGE[2] === 'frequests'){
		 
	 } else if($PAGE[2] === 'notices'){
		 
		 //update feed notices as read
		 $oldStatus = 1;
		 $newStatus = 0;
		 $stmt = $isv_db->prepare ("UPDATE feed_notices SET status=? WHERE status=? AND feed_owner=?"); 
		 $stmt->bind_param('iii', $newStatus,$oldStatus,$_SESSION['isv_user_id']);
		 $stmt->execute();  
		 $stmt->close();
		 
	 } else if($PAGE[2] === 'global'){
		 //update feed notices as read
		 $oldStatus = 1;
		 $newStatus = 0;
		 $stmt = $isv_db->prepare ("UPDATE isv_globalnotices SET status=? WHERE status=? AND userid=?"); 
		 $stmt->bind_param('iii', $newStatus,$oldStatus,$_SESSION['isv_user_id']);
		 $stmt->execute();  
		 $stmt->close();
	 }
		 
		 
		 
		 
		 