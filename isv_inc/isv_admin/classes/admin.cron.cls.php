<?php
  class admin_cron {
	  
	  public function del_inactive_sessions(){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare("DELETE FROM admin_sessions WHERE last_activity < (UTC_TIMESTAMP() - INTERVAL 10 MINUTE)");
		  $stmt->execute();
		  $stmt->close();
	  }
	  
	  
	  
  }