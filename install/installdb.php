<?php
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.org

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 ******************************************************/ 
$from_url = $_SERVER['HTTP_REFERER'];
if (isset($ACTION[1])){
	$op = $ACTION[1];
} else if (isset($_POST['op'])){
	$op = get_post_var('op');
} else {
	die404();
}
if ($op !== 'stepOne' && $op !== 'stepTwo' && $op !== 'stepThree'&& $op !== 'stepFour'){
	$_SESSION['err'] ="Unknown request";
    header ('location:'.$from_url.'');
	exit();
}

/////////////////////////////////////////////////////////////
//////////////// STEP ONE //////////////////////////////////
////////////////////////////////////////////////////////////
if ($op === 'stepOne' && ($_SESSION['proceedOne'] == true)) {
	
	//end session for step one
	unset($_SESSION['sysCheck']);
	
	//start session for step two
	$_SESSION['stepTwo'] = true;
	
	//redirect back to the install file
	header ('location:'.$from_url.'');
	exit();
}
/////////////////////////////////////////////////////////////
//////////////// STEP TWO //////////////////////////////////
////////////////////////////////////////////////////////////
if ($op === 'stepTwo') {

	//SERVER
	$server = get_post_var("dbhost");
	if (empty($server)) {
		$_SESSION['err'] ="Please fill in the server field";
		header ('location:'.$from_url.'');
		exit();
	}
	//USERNAME
	$username = get_post_var("dbusername");
	if (empty($username)) {
		$_SESSION['err'] ="Please fill in the username field";
		header ('location:'.$from_url.'');
		exit();
	}

	//PASSWORD
	$password = get_post_var("dbpassword");
	if (empty($password)) {
		$_SESSION['err'] ="Please fill in the password field";
		header ('location:'.$from_url.'');
		exit();
	}

	//DATABASE
	$database = get_post_var("dbname");
	if (empty($database)) {
		$_SESSION['err'] ="Please fill in the database field";
		header ('location:'.$from_url.'');
		exit();
	}

	//sql file to import
	$filename = 'sql.sql';
	// Connect to MySQL server
	//Try to connect to the database
	$db = new mysqli($server, $username, $password, $database);
	if (mysqli_connect_errno()){
		$_SESSION['err'] ="Could not connect to the database";
		header ('location:install.php');
		exit();
	}
	//Create the db file
	$db_file = '../inc/db/db.php';
	if (file_exists($db_file)){
		unlink($db_file);	
	}
	//open the db file so that we can write our db values
	$handle = fopen($db_file, 'a') or die('Cannot open file:  '.$db_file);
	$copyr = '<?php
	/*******************************************************
	 *   Copyright (C) 2014  http://isvipi.org
	
		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 3 of the License, or
		(at your option) any later version.
	
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
	
		You should have received a copy of the GNU General Public License along
		with this program; if not, write to the Free Software Foundation, Inc.,
		51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
	 ******************************************************/ 
	 ';
	fwrite($handle, $copyr);
	$localhost = "\n".'$db_host = "'.$server.'";';
	fwrite($handle, $localhost);
	$database = "\n".'$db_name = "'.$database.'";';
	fwrite($handle, $database);
	$username = "\n".'$db_user = "'.$username.'";';
	fwrite($handle, $username);
	$password = "\n".'$db_pass = "'.$password.'";';
	fwrite($handle, $password);
	$conn_db = "\n"."\n".'//Try to connect to the database';
	fwrite($handle, $conn_db);
	$dbconnect = "\n".'$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if (mysqli_connect_errno())
		fail("MySQL connect", mysqli_connect_error());';
	fwrite($handle, $dbconnect);
	$select_sett = "\n".'//get important config settings from the database
	$getconf = $db->prepare("SELECT site_url,site_title,site_email,theme,time_zone FROM site_settings");
	$getconf->execute();
	$getconf->store_result();
	$getconf->bind_result($site_url,$site_title,$site_email,$theme,$time_zone);
	$getconf->fetch();
	$getconf->close( );';
	fwrite($handle, $select_sett);
	$close_php = "\n".'?>';
	fwrite($handle, $close_php);

	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file($filename);
	// Loop through each line
	foreach ($lines as $line)
	{
	// Skip it if it's a comment
	if (substr($line, 0, 2) == '--' || $line == '')
		continue;

	// Add this line to the current segment
	$templine .= $line;
	// If it has a semicolon at the end, it's the end of the query
	if (substr(trim($line), -1, 1) == ';')
	{
		// Perform the query
		mysqli_query($db, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
		// Reset temp variable to empty
		$templine = '';
	}
}
	//end step 2 session
	unset($_SESSION['stepTwo']);
	
	//start step 3 session
	$_SESSION['stepThree'] = true;
	$_SESSION['succ'] = 'Database connection and sql import successful.';
 	header ('location:'.$from_url.'');
}

/////////////////////////////////////////////////////////////
//////////////// STEP THREE //////////////////////////////////
////////////////////////////////////////////////////////////

if ($op === 'stepThree') {
//include our db file that we have just created in step two
include_once '../inc/db/db.php';
	//SITE URL
	$site_url = get_post_var("site_url");
	if (empty($site_url)) {
		$_SESSION['err'] ="Please fill in the site url field";
		header ('location:'.$from_url.'');
		exit();
	}

	//SITE TITLE
	$site_title = get_post_var("site_title");
	if (empty($site_title)) {
		$_SESSION['err'] ="Please fill in the Site Title field";
		header ('location:'.$from_url.'');
		exit();
	}
	
	//SITE EMAIL
	$site_email = get_post_var("site_email");
	if (empty($site_email)) {
		$_SESSION['err'] ="Please fill in the Site Email field";
		header ('location:'.$from_url.'');
		exit();
	}

	//SITE TIMEZONE
	$site_timezone = get_post_var("time_zone");
	if (empty($site_timezone)) {
		$_SESSION['err'] ="Please fill in the Site Timezone field";
		header ('location:'.$from_url.'');
		exit();
	}

	//SITE THEME
	$site_theme = 'bluezorra';

	//Add to our database
	global $db;
	$site_status = 0;
	$stmt = $db->prepare('insert into site_settings (site_url,site_title,site_email,theme,time_zone,last_version_check,status) values (?,?,?,?,?,NOW(),?)');
		$stmt->bind_param('sssssi', $site_url, $site_title,$site_email,$site_theme,$site_timezone,$site_status);
		$stmt->execute();
		$stmt->close();
		$user_registration = "0";
		$user_validate = "1";
		$sys_cron = "0";
		$timezone = "0";
		$admin_end = "admin";
		$lang = "en";
	$stmt = $db->prepare('insert into general_settings (user_registration,user_validate,sys_cron,timezone,admin_end,lang) values (?,?,?,?,?,?)');
		$stmt->bind_param('iiiiss', $user_registration,$user_validate,$sys_cron,$timezone,$admin_end,$lang);
		$stmt->execute();
		$stmt->close();
	
	//end step 3 session
	unset($_SESSION['stepThree']);
	
	//start step 3 session
	$_SESSION['stepFours'] = true;
	$_SESSION['succ'] = 'Site details saved successful.';
 	header ('location:'.$from_url.'');
	exit();
}

/////////////////////////////////////////////////////////////
//////////////// STEP FOUR //////////////////////////////////
////////////////////////////////////////////////////////////

if ($op === 'stepFour') {
	//include our database file
	include_once '../inc/db/db.php';
	//include our password hashing class
	include_once '../inc/users.inc/classes/PasswordHash.php';
	//Admin Username
	$adm_username = get_post_var("admin_username");
	if (empty($adm_username)) {
		$_SESSION['err'] ="Please fill in the admin username field";
		header ('location:'.$from_url.'');
		exit();
	}

	//Admin Email
	$adm_email = get_post_var("admin_email");
	if (empty($adm_email)) {
		$_SESSION['err'] ="Please fill in the Admin Email field";
		header ('location:'.$from_url.'');
		exit();
	}

	//Admin Password
	$adm_pass = get_post_var("pass1");
	if (empty($adm_pass)) {
		$_SESSION['err'] ="Please fill in the admin password";
		header ('location:'.$from_url.'');
		exit();
	  }
	if (strlen($adm_pass) < 6){
		$_SESSION['err'] ="Admin Password MUST be more than 6 characters";
		header ('location:'.$from_url.'');
		exit();
	}	
	if (strlen($adm_pass) > 72){
		$_SESSION['err'] ="Password too long";
		header ('location:'.$from_url.'');
		exit();
	}
	$pass2 = get_post_var("pass2");
	if (empty($pass2)){
		$_SESSION['err'] ="Please fill in your repeat password field";
		header ('location:'.$from_url.'');
		exit();
	}
	if ($adm_pass!= $pass2){
		$_SESSION['err'] ="Passwords do not match";
		header ('location:'.$from_url.'');
		exit();
	}
	//we hash our password
	$hash_cost_log2 = 8;
	$hash_portable = FALSE;
	$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
	$hash = $hasher->HashPassword($adm_pass);
	if (strlen($hash) < 20){
		$_SESSION['err'] ="System error. Please try again";
		header ('location:'.$from_url.'');
		exit();
	}
	unset($hasher);
	//Admin active
	$adm_act = 1;

	//Admin Level
	$adm_lev = 1;

//Add to our database
global $db;
$act = '0';
$stmt = $db->prepare('insert into admin (username,password,email,active,level,online,last_activity) values (?,?,?,?,?,?,NOW())');
	$stmt->bind_param('sssiii', $adm_username,$hash,$adm_email,$adm_act,$adm_lev,$act);
	$stmt->execute();
	$stmt->close();
	
	//end step 4 session
	unset($_SESSION['stepFours']);
	
	//start step 3 session
	$_SESSION['finish'] = true;
	$_SESSION['succ'] = 'Admin account created successful.';
    header ('location:'.$from_url.'');
	exit();
}