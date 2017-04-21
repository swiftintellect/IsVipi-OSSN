<?php
	class front_cron {
		
		public function __construct(){}
		
		public function del_inactive_sessions(){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare("DELETE FROM sessions WHERE last_activity < (UTC_TIMESTAMP() - INTERVAL 30 MINUTE)");
		  $stmt->execute();
		  $stmt->close();
			
		}
		
		public function del_unvalidated_entries(){
			global $isv_db;
			
			$stmt = $isv_db->prepare("DELETE FROM user_validations WHERE time < (UTC_TIMESTAMP() - INTERVAL 2 WEEK)");
		    $stmt->execute();
		    $stmt->close();
		}
		
		public function del_ignored_frnd_reqs(){
			global $isv_db;
			
			$stmt = $isv_db->prepare("DELETE FROM friend_requests WHERE (status=0 AND time < (UTC_TIMESTAMP() - INTERVAL 12 WEEK))");
		    $stmt->execute();
		    $stmt->close();
			
		}
	
	
	
	}
	