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
	//first check if the user is logged in
	if(isLoggedIn()){
		$_SESSION = array();
		$currSession = session_id();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		//delete session from the database
		$stmt = $isv_db->prepare("DELETE from sessions WHERE (sess_id=? OR user_id=?)");
		$stmt->bind_param('si', $currSession, $_SESSION['isv_user_id']);
		$stmt->execute();
		$stmt->close();
		
		session_destroy();
		
		header('location:'.ISVIPI_URL.'');
		exit();
	} else {
		notFound404Err();
	}
	
?>