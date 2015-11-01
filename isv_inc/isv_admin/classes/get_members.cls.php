<?php
class get_members {
	public function __construct (){}
	
	public function total($condition){
		global $isv_db;
		
		if($condition === 'all'){
			$query = "";
		} else if($condition === 'active'){
			$query = "WHERE status = 1";
		} else if($condition === 'inactive'){
			$query = "WHERE status = 0";
		} else if ($condition === 'suspended'){
			$query = "WHERE status = 2";
		} else if($condition === 'pending_deletion'){
			$query = "WHERE status = 9";
		} else {
			$query = "";
		}
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM users $query"); 
		$stmt->execute();  
		$stmt->bind_result($count); 
		$stmt->fetch();
		$stmt->close();
		
		return $count;
	}
	
	public function all($q,$pg,$order,$p_limit){
		global $isv_db;
		$limit = $p_limit;
		
		$page = $pg * $p_limit;
		
		//account type
		if($q === 'all'){
			$query = "";
		} else if($q === 'active'){
			$query = "WHERE u.status = 1";
		} else if($q === 'inactive'){
			$query = "WHERE u.status = 0";
		} else if ($q === 'suspended'){
			$query = "WHERE u.status = 2";
		} else if($q === 'pending_deletion'){
			$query = "WHERE u.status = 9";
		} else {
			$query = "";
		}
		
		//order by condition
		if($order === 'latest'){
			$order = 'DESC';
		} else if($order === 'oldest'){
			$order = 'ASC';
		} else {
			$order = 'DESC';
		}

		$stmt = $isv_db->prepare ("
			SELECT
				u.id,
				u.email,
				u.status,
				u.level, 
				u.username,
				p.fullname,
				p.gender,
				p.country
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			$query
			ORDER BY u.id $order LIMIT $page,$limit
		"); 
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($id,$email,$status,$level,$username,$fullname,$gender,$country); 
		$members = array();
		while($stmt->fetch()){
				$members[] = array(
					'id' => $id,
					'email' => $email,
					'status' => $status,
					'level' => $level,
					'username' => $username,
					'fullname' => $fullname,
					'gender' => $gender,
					'country' => $country,
				);
			}
		$stmt->close();
		  //print_r($members); exit();
		  return $members;
	}
	
	public function search($pg,$order,$p_limit,$type,$term){
		global $isv_db;
		$limit = $p_limit;
		
		$page = $pg * $p_limit;
		
		//search type
		if($type === "id"){
			$t_q = "WHERE u.id = '$term'";
		} else if($type === "username"){
			$t_q = "WHERE u.username LIKE '%$term%'";
		} else if($type === "email"){
			$t_q = "WHERE u.email LIKE '%$term%'";
		} else if ($type === "name"){
			$t_q = "WHERE p.fullname LIKE '%$term%'";
		}
		
		
		//order by condition
		if($order === 'latest'){
			$order = 'DESC';
		} else if($order === 'oldest'){
			$order = 'ASC';
		} else {
			$order = 'DESC';
		}
		

		$stmt = $isv_db->prepare ("
			SELECT
				u.id,
				u.email,
				u.status,
				u.level, 
				u.username,
				p.fullname,
				p.gender,
				p.country
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			$t_q
			ORDER BY u.id $order LIMIT $page,$limit
		"); 
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($id,$email,$status,$level,$username,$fullname,$gender,$country); 
		$members = array();
		while($stmt->fetch()){
				$members[] = array(
					'id' => $id,
					'email' => $email,
					'status' => $status,
					'level' => $level,
					'username' => $username,
					'fullname' => $fullname,
					'gender' => $gender,
					'country' => $country,
				);
			}
		$stmt->close();
		  //print_r($members); exit();
		  return $members;
	}
	
	public function search_count($type,$term){
		global $isv_db;
		//search type
		if($type === "id"){
			$query = "WHERE u.id = '$term'";
		} else if($type === "username"){
			$query = "WHERE u.username LIKE '%$term%'";
		} else if($type === "email"){
			$query = "WHERE u.email LIKE '%$term%'";
		} else if ($type === "name"){
			$query = "WHERE p.fullname LIKE '%$term%'";
		}
		
		$stmt = $isv_db->prepare ("
		SELECT COUNT(*) 
			FROM users u
			JOIN user_profile p ON u.id = p.user_id 
		$query
		"); 
		$stmt->execute();  
		$stmt->bind_result($count); 
		$stmt->fetch();
		$stmt->close();

		return $count;
	}


}

class get_single_member {
	public function __construct (){}
	
	public function members($user,$type){
		global $isv_db;
		
		//extract user id
		if($type === 'id'){
			$this->m_id = $user;
		} else if($type === 'username'){
			$this->m_id = $this->username_to_id($user);
		}

		$stmt = $isv_db->prepare ("
			SELECT 
				u.id,
				u.username,
				u.level,
				u.reg_date,
				p.id,
				p.fullname,
				p.gender,
				p.dob,
				p.country,
				p.city,
				p.phone,
				p.profile_pic,
				p.cover_photo,
				p.hobbies,
				p.relshp_status,
				st.feeds,
				st.phone 
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			LEFT JOIN user_settings AS st ON p.user_id = st.user_id
			WHERE u.id=?
		"); 
		$stmt->bind_param('i',$this->m_id);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($this->m_id,$this->m_username,$this->m_level,$this->m_reg_date,$this->p_id,$this->m_fullname,$this->m_gender,$this->m_dob,$this->m_country,$this->m_city,$this->m_phone,$this->m_profile_pic,$this->m_cover_photo,$this->m_hobbies,$this->m_relshp_status,$feedSettings,$phoneSettings); 
		$stmt->fetch();
		$stmt->close();
				$this->m_info = array(
					'm_user_id' => $this->m_id,
					'm_username' => $this->m_username,
					'm_level' => $this->m_level,
					'm_reg_date' => $this->m_reg_date,
					'm_prof_id' => $this->p_id,
					'm_fullname' => $this->m_fullname,
					'm_gender' => $this->m_gender,
					'm_dob' => $this->m_dob,
					'm_country' => $this->m_country,
					'm_city' => $this->m_city,
					'm_phone' => $this->m_phone,
					'm_profile_pic' => $this->m_profile_pic,
					'm_cover_photo' => $this->m_cover_photo,
					'm_hobbies' => $this->m_hobbies,
					'm_rel_status' => $this->m_relshp_status,
					'm_feed_settings' => $feedSettings,
					'm_phone_settings' => $phoneSettings
				);
		return $this->m_info;
	}
	
	public function username_to_id($username){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT id from users WHERE username=?");
		$stmt->bind_param('s',$username);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($id); 
		$stmt->fetch();
		$stmt->close();
		
		return $id;
	}
	
	public function friendsTotal($user_id){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friends WHERE user1=?"); 
		$stmt->bind_param('i', $user_id);
		$stmt->execute();  
		$stmt->bind_result($friendsCount); 
		$stmt->fetch();
		$stmt->close();
		
		return $friendsCount;
	}

}
