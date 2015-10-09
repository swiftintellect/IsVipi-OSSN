<?php
class getMembers {
	public $m_id;
	public $m_username;
	public $m_level;
	public $m_reg_date;
	public $m_fullname;
	public $m_gender;
	public $m_dob;
	public $m_country;
	public $m_city;
	public $m_phone;
	public $m_profile_pic;
	public $m_cover_photo;
	public $m_hobbies;
	public $m_relshp_status;
	public $m_total_members;
	public $m_info;
	
	private $limit;
	private $me;
	
	public function __construct (){
		$this->me = $_SESSION['isv_user_id'];
	}
	
	public function totalMembers($status){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM users WHERE status=?"); 
		$stmt->bind_param('i', $status);
		$stmt->execute();  
		$stmt->bind_result($this->m_total_members); 
		$stmt->fetch();
		$stmt->close();
		
		return $this->m_total_members;
	}
	
	public function allMembers($status){
		global $isv_db;
		
		$this->limit = 50;

		$stmt = $isv_db->prepare ("
			SELECT 
				u1.id,
				u1.username,
				p.fullname,
				p.gender,
				p.dob,
				p.profile_pic, 
	
			GROUP_CONCAT(u2.id)
			FROM users u1
			JOIN users u2 ON u1.id <> u2.id 
			LEFT JOIN friends f ON u1.id = f.user1 AND u2.id = f.user2 
			LEFT JOIN user_profile p ON u1.id = p.user_id 
			WHERE f.user2 IS NULL AND (u2.id = ? OR u1.id = ?) AND u1.id != ? GROUP BY u1.id
		"); 
		$stmt->bind_param('iii',$this->me,$this->me,$this->me);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($this->m_id,$this->m_username,$this->m_fullname,$this->m_gender,$this->m_dob,$this->m_profile_pic,$var); 
		
			while($stmt->fetch()){
				$this->m_info[] = array(
					'm_id' => $this->m_id,
					'm_username' => $this->m_username,
					'm_fullname' => $this->m_fullname,
					'm_gender' => $this->m_gender,
					'm_dob' => $this->m_dob,
					'm_profile_pic' => $this->m_profile_pic,
				);
			}
		return $this->m_info;
	}

}

class getSingleMember {
	public $m_id;
	public $m_username;
	public $m_level;
	public $m_reg_date;
	public $m_fullname;
	public $m_gender;
	public $m_dob;
	public $m_country;
	public $m_city;
	public $m_phone;
	public $m_profile_pic;
	public $m_cover_photo;
	public $m_hobbies;
	public $m_relshp_status;
	public $m_info;
	public $p_id;
	
	private $me;
	
	public function __construct (){
		$this->me = $_SESSION['isv_user_id'];
	}
	
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
				p.relshp_status 
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			WHERE u.id=?
		"); 
		$stmt->bind_param('i',$this->m_id);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($this->m_id,$this->m_username,$this->m_level,$this->m_reg_date,$this->p_id,$this->m_fullname,$this->m_gender,$this->m_dob,$this->m_country,$this->m_city,$this->m_phone,$this->m_profile_pic,$this->m_cover_photo,$this->m_hobbies,$this->m_relshp_status); 
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
