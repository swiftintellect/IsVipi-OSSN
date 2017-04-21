<?php
  class admin_security {
	  
	  public function __construct(){
		  //capture and save user ip and session
		  $this->save_user_session_ip();
	  }
	  
	  private function save_user_session_ip(){
		  global $isv_db;
		  
		  $sess = session_id();
		  $ip = get_user_ip();
		  
		  if($ip === "::1"){
			 $ip = "192.168.2.34"; 
		  }
		  
		  //check if the session is already in our db
		  if($this->session_found($sess)){
			  //update admin_id,ip and last activity
			  $stmt = $isv_db->prepare("UPDATE admin_sessions SET last_activity=UTC_TIMESTAMP() WHERE sess_id=?");
			  $stmt->bind_param('s',$sess);
			  $stmt->execute();
			  $stmt->close();
			  
			  
		  } else {
			  //insert
			  
			  $stmt = $isv_db->prepare("INSERT INTO admin_sessions (sess_id,user_ip,last_activity) VALUES (?,?,UTC_TIMESTAMP())");
			  $stmt->bind_param('ss',$sess,$ip);
			  $stmt->execute();
			  $stmt->close();
			  
		  }
			  
				  
	  }
	  
	  
	  public function admin_logged_in(){
		  global $admin_ip;
		  
		  /** logic - an admin is logged in:
		  	1. If the $_SESSION['isv_admin_id'] variable exists
			2. If $_SESSION['isv_admin_id'] exists and is not empty
			3. If a session exists in the db matching the admin_id and session_id
			4. If the ip in the db matches the one we capture
		  **/
		  
		  if(
			  isset($_SESSION['isv_admin_id']) && 
			  !empty($_SESSION['isv_admin_id']) &&
		  	  $this->ip_from_admin_id_sess($_SESSION['isv_admin_id']) &&
			  $admin_ip === get_user_ip()
		  ){
			  return true;
		  } else {
			  return false;
		  }
	  }
	  
	  public function session_found($sess){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare ("SELECT id from admin_sessions WHERE sess_id=?"); 
		  $stmt->bind_param('s', $sess);
		  $stmt->execute(); 
		  $stmt->store_result();
		  $stmt->bind_result($sess_id);
		  $stmt->fetch(); 
		  	if($stmt->num_rows() > 0){
				return true;
			} else {
				return false;
			}
		  $stmt->close();
	  }
	  
	  private function ip_from_admin_id_sess($admin_id){
		  global $isv_db,$admin_ip;
		  $sess = session_id();
		  
		  $stmt = $isv_db->prepare("SELECT user_ip FROM admin_sessions WHERE sess_id=? AND user_id=?");
		  $stmt->bind_param('si', $sess,$admin_id);
		  $stmt->execute();
		  $stmt->store_result();
		  $stmt->bind_result($admin_ip);
		  $stmt->fetch();
		  	if($stmt->num_rows() > 0 ){
				return TRUE;
			} else {
				return FALSE;
			}
		  $stmt->close();
	  }
	  
	  public function admin_details($admin_id){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare("SELECT id,email,name,status,level,reg_date,ip FROM isv_admin WHERE id=?");
		  $stmt->bind_param('i', $admin_id);
		  $stmt->execute();
		  $stmt->store_result();
		  $stmt->bind_result($adm_id,$adm_email,$adm_name,$adm_status,$adm_level,$adm_regdate,$adm_ip);
		  $stmt->fetch();
		  $stmt->close();
		  
		  $d = array();
		  $d = array(
		  	'id' => $adm_id,
			'email' => $adm_email,
			'name' => $adm_name,
			'status' => $adm_status,
			'level' => $adm_level,
			'reg_date' => $adm_regdate,
			'ip' => $adm_ip
		  
		  );
		  
		  //print_r($d); exit();
		  return $d;
		  
	  }
  }