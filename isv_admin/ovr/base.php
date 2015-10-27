<?php 
	require_once(ISVIPI_ADMIN_BASE .'functions.php');
	require_once(ISVIPI_ADMIN_CLS_BASE .'init.cls.php');
	$track = new admin_security();
	if(!$track->admin_logged_in()){
		
		$_SESSION['isv_adm_prelogin_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['isv_error'] = "You must be logged in to view this page.";
	    require_once(ISVIPI_ADMIN_BASE .'login.php');
		exit();
		
	}
?>