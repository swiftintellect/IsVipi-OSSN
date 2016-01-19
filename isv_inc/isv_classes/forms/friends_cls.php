<?php
class friends {
	private $me;
	private $to_req;
	private $from_uri;
	
	public function __construct(){
		$this->from_uri = $_SERVER['HTTP_REFERER'];
		$this->me = $_SESSION['isv_user_id'];
	}
	
	/******************************
	_______ FRIEND REQUEST ________

	******************************/
	public function sendFriendReq($to){
		global $isv_db;
		
		$this->to_req = $to;
		
		//check if there is an existing friend request
		global $friendReq_status;
		if($this->friendReqExists($this->to_req)){
			$_SESSION['isv_error'] = 'You already sent a friend request to this user';
			header('location:'.$this->from_uri.'');
			exit();
		}
		
		//add friend request
		$stmt = $isv_db->prepare("INSERT INTO friend_requests (from_id,to_id,time) VALUES (?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('ii',$this->me,$this->to_req);
		$stmt->execute();
		
		//notify intended user
		$notice = 'sent you a friend request';
		$stmt->prepare("INSERT INTO friend_req_alerts (from_id,to_id,notice,time) VALUES (?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('iis',$this->me,$this->to_req,$notice);
		$stmt->execute();
		$stmt->close();
		
		//redirect back with a success message
		$_SESSION['isv_success'] = 'Friend Request Sent';
		header('location:'.$this->from_uri.'');
		exit();
		
	}
	
	
	/******************************
	____ IGNORE FRIEND REQUEST ____

	******************************/
	public function ignoreFriendReq($f_rquest_id){
		global $isv_db;
		
		//update our db
		$stmt = $isv_db->prepare("UPDATE friend_requests SET status=0 WHERE id=?");
		$stmt->bind_param('i',$f_rquest_id);
		$stmt->execute();
		$stmt->close();
		
		//redirect back with a success message
		$_SESSION['isv_success'] = 'Friend Request Ignored for now!';
		header('location:'.$this->from_uri.'');
		exit();
	}
	
	/******************************
	____ ACCEPT FRIEND REQUEST ____

	******************************/
	public function acceptFriendReq($fr_req_id,$user_sent){
		global $isv_db;
		
		//enter new details to the friends table
		$stmt = $isv_db->prepare("INSERT INTO friends (user1,user2,time) VALUES (?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('ii',$this->me,$user_sent);
		$stmt->execute();
		
		$stmt->prepare("INSERT INTO friends (user1,user2,time) VALUES (?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('ii',$user_sent,$this->me);
		$stmt->execute();
		
		//delete the friend request
		$stmt->prepare("DELETE from friend_requests WHERE (from_id=? AND to_id=?) OR ( to_id=? AND from_id=?)");
		$stmt->bind_param('iiii',$user_sent,$this->me,$user_sent,$this->me);
		$stmt->execute();
		$stmt->close();
		
		//notify the one who sent the friend request that the request was accepted
		$notice = 'accepted your friend request';
		$stmt = $isv_db->prepare("INSERT INTO friend_req_alerts (from_id,to_id,notice,time) VALUES (?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('iis',$this->me,$user_sent,$notice);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'You are now friends';
		header('location:'.$this->from_uri.'');
		exit();
		
	}
	
	/******************************
	____ REMOVE FRIEND  ____

	******************************/
	public function un_friend($friend_id){
		global $isv_db;
		
		//check if they are friends
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friends WHERE user1=? AND user2=?"); 
		$stmt->bind_param('ii', $this->me,$friend_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if($totalCount < 1 ){
			$_SESSION['isv_success'] = 'This user is not your friend so you cannot remove friend.';
			header('location:'.$this->from_uri.'');
			exit();
		} else {
			//if they are friends then we delete friendship
			$stmt = $isv_db->prepare ("DELETE FROM friends WHERE (user1=? AND user2=?) OR (user2=? AND user1=?)"); 
			$stmt->bind_param('iiii', $this->me,$friend_id,$this->me,$friend_id);
			$stmt->execute();  
			$stmt->close();
		}
		
		//return success
		$_SESSION['isv_success'] = 'You have unfriended this user.';
		header('location:'.$this->from_uri.'');
		exit();
		
	}
	
	/******************************
	____ BLOCK USER  ____

	******************************/
	public function block_user($user_id){
		global $isv_db;
		
		//we first delete any friend request existing between them
		$stmt = $isv_db->prepare ("DELETE FROM friend_requests WHERE (from_id=? AND to_id=?) OR (to_id=? AND from_id=?)"); 
		$stmt->bind_param('iiii', $this->me,$user_id,$this->me,$user_id);
		$stmt->execute();  
		$stmt->close();
		
		//check if they are friends
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friends WHERE user1=? AND user2=?"); 
		$stmt->bind_param('ii', $this->me,$user_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		//if they are not friends and have already blocked each other
		if($totalCount < 1 && $this->blocked_users($this->me,$user_id)){
			
			//notify user that a block already exists
			$_SESSION['isv_success'] = 'It appears one of you already blocked the other.';
			header('location:'.$this->from_uri.'');
			exit();
		
		//if they are not friends and have not blocked each other	
		} else if($totalCount < 1 && !$this->blocked_users($this->me,$user_id)){
			
			//we block the users
			$stmt = $isv_db->prepare ("INSERT INTO users_blocked (user1,user2,time) VALUES (?,?,UTC_TIMESTAMP())"); 
			$stmt->bind_param('ii', $this->me,$user_id);
			$stmt->execute();  
			$stmt->close();
		
		//if they are already friends (cannot be friends if already blocked each other so no need to check if blocked)	
		} else if($totalCount > 0){
			//if they are friends then we delete friendship
			$stmt = $isv_db->prepare ("DELETE FROM friends WHERE (user1=? AND user2=?) OR (user2=? AND user1=?)"); 
			$stmt->bind_param('iiii', $this->me,$user_id,$this->me,$user_id);
			$stmt->execute();  
			$stmt->close();
			
			//then we block
			$stmt = $isv_db->prepare ("INSERT INTO users_blocked (user1,user2,time) VALUES (?,?,UTC_TIMESTAMP())"); 
			$stmt->bind_param('ii', $this->me,$user_id);
			$stmt->execute();  
			$stmt->close();
		}
		
		//return success
		$_SESSION['isv_success'] = 'You have blocked this user.';
		header('location:'.$this->from_uri.'');
		exit();
		
	}
	
	/******************************
	____ UNBLOCK USER  ____

	******************************/
	public function unblock_user($user_id){
		global $isv_db;
		
		//check if a block exists between the two users
		if(!$this->blocked_users($this->me,$user_id)){
			$_SESSION['isv_success'] = 'There is no block existing between you two.';
			header('location:'.$this->from_uri.'');
			exit();
		} else {
			//remove the block
			$stmt = $isv_db->prepare ("DELETE FROM users_blocked WHERE (user1=? AND user2=?) OR (user2=? AND user1=?)"); 
			$stmt->bind_param('iiii', $this->me,$user_id,$this->me,$user_id);
			$stmt->execute();  
			$stmt->close();
		}
		
		//return success
		$_SESSION['isv_success'] = 'You have unblocked this user.';
		header('location:'.$this->from_uri.'');
		exit();
		
	}
	
	
	/******************************
	_______ HELPERS ________

	******************************/
	public function friendReqExists($to){
		global $isv_db,$fr_id,$friendReq_status,$fr_from,$fr_to;
		
		$stmt = $isv_db->prepare("SELECT id,from_id,to_id,status FROM friend_requests WHERE (from_id=? AND to_id=?) OR (to_id=? AND from_id=?)");
		$stmt->bind_param('iiii',$this->me,$to,$this->me,$to);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($fr_id,$fr_from,$fr_to,$friendReq_status);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close( );
	}
	
	public function blocked_users($user1,$user2){
		global $isv_db,$block_id,$block_user1,$block_user2;
		
		$stmt = $isv_db->prepare("SELECT id,user1,user2 FROM users_blocked WHERE (user1=? AND user2=?) OR (user2=? AND user1=?)");
		$stmt->bind_param('iiii',$user1,$user2,$user1,$user2);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($block_id,$block_user1,$block_user2);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close();
	}
	
	public function delete_friend_request($fr_id){
		global $isv_db;
		
		//remove the friend request
		$stmt = $isv_db->prepare ("DELETE FROM friend_requests WHERE id=?"); 
		$stmt->bind_param('i', $fr_id);
		$stmt->execute();  
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Friend request deleted.';
		header('location:'.$this->from_uri.'');
		exit();
	}
}