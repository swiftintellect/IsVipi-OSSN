<?php require_once(ISVIPI_ADMIN_CLS_BASE .'init.cls.php');
	$track = new admin_security();
	
	//first check if the admin is logged in
	if($track->admin_logged_in()){
		
		$_SESSION = array();
		$currSession = session_id();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		//delete session from the database
		$stmt = $isv_db->prepare("DELETE from admin_sessions WHERE (sess_id=? OR user_id=?)");
		$stmt->bind_param('si', $currSession, $_SESSION['isv_admin_id']);
		$stmt->execute();
		$stmt->close();
		
		session_destroy();
		
		header('location:'.ISVIPI_ACT_ADMIN_URL.'login/');
		exit();
	} else {
		notFound404Err();
	}
?>