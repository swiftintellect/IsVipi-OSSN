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
  		
	  public function del_users_scheduled(){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare("SELECT user_id FROM scheduled_del WHERE schedule_time < (UTC_TIMESTAMP() - INTERVAL 2 WEEK)");
		  $stmt->execute(); 
		  $stmt->store_result();
		  $stmt->bind_result($u_id);
		  $count = $stmt->num_rows();
		  if($count > 0){
			  while($stmt->fetch()){
				 //delete user feeds (feeds,comments,likes,shares etc)
				 $this->del_user_feeds($u_id);
				 				 
				 //delete user friends
				 $this->del_friendships($u_id);
				 
				 //delete friend requests
				 $this->del_friend_req($u_id);
				 
				 //delete friend request alerts
				 $this->del_friend_req_alerts($u_id);
				 
				 //delete user messages (user_pm)
				 $this->del_user_msgs($u_id);
				 
				 //delete user details (user,user_profile,user_settings,users_blocked, scheduled_del)
				 $this->del_user_details($u_id);
			  }
			  
		  }
		  $stmt->close();
		  
	  }
	  
	  private function del_user_feeds($uid){
		  global $isv_db;
		  $stmt = $isv_db->prepare ("
				DELETE f, fl, fc, fcl, fs, fn
				  FROM feeds f
				  LEFT JOIN feed_likes fl ON fl.user_id = f.user_id
				  LEFT JOIN feed_comments fc ON fc.user_id = f.user_id
				  LEFT JOIN feed_comment_likes fcl ON fcl.user_id = f.user_id
				  LEFT JOIN feed_shares fs ON fs.feed_user = f.user_id
				  LEFT JOIN feed_notices fn ON fn.feed_owner = f.user_id
				 WHERE f.user_id = ? 
			"); 
			$stmt->bind_param('i', $uid);
			$stmt->execute(); 
			$stmt->close();
	  }
	  
	  private function del_friendships($uid){
		  global $isv_db;
		  $stmt = $isv_db->prepare ("
				DELETE FROM friends WHERE (user1=? OR user2=?) 
			"); 
			$stmt->bind_param('ii', $uid,$uid);
			$stmt->execute(); 
			$stmt->close();
	  }
	  
	  private function del_friend_req($uid){
		  global $isv_db;
		  $stmt = $isv_db->prepare ("
				DELETE FROM friend_requests WHERE (from_id=? OR to_id=?) 
			"); 
			$stmt->bind_param('ii', $uid,$uid);
			$stmt->execute(); 
			$stmt->close();
	  }
	  
	  private function del_friend_req_alerts($uid){
		  global $isv_db;
		  $stmt = $isv_db->prepare ("
				DELETE FROM friend_req_alerts WHERE (from_id=? OR to_id=?) 
			"); 
			$stmt->bind_param('ii', $uid,$uid);
			$stmt->execute(); 
			$stmt->close();
	  }
	  
	  private function del_user_msgs($uid){
		  global $isv_db;
		  $stmt = $isv_db->prepare ("
				DELETE FROM user_pm WHERE (from_id=? OR to_id=?) 
			"); 
			$stmt->bind_param('ii', $uid,$uid);
			$stmt->execute(); 
			$stmt->close();
	  }
	  
	  private function del_user_details($uid){
		  global $isv_db;
		  $stmt = $isv_db->prepare ("
				DELETE u, ub, up, us, sd
				  FROM users u
				  LEFT JOIN users_blocked ub ON ub.user1 = u.id
				  LEFT JOIN user_profile up ON up.user_id = u.id
				  LEFT JOIN user_settings us ON us.user_id = u.id
				  LEFT JOIN scheduled_del sd ON sd.user_id = u.id
				 WHERE u.id = ? 
			"); 
			$stmt->bind_param('i', $uid);
			$stmt->execute(); 
			$stmt->close();
	  }
  }