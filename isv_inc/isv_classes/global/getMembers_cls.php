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
		global $isv_db,$feed;
		
		$this->limit = 20;

		$stmt = $isv_db->prepare ("
			SELECT 
			u.id,
			u.username,
			f.user1,
			p.fullname,
			p.gender,
			p.dob,
			p.profile_pic
			FROM users u
			LEFT JOIN friends f ON u.id = f.user1
			JOIN user_profile p ON p.user_id = u.id
			WHERE u.status=? AND u.id !=? AND f.user1 IS NULL
			
		"); //I wont appear in this list 
		$stmt->bind_param('ii', $status,$this->me);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($this->m_id,$this->m_username,$user1,$this->m_fullname,$this->m_gender,$this->m_dob,$this->m_profile_pic); 
		
			while($stmt->fetch()){
				$this->m_info[] = array(
					'm_id' => $this->m_id,
					'm_username' => $this->m_username,
					'f_user1' => $user1,
					'm_fullname' => $this->m_fullname,
					'm_gender' => $this->m_gender,
					'm_dob' => $this->m_dob,
					'm_profile_pic' => $this->m_profile_pic,
				);
			}
		return $this->m_info;
	}

}
