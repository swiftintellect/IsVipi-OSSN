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
		$_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		notFound404Err();
		exit();
	 }
	 
	 $from_url = $_SERVER['HTTP_REFERER'];
	 
	 /** check if he is a logged in user **/
	 if(!isLoggedIn()){
		 $_SESSION['isv_error'] = "You must be logged in to complete this action.";
		 header('location:'.ISVIPI_URL.'sign_in');
		 exit();
	 }
	 
	 /** an extra layer of security => check if there is a session matching these details in the database **/
	 $currSession = session_id();
	 $currentUser = $_SESSION['isv_user_id'];
	 if (!isMemberSessionValid($currentUser,$currSession)){
		 $_SESSION['isv_error'] = "Your session either changed or expired. Please sign in to continue.";
		 header('location:'.ISVIPI_URL.'sign_in');
		 exit();
	 }
	 
	 /** check if our hidden field is present */
	 if (isset($_POST['isv_op']) && !empty($_POST['isv_op'])){
		 $operation = $converter->decode(cleanPOST('isv_op'));
	 } else if(isset($PAGE[2]) && !empty($PAGE[2])){
		 $operation = $converter->decode(cleanGET($PAGE[2]));
	 } else {
		 $_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		 header('location:'.$from_url.'');
		 exit();
	 }
	 
	 if ($operation !== 'search' && $operation !== 'cover_pic'){
		 $_SESSION['isv_error'] = 'ACTION NOT ALLOWED!';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	/*** SEARCH USER **/
	if ($operation === 'search'){
		
		//check if a search term is supplied
		if(!isset($_POST['term']) || empty($_POST['term'])){
			$_SESSION['isv_error'] = 'Please enter a name to search';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		$term = cleanPOST('term');
		
		//redirect to our search page
		header('location:'.ISVIPI_URL.'search/'.$term.'');
		exit();
		
	}