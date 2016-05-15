<?php
class message {
	private $me;
	public function __construct(){}
	
	public function send_message($message,$to_msg){
		global $isv_db;
		
		$from_url = $_SERVER['HTTP_REFERER'];
		
		$this->me = $_SESSION['isv_user_id'];
		
		//check if either is blocked
		if($this->blocked($this->me,$to_msg)){
			 $_SESSION['isv_error'] = "Blocked. You cannot send a message to this user.";
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//check if the recipient exists
		if($this->recipient_status($to_msg) === 2){
			 $_SESSION['isv_error'] = "This user was suspended and therefore you cannot exchange messages.";
			 header('location:'.$from_url.'');
			 exit();
		} else if ($this->recipient_status($to_msg) === 9){
			 $_SESSION['isv_error'] = "This user was scheduled for deletion and therefore you cannot exchange messages.";
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//add to db
		$stmt = $isv_db->prepare("INSERT INTO user_pm (from_id,to_id,message,sent_time) VALUES (?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('iis',$this->me,$to_msg,$message);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = "Message sent.";
		header('location:'.$from_url.'');
		exit();
	}
	
	public function blocked ($me,$user){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM users_blocked WHERE (user1=? AND user2=?) OR (user2=? AND user1=?)"); 
		$stmt->bind_param('iiii', $me,$user,$user,$me);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if($totalCount > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function recipient_status($to_msg){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT status FROM users WHERE id=?"); 
		$stmt->bind_param('i', $to_msg);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($status); 
		$stmt->fetch();
		$stmt->close();
		
		return $status;
	}
	
	public function delete_chat($other_user){
		global $isv_db;
		
		$from_url = $_SERVER['HTTP_REFERER'];
		$me = $_SESSION['isv_user_id'];
		$none = 0;
		
		//check if the chat exists and check its status while at it
		$stmt = $isv_db->prepare ("SELECT id FROM user_pm WHERE 
			(to_id=? AND from_id=? AND (deleted_by =? OR deleted_by =?)) OR 
			(from_id=? AND to_id=? AND (deleted_by =? OR deleted_by =?)) 	
			
		"); 
		$stmt->bind_param('iiiiiiii', $me,$other_user,$other_user,$none,$me,$other_user,$other_user,$none);
		$stmt->execute();  
		$stmt->bind_result($id); 
		$stmt->store_result();
		
		if(!$stmt->num_rows() < 0) {
			 $_SESSION['isv_error'] = 'Chat not found.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//conditional update
		$stmt = $isv_db->prepare ("
			UPDATE user_pm SET deleted_by = 
				CASE 
					WHEN deleted_by = $other_user THEN 'both'
					WHEN deleted_by = 'both' THEN 'both'
					ELSE $me
				END
			
			WHERE 
				(to_id=? AND from_id=?) OR 
				(from_id=? AND to_id=?) 
		
		"); 
		$stmt->bind_param('iiii', $me,$other_user,$me,$other_user);
		$stmt->execute();  
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Chat deleted';
		header('location:'.ISVIPI_URL.'messages/');
		exit();	
		
	}
	
}