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
	
	private function blocked ($me,$user){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM users_blocked WHERE (user1=? AND user2=?) OR (user2=? AND user1=?)"); 
		$stmt->bind_param('iiii', $me,$user,$user,$me);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if($totalCount > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}