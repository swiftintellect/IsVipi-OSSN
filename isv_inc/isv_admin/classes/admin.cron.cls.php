<?php
  class admin_cron {
	  
	  public function del_inactive_sessions(){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare("DELETE FROM admin_sessions WHERE last_activity < (UTC_TIMESTAMP() - INTERVAL 10 MINUTE)");
		  $stmt->execute();
		  $stmt->close();
	  }
	  
	  public function isv_update_available(){
		global $isv_db,$isv_siteSettings;
		
		if (empty($isv_siteSettings['last_upd_check']) || strtotime($isv_siteSettings['last_upd_check']) < strtotime('-14 days')){
			//current stable version available for download
			define('REMOTE_VERSION', 'http://isvipi.org/version/version');
			$curr_ = file_get_contents(REMOTE_VERSION);
			
			//update the last time we checked for an update
			$stmt = $isv_db->prepare("UPDATE s_settings SET last_upd_check = UTC_TIMESTAMP() WHERE id=1");
			$stmt->execute();
			$stmt->close();
	
			if($curr_ > ISV_VERSION) {
				
				//update available
				$stmt = $isv_db->prepare("UPDATE s_settings SET upd_avail = 1 WHERE id=1");
				$stmt->execute();
				$stmt->close();
				
				return TRUE;
			} else {
				//update not available
				$stmt = $isv_db->prepare("UPDATE s_settings SET upd_avail = 0 WHERE id=1");
				$stmt->execute();
				$stmt->close();
				return FALSE;
			}
			
		} else {
			return FALSE;
		}
	  }
  
	  
	  
	  
  }