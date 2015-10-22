<?php
	class get_messages {
		
		public function __construct(){}
		
		public function msg_count($user){
			global $isv_db;
			
			$delBy = 0;
			$stmt = $isv_db->prepare ("SELECT id FROM user_pm WHERE (to_id=? OR from_id=?) AND (deleted_by=?) GROUP BY from_id"); 
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
				WHERE (pm.to_id=$user OR pm.from_id =$user) AND (pm.deleted_by=?) 					
				GROUP   BY  u.username
				ORDER BY read_time DESC, pm.id ASC
			
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
		
		public function chat_exists($me,$other_user){
			global $isv_db;
			
			$both = 00;
			$stmt = $isv_db->prepare ("SELECT id from user_pm WHERE (from_id=? AND to_id=?) OR (to_id=? AND from_id=?) AND (deleted_by !=? OR deleted_by !=?)"); 
			$stmt->bind_param('iiiiii', $me,$other_user,$me,$other_user,$me,$both);
			$stmt->execute(); 
			$stmt->store_result();
			$stmt->bind_result($user_id);
			$count = $stmt->num_rows();
			$stmt->close();
				if($count > 0){
					return TRUE;
				} else {
					return FALSE;
				}
		}
		
		public function all_messages($me,$other){
			global $isv_db;
			
			$delBy = 0;
			$stmt = $isv_db->prepare ("
			
			SELECT 
				pm.id,
				pm.from_id,
				pm.to_id,
				pm.message,
				pm.read_time,
				pm.sent_time,
				u.username,
				p.fullname,
				p.profile_pic
				FROM user_pm pm 
				LEFT JOIN users u ON u.id = pm.from_id
				LEFT JOIN user_profile p ON p.user_id = pm.from_id
				WHERE (pm.to_id=? AND pm.from_id=?) OR (pm.from_id=? AND pm.to_id =?) AND (pm.deleted_by=?) 					
				ORDER BY pm.id ASC
			
			"); 
			$stmt->bind_param('iiiii', $me,$other,$me,$other,$delBy);
			$stmt->execute(); 
			$stmt->store_result(); 
			$stmt->bind_result($pm_id,$pm_from_id,$pm_to_id,$pm_msg,$pm_read_time,$pm_sent_time,$pm_username,$pm_fullname,$pm_profile_pic);
			if($stmt->num_rows() > 0){
				while($stmt->fetch()){
					$resultArray[] = array(
							'id' => $pm_id,
							'from_id' => $pm_from_id,
							'to_id' => $pm_to_id,
							'message' => $pm_msg,
							'read_time' => $pm_read_time,
							'sent_time' => $pm_sent_time,
							'username' => $pm_username,
							'fullname' => $pm_fullname,
							'profile_pic' => $pm_profile_pic
						);
				}
			} else {
				$resultArray[] = array();
			}
			$stmt->close();
			
			//print_r($resultArray);exit();
			return $resultArray;
			
		}
		
		public function update_as_read($me,$other){
			global $isv_db;
			$stmt = $isv_db->prepare ("UPDATE user_pm SET read_time=UTC_TIMESTAMP()
			WHERE (from_id=? AND to_id=?) AND (read_time='')"); 
			$stmt->bind_param('ii', $other,$me);
			$stmt->execute(); 
			$stmt->close();
		}
		
		public function last_msg_id($me,$other){
			global $isv_db;
			$stmt = $isv_db->prepare ("SELECT id FROM user_pm WHERE (from_id=? AND to_id=?) OR (to_id=? AND from_id=?) ORDER BY id DESC LIMIT 1"); 
			$stmt->bind_param('iiii', $other,$me,$other,$me);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($last_msg_id); 
			$stmt->fetch();
				if($stmt->num_rows() > 0){
					return $last_msg_id;
				} else {
					return '';
				}
		}
		
		
	}