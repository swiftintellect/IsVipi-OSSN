<?php
class get_friends {
		
		
	public function __contruct(){}
	
	public function are_friends($user1,$user2){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friends WHERE user1=? AND user2=?"); 
		$stmt->bind_param('ii', $user1,$user2);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if($totalCount > 0 ){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function fr_request_exists($user1,$user2){
		global $isv_db,$fr_rq_id,$from_id,$to_id,$req_status;
		
		$stmt = $isv_db->prepare ("SELECT id,from_id,to_id,status FROM friend_requests WHERE (from_id=? AND to_id=?) OR (to_id=? AND from_id=?)"); 
		$stmt->bind_param('iiii', $user1,$user2,$user1,$user2);
		$stmt->execute();  
		$stmt->store_result();
		$stmt->bind_result($fr_rq_id,$from_id,$to_id,$req_status); 
		$stmt->fetch();
		
			if($stmt->num_rows() > 0 ){
				return TRUE;
			} else {
				return FALSE;
			}
		
		$stmt->close();
	}
		
		
}