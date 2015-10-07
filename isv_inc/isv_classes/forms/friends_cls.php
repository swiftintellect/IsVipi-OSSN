<?php
class friends {
	private $me;
	private $to_req;
	private $from_uri;
	
	public function __construct(){
		$this->me = $_SESSION['isv_user_id'];
	}
	
	/******************************
	_______ FRIEND REQUEST ________

	******************************/
	public function sendFriendReq($to){
		$this->from_uri = $_SERVER['HTTP_REFERER'];
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
		$this->from_uri = $_SERVER['HTTP_REFERER'];
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
		$this->from_uri = $_SERVER['HTTP_REFERER'];
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
		$stmt->bind_param('iis',$user_sent,$this->me,$notice);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'You are now friends';
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
}