<?php
	class get_messages {
		
		public function __construct(){}
		
		public function msg_count($user){
			global $isv_db;
			
			$delBy = 0;
			$stmt = $isv_db->prepare ("SELECT id FROM user_pm WHERE (to_id=? OR from_id=?) AND (read_time = '' OR read_time IS NULL) AND (deleted_by=?) GROUP BY from_id"); 
			$stmt->bind_param('iii', $user,$user,$delBy);
			$stmt->execute();  
			$stmt->store_result();
			$stmt->bind_result($id); 
			$total = $stmt->num_rows();
			$stmt->fetch();
			$stmt->close();
				
			return $total;
		}
		
		public function chat_users($user){
			global $isv_db;
			
			$delBy = 0;
			$stmt = $isv_db->prepare ("
			SELECT 
				pm.id,
				pm.from_id,
				pm.to_id,
				u.username,
				p.fullname
				FROM user_pm pm 
				LEFT JOIN users u ON u.id = (CASE WHEN pm.from_id=$user 
                                   THEN pm.to_id
                                   ELSE pm.from_id  
                               END)
				LEFT JOIN user_profile p ON p.user_id = (CASE WHEN pm.from_id=$user 
                                   THEN pm.to_id
                                   ELSE pm.from_id  
                               END)
				WHERE (pm.to_id=$user OR pm.from_id =$user) AND (pm.read_time = '' OR pm.read_time IS NULL) AND (pm.deleted_by=?) 					
				GROUP   BY  u.username
				ORDER BY pm.id DESC
			
			"); 
			$stmt->bind_param('i', $delBy);
			$stmt->execute(); 
			$stmt->store_result(); 
			$stmt->bind_result($pm_id,$pm_from_id,$pm_to_id,$pm_username,$pm_fullname);
			if($stmt->num_rows() > 0){
				while($stmt->fetch()){
					$resultArray[] = array(
							'id' => $pm_id,
							'from_id' => $pm_from_id,
							'to_id' => $pm_to_id,
							'username' => $pm_username,
							'fullname' => $pm_fullname
						);
				}
			} else {
				$resultArray[] = array();
			}
			$stmt->close();
			
			//print_r($resultArray);exit();
			return $resultArray;

		}
		
		
	}