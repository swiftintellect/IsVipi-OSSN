<?php
	/*** check if the site is already set up */
	if (!file_exists('isv_inc/isv_db/db.php')){
		require_once ('isv_inc/isv_pre_install/prompt.php');
		exit();
	} 
	/*** load important files **/
	require_once 'isv_inc/isv_db/db.php';
	require_once 'isv_init.php';
	require_once ISVIPI_CLASSES_BASE.'global/init_cls.php';
	require_once ISVIPI_FUNCTIONS_BASE .'global/global_fnc.php';
	require_once ISVIPI_CLASSES_BASE .'global/global_cls.php';
	//require_once 'isv_lang/'. $isv_siteDetails['s_lang'] . '.isvl';
	
	/*** Define some constants **/
	define('ISVIPI_ACT_THEME', ISVIPI_THEMES .$isv_siteDetails['s_theme'].'' .DIRECTORY_SEPARATOR);
	define ('ISVIPI_ACT_THEME_URL', ISVIPI_URL .'themes/' .$isv_siteDetails['s_theme'].'' .DIRECTORY_SEPARATOR);
	define ('ISVIPI_ACT_ADMIN_URL', ISVIPI_URL .$isv_siteSettings['adminEnd'].'' .DIRECTORY_SEPARATOR);
	define('ISV_VERSION', '2.0.0');

	/*** declare timezone **/
	if($isv_siteSettings['defaultTzone'] === 1){
		date_default_timezone_set ($isv_siteDetails['s_time_zone']);
	}
	
	/*** hide php errors if admin has enabled this option */
	if($isv_siteSettings['hide_errors'] === 1){
		error_reporting(0);
		ini_set('display_errors', 0);
	}
	
	/*** run cron job */
	if($isv_siteSettings['sys_cron'] === 1){
		require_once(ISVIPI_CRON_BASE .'cron.php');
	}
	
	
	/*** DO NOT ALTER ANYTHING BELOW THIS LINE 
	____________________________________________*/
	
	$URL = str_replace(
		array( '\\', '../' ),
		array( '/',  '' ),
		$_SERVER['REQUEST_URI']
	);
	if ($offset = strpos($URL,'?')) {
		// strip getData
		$URL = substr($URL,0,$offset);
	} else if ($offset = strpos($URL,'#')) {
		$URL = substr($URL,0,$offset);
	}
	if (URL_ROOT != '/') $URL=substr($URL,strlen(URL_ROOT));
		$URL = trim($URL,'/');
	// 404 if trying to call a real file
	if (
		file_exists(DOC_ROOT.'/'.$URL) &&
		($_SERVER['SCRIPT_FILENAME'] != DOC_ROOT.$URL) &&
		($URL != '') &&
		($URL != 'index.php')
	) notFound404Err();
	$PAGE = (
		($URL == '') ||
		($URL == 'index.php') ||
		($URL == 'index.html')
	) ? array('index') : explode('/',html_entity_decode($URL));
	$includeFile = ''.ISVIPI_PAGES_BASE.''.preg_replace('/[^\w]/','',$PAGE[0]).'.php';
	
	//We set our site url parameters
	if ($PAGE[0] === 'cron'){
		include_once ''.ISVIPI_CRON_BASE.'/'.preg_replace('/[^\w]/','',$PAGE[0]).'.php';
	} else if ($PAGE[0] === 'p') {
		include_once ISVIPI_PROCESS_BASE.preg_replace('/[^\w]/','',$PAGE[1]).'.php';
	} else if ($PAGE[0] === 'aa') {
		include_once ISVIPI_ADMIN_PROC_BASE.preg_replace('/[^\w]/','',$PAGE[1]).'.php';
	}  else if ($PAGE[0] === $isv_siteSettings['adminEnd']) {
		if(!isset($PAGE[1])){
			include_once ISVIPI_ADMIN_BASE.preg_replace('/[^\w]/','','login').'.php';
		} else if(isset($PAGE[1]) && file_exists(ISVIPI_ADMIN_BASE.$PAGE[1]. '.php')){
			include_once ISVIPI_ADMIN_BASE.preg_replace('/[^\w]/','',$PAGE[1]).'.php';
		} else {
			admin404Err();
		}
	} else if (is_file($includeFile)) {
		include_once($includeFile);
	} else notFound404Err();
?>