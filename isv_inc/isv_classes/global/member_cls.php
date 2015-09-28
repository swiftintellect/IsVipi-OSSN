<?php
class member {
	public $user_id;
	
	public function __construct($user){
		$this->user_id = $user;
	}
	
	public function memberDetails(){
		global $isv_db;
		
		$stmt = $isv_db->prepare("SELECT
		  	u.username,
			u.email,
			u.status,
			u.level,
			u.reg_date,
			u.last_activity,
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
			FROM users AS u
			INNER JOIN user_profile AS p ON u.id = p.user_id WHERE u.id=?;");
		$stmt->bind_param('i', $this->user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($username,$email,$userStatus,$level,$regDate,$lastActvty,$fullName,$gender,$dob,$country,$city,$phone,$profilePic,$coverPhoto,$hobbies,$relshpStatus);
		$stmt->fetch();
		$stmt->close();
			return array(
				'username' => $username,
				'email' => $email,
				'status' => $userStatus,
				'level' => $level,
				'reg_date' => $regDate,
				'last_activity' => $lastActvty,
				'full_name' => $fullName,
				'gender' => $gender,
				'dob' => $dob,
				'country' => $country,
				'city' => $city,
				'phone' => $phone,
				'profile_pic' => $profilePic,
				'cover_photo' => $coverPhoto,
				'hobbies' => $hobbies,
				'rel_status' => $relshpStatus
			);
	}
	
	
	
}