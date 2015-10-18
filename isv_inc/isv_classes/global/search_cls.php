<?php
	class search {
		
		public function __construct(){}
		
		public function find($term){
			global $isv_db;
			
			$term = "%$term%";
			
			$stmt = $isv_db->prepare ("
			SELECT 
				u.id,
				u.username,
				p.fullname,
				p.gender,
				p.dob,
				p.profile_pic
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			WHERE u.username LIKE ? OR p.fullname LIKE ? GROUP BY u.id
		"); 
		$stmt->bind_param('ss',$term,$term);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($user_id,$username,$fullname,$gender,$dob,$profile_pic);
		$result_count = $stmt->num_rows();
		
			if($result_count > 0){
				while($stmt->fetch()){
					$allResults[] = array(
						'id' => $user_id,
						'username' => $username,
						'fullname' => $fullname,
						'gender' => $gender,
						'dob' => $dob,
						'profile_pic' => $profile_pic
					);
				}
			} else {
				$allResults[] = array();
			}
		
		return $allResults;
		//print_r($allResults); exit();
		}
		
		public function count_results($term){
			global $isv_db;
			
			$term = "%$term%";
			
			$stmt = $isv_db->prepare ("
			SELECT 
				u.id,
				u.username,
				p.fullname,
				p.gender,
				p.dob,
				p.profile_pic
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			WHERE u.username LIKE ? OR p.fullname LIKE ? GROUP BY u.id
		"); 
		$stmt->bind_param('ss',$term,$term);
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($user_id,$username,$fullname,$gender,$dob,$profile_pic);
		$result_count = $stmt->num_rows();
		
			return $result_count;
		}
		
	}