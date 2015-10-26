<?php
  class admin_activity {
	  
	  public function __construct(){}
	  
	  public function admin_login($user){
		  global $isv_db;
		  
		  $from_url = $_SERVER['HTTP_REFERER'];
		  $ip = get_user_ip();
		  $sess = session_id();
		  
		  //check if the admin email is registered
		  if(!$this->admin_email_exists($user['Email'])){
			  $_SESSION['isv_error'] = 'No user with that email address exists.';
		 	  header('location:'.$from_url.'');
		 	  exit();
		  }
		  
		  //check the status of the user
		  global $db_status;
		  if($db_status === 0){
			  $_SESSION['isv_error'] = 'This admin account has not been activated.';
		 	  header('location:'.$from_url.'');
		 	  exit(); 
		  }
		  
		  //verify the password
		  global $db_pwd;
		  if (!password_verify($user['Password'], $db_pwd)) {
			  $_SESSION['isv_error'] = 'Email/Password incorrect.';
		 	  header('location:'.$from_url.'');
		 	  exit();
		  }
		  
		  //start admin session
		  global $db_id;
		  $_SESSION['isv_admin_id'] = $db_id;
		  
		  //update admin session's table
		  $stmt = $isv_db->prepare("UPDATE admin_sessions SET user_id=?,user_ip=?,last_activity=UTC_TIMESTAMP() WHERE sess_id=?");
		  $stmt->bind_param('iss',$_SESSION['isv_admin_id'],$ip,$sess);
		  $stmt->execute();
		  $stmt->close();
		  
		  //redirect to the admin dashboard
		  global $isv_siteSettings;
		  
		  	if(isset($_SESSION['isv_adm_prelogin_url']) && !empty($_SESSION['isv_adm_prelogin_url'])){
				$to_url = $_SESSION['isv_adm_prelogin_url'];
			} else {
				$to_url = ISVIPI_URL.$isv_siteSettings['adminEnd'].'/dashboard/';
			}
		  header('location:'.$to_url.'');
		  exit();
		  
		  
	  }
	  
	  private function admin_email_exists($email){
		  global $isv_db,$db_id,$db_pwd,$db_status;
		  
		$stmt = $isv_db->prepare ("SELECT id,pwd,status from isv_admin WHERE email=?"); 
		$stmt->bind_param('s', $email);
		$stmt->execute(); 
		$stmt->store_result();
		$stmt->bind_result($db_id,$db_pwd,$db_status);
		$stmt->fetch(); 
			if($stmt->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close();
	  }
	  
  }