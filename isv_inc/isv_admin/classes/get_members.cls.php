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
	
	public function member($user){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("
			SELECT 
				u.id,
				u.username,
				u.email,
				u.status,
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
		$stmt->bind_param('i',$user);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($m_id,$m_username,$m_email,$m_status,$m_level,$m_reg_date,$p_id,$m_fullname,$m_gender,$m_dob,$m_country,$m_city,$m_phone,$m_profile_pic,$m_cover_photo,$m_hobbies,$m_relshp_status,$feedSettings,$phoneSettings); 
		$stmt->fetch();
		$stmt->close();
				$m_info = array(
					'id' => $m_id,
					'username' => $m_username,
					'email' => $m_email,
					'status' => $m_status,
					'level' => $m_level,
					'reg_date' => $m_reg_date,
					'prof_id' => $p_id,
					'fullname' => $m_fullname,
					'gender' => $m_gender,
					'dob' => $m_dob,
					'country' => $m_country,
					'city' => $m_city,
					'phone' => $m_phone,
					'profile_pic' => $m_profile_pic,
					'cover_photo' => $m_cover_photo,
					'hobbies' => $m_hobbies,
					'rel_status' => $m_relshp_status,
					'feed_settings' => $feedSettings,
					'phone_settings' => $phoneSettings
				);
				
		//print_r($m_info); exit();
		return $m_info;
	}
	

}
