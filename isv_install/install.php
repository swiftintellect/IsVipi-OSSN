<?php 
	session_start();
	require_once('../isv_init.php');
	require_once('../isv_inc/isv_functions/global/global_fnc.php');
	require_once('isv_install_cls.php');
	
	//we prohibit direct access to this file
	if(!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])){
		$_SESSION['isv_error'] = 'You cannot access this page directly.';
		header('location:'.ISVIPI_URL.'');
		exit();
	} else {
		$from_url = $_SERVER['HTTP_REFERER'];
	}
	
	//check if our post or get variables have been sent
	if (isset($_POST['isv_inst']) && !empty($_POST['isv_inst'])){
		 $op = cleanPOST('isv_inst');
	 } else if(isset($_GET['proceed']) && !empty($_GET['proceed'])){
		 $op = cleanGET($_GET['proceed']);
	 } else {
		 $_SESSION['isv_error'] = 'An error occured. An important post variable was not supplied';
		 header('location:'.$from_url.'');
		 exit();
	 }
	 
	 if ($op !== 'true' && $op !== 'step2' && $op !== 'step3' && $op !== 'step4'){
		 $_SESSION['isv_error'] = 'An error occured. Wrong input supplied.';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	//instantiate our class
	$install = new install();
	
	/*** STEP ONE (System Requirements) **/
	if ($op === 'true'){
		
		//unset step one
		unset($_SESSION['isv_s1']);
		
		//create a session for step two
		$_SESSION['isv_s1'] = 's2';
		
		//redirect back
		header('location:'.$from_url.'');
		exit();
	}
	
	/*** STEP TWO (Database Details) **/
	if ($op === 'step2'){
		$var = array(
			'Host' => cleanPOST('host'),
			'Database' => cleanPOST('db_name'),
			'User' => cleanPOST('db_user'),
			'Password' => cleanPOST('db_pwd'),
		);
		
		if(!isSupplied($var['Host'])){
			$_SESSION['isv_error'] = 'Please fill in your database host!';
			header('location:'.$from_url.'');
			exit();
		}
		if(!isSupplied($var['Database'])){
			$_SESSION['isv_error'] = 'Please fill in your database name!';
			header('location:'.$from_url.'');
			exit();
		}
		if(!isSupplied($var['User'])){
			$_SESSION['isv_error'] = 'Please fill in your database user!';
			header('location:'.$from_url.'');
			exit();
		}
		
		//proceed with step two 
		$install->step_two($var);
	}
	
	
	/*** STEP THREE (Site Details) **/
	if ($op === 'step3'){
		$var = array(
			'URL' => cleanPOST('url'),
			'Title' => cleanPOST('title'),
			'Email' => cleanPOST('email'),
			'Timezone' => cleanPOST('timezone'),
		);
		
		//check if any is empty
		foreach( $var as $field => $value){
			if(!isSupplied($value)){
				 $_SESSION['isv_error'] = 'Please fill in '.$field.'!';
				 header('location:'.$from_url.'');
				 exit();
			}
		}
		
		//validate url
		if (!filter_var($var['URL'], FILTER_VALIDATE_URL)) {
			$_SESSION['isv_error'] = 'Please check your site url.';
			header('location:'.$from_url.'');
			exit();
		}
		
		//validate email
		if (!filter_var($var['Email'], FILTER_VALIDATE_EMAIL)) {
		  	$_SESSION['isv_error'] = 'Please check your site Email.';
			header('location:'.$from_url.'');
			exit();
		}
		
		//proceed with step three
		$install->step_three($var);
	}
	
	/*** STEP FOUR (Admin Details) **/
	if ($op === 'step4'){
		$var = array(
			'Name' => cleanPOST('name'),
			'Email' => cleanPOST('email'),
			'Password' => cleanPOST('pwd'),
			'Repeat Password' => cleanPOST('rpwd'),
		);
		
		//check if any is empty
		foreach( $var as $field => $value){
			if(!isSupplied($value)){
				 $_SESSION['isv_error'] = 'Please fill in '.$field.'!';
				 header('location:'.$from_url.'');
				 exit();
			}
		}
		
		//validate email
		if (!filter_var($var['Email'], FILTER_VALIDATE_EMAIL)) {
		  	$_SESSION['isv_error'] = 'Please check your site Email.';
			header('location:'.$from_url.'');
			exit();
		}
		
		//minimum password length of 8 characters
		if(strlen($var['Password']) < 8){
			$_SESSION['isv_error'] = 'Your Passwords MUST be a minimum of 8 characters';
			header('location:'.$from_url.'');
			exit();
		}
		
		//check if passwords match
		if($var['Password'] !== $var['Repeat Password']){
			$_SESSION['isv_error'] = 'Your Passwords do not match';
			header('location:'.$from_url.'');
			exit();
		}
		
		//proceed with step four
		$install->step_four($var);
		
	}