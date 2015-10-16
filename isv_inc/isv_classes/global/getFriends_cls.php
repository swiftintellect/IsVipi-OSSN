<?php
class get_friends {
	
	private $user_id;
	private $friend_info;	
	private $limit;
	private $order_by;
		
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
	
	public function all_friends($user,$oderBY,$limit){
		global $isv_db;

		$this->limit = $limit;
		
		if($this->limit == 'all'){
			$this->limit = $this->totalFriends($user);
		}
		
		$this->order_by = $oderBY;
		
		if($this->order_by == 'latest'){
			$this->order_by = 'DESC';
		} else if($this->order_by == 'oldest'){
			$this->order_by = 'ASC';
		} else {
			$this->order_by = 'DESC';
		}

		$stmt = $isv_db->prepare ("
			SELECT 
				u.id,
				u.username,
				p.fullname,
				p.gender,
				p.dob,
				p.profile_pic 
			FROM users u
			LEFT JOIN friends f ON u.id = f.user1 
			LEFT JOIN user_profile p ON u.id = p.user_id 
			WHERE f.user2=? ORDER BY f.id $this->order_by LIMIT $this->limit
		"); 
		$stmt->bind_param('i',$user);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($this->m_id,$this->m_username,$this->m_fullname,$this->m_gender,$this->m_dob,$this->m_profile_pic); 
		$all_count = $stmt->num_rows();
			while($stmt->fetch()){
				$this->friend_info[] = array(
					'm_id' => $this->m_id,
					'm_username' => $this->m_username,
					'm_fullname' => $this->m_fullname,
					'm_gender' => $this->m_gender,
					'm_dob' => $this->m_dob,
					'm_profile_pic' => $this->m_profile_pic,
					'm_all_count' => $all_count,
				);
			}
		return $this->friend_info;
	}
	
	public function totalFriends($user){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friends WHERE user1=?"); 
		$stmt->bind_param('i', $user);
		$stmt->execute();  
		$stmt->bind_result($total_members); 
		$stmt->fetch();
		$stmt->close();
		
		return $total_members;
	}
		
		
}