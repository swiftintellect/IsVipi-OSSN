<?php
	class settings {
		
		public function __construct(){}
		
		public function g_changes($s){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//update
			$stmt = $isv_db->prepare("UPDATE s_info SET s_url=?,s_title=?,s_email=?,s_time_zone=? WHERE id=1");
		    $stmt->bind_param('ssss',$s['url'],$s['Title'],$s['Email'],$s['Timezone']);
		    $stmt->execute();
		    $stmt->close();
			
			//return success
			$_SESSION['isv_success'] = 'Settings updated.';
		 	header('location:'.$from_url.'');
		 	exit();
		}
		
		
	}