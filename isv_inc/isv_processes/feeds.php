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
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	 }
	 
	 if ($operation !== 'new-feed' && $operation !== 'img-feed' && $operation !== 'like' && $operation !== 'unlike' && $operation !== 'new-comment' && $operation !== 'comm_like' && $operation !== 'comm_unlike' && $operation !== 'share' && $operation !== 'delete' && $operation !== 'comm_del'){
		 $array['err'] = true;
		 $array['message'] = 'Action not Allowed!';
		 echo json_encode($array);
		 exit();
	}
	require_once(ISVIPI_CLASSES_BASE .'forms/feeds_cls.php');
	
	/*** NEW TEXT FEED **/
	if ($operation === 'new-feed'){
		if (!isset($_POST['feed']) || empty($_POST['feed'])){
			 $array['err'] = true;
			 $array['message'] = 'You cannot submit an empty feed.';
			 echo json_encode($array);
			 exit();
		}
		
		/** clean our variable and format it accordingly **/
		$newFeed = cleanPOST('feed');
		$newFeed = str_replace("  ","",$newFeed);
		$newFeed = nl2br($newFeed);
		
		/** add our feed **/
		new feeds($newFeed,'text');
		
	}
	
	/** NEW IMAGE FEED **/
	if ($operation === 'img-feed'){
		
		//check if there is any text attached to this post
		if (!isset($_POST['feed']) || empty($_POST['feed'])){
			$feed = "";
		} else {
			$feed = cleanPOST('feed');
			$feed = str_replace("  ","",$feed);
			$feed = nl2br($feed);
		}
		if (!is_uploaded_file($_FILES['feedImg']['tmp_name'])) {
		   	 $array['err'] = true;
			 $array['message'] = 'Please select an image to upload';
			 echo json_encode($array);
			 exit();
		}
		
		$image = $_FILES['feedImg'];
		
		$post = array(
			'text' => $feed,
			'image' => $image
		);
		
		/** add our feed **/
		new feeds($post,'img');
	}
	
	/*** LIKE USER FEED **/
	if ($operation === 'like'){
		
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			//do nothing
			exit();
		}
		
		$feedID = cleanGET($PAGE[3]);
		
		//strip non numeric characters
		$feedID = preg_replace('/[^0-9,.]+/i', '', $feedID);
		
		/** add our feed like **/
		$addNewLike = new feedActions();
		$addNewLike->like($feedID);
		
	}

	/*** UNLIKE USER FEED **/
	if ($operation === 'unlike'){
		
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			//do nothing
			exit();
		}
		
		$feedID = cleanGET($PAGE[3]);
		
		//strip non numeric characters
		$feedID = preg_replace('/[^0-9,.]+/i', '', $feedID);
		
		/** unlike feed**/
		$unLike = new feedActions();
		$unLike->unlike($feedID);
		
	}
	
	/*** COMMENT ON FEED **/
	if ($operation === 'new-comment'){
		if (!isset($_POST['comment']) || empty($_POST['comment'])){
			//do nothing
			exit();
		}
		if (!isset($_POST['f_id']) || empty($_POST['f_id'])){
			//do nothing
			exit();
		}
	
		$comment = cleanPOST('comment');
		$comment = str_replace("  ","",$comment);
		$comment = nl2br($comment);
		
		$feed_id = $converter->decode(cleanPOST('f_id'));
		
		$addComment = new feedActions();
		$addComment->addComment($comment,$feed_id);
	
	}
	
	/*** COMMENT ON FEED **/
	if ($operation === 'comm_like'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			//do nothing
			exit();
		}
		
		$commentID = cleanGET($PAGE[3]);
		
		//strip non numeric characters
		$commentID = preg_replace('/[^0-9,.]+/i', '', $commentID);
		
		/** add our feed like **/
		$addNewCommentLike = new feedActions();
		$addNewCommentLike->commentLike($commentID);
	}
	
	/*** COMMENT ON FEED **/
	if ($operation === 'comm_unlike'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			//do nothing
			exit();
		}
		
		$commID = cleanGET($PAGE[3]);
		
		//strip non numeric characters
		$commID = preg_replace('/[^0-9,.]+/i', '', $commID);
		
		/** unlike feed comment**/
		$unLikeComment = new feedActions();
		$unLikeComment->unlikeComment($commID);
		
	}
	
	
	/*** SHARE **/
	if ($operation === 'share'){
		if (!isset($_POST['feed']) && empty($_POST['feed'])){
			$feed = "";
		} else {
			$feed = cleanPOST('feed');
		}
		
		if (!isset($_POST['f_id']) && empty($_POST['f_id'])){
			$_SESSION['isv_error'] = 'An error occurred. Please try again.';
			header('location:'.ISVIPI_URL.'home/');
			exit();
		}
		
		$feed_id = $converter->decode(cleanPOST('f_id'));	
		
		/** share feed **/
		$share = new feedActions();
		$share->shareFeed($feed, $feed_id);
	}
	
	/*** DELETE FEED **/
	if ($operation === 'delete'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			//do nothing
			exit();
		}
		
		$feedID = cleanGET($PAGE[3]);
		
		/** delete feed **/
		$delete = new feedActions();
		$delete->delFeed($feedID);
	}
	
	/*** DELETE COMMENT **/
	if ($operation === 'comm_del'){
		if(!isset($PAGE[3]) || empty($PAGE[3])){
			//do nothing
			exit();
		}
		
		$comment_ID = cleanGET($PAGE[3]);
		
		/** delete comment **/
		$delete = new feedActions();
		$delete->delComment($comment_ID);
		
	}
