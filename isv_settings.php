<?php
	/*** SITE SETTINGS ***/
	define('ISV_VERSION', '2.0.1'); //IsVipi OSSN current installed version
	define('ISV_ENCR_KEY', $isv_siteSettings['encry_key']); //Encryption Key
	define('ISVIPI_ACT_THEME', ISVIPI_THEMES .$isv_siteDetails['s_theme'].'' .DIRECTORY_SEPARATOR); //current theme
	define('ISV_DEFAULT_TZ', 'Atlantic/St_Helena'); //Default Timezone
	define('ISV_SITE_TITLE', $isv_siteDetails['s_title']); //Default Timezone
	define('ISV_DEFAULT_EMAIL_FROM', $isv_siteDetails['s_email']); //Default sender email
	define('ALLOW_USER_REG', !!$m_settings['allow_registration']); //Allow user registration
	define('MUST_VALIDATE', !!$m_settings['must_validate']); //User must validate new account
	define('ISV_EMAIL_NOTIFY_ACCOUNT_DELETION', !!$m_settings['notify_acc_deletion']); //email if scheduled for deletion
	define('ISV_EMAIL_NOTIFY_ACCOUNT_UNDELETION', !!$m_settings['notify_acc_undeletion']); //email if removed from deleted.
	define('ISV_EMAIL_NOTIFY_ACCOUNT_SUSPENDED', !!$m_settings['notify_acc_suspension']); //email when suspended
	define('ISV_EMAIL_NOTIFY_ACCOUNT_UNSUSPENDED', !!$m_settings['notify_acc_unsuspension']); //email when unsuspended
	define('ISV_EMAIL_NOTIFY_ACCOUNT_ACTIVATION', !!$m_settings['notify_acc_activation']); //email when activated
	define('NOTIFY_ADMIN_NEW_USER', !!$m_settings['notify_acc_activation']); //notify admin new user registered
	define('ISV_FEEDS_TO_LOAD', $f_settings['number_feeds']); //set the default number of feeds to load.
	
	/*** DEFINE URL PARAMETERS ***/
	define ('ISVIPI_ACT_THEME_URL', ISVIPI_URL .'themes/' .$isv_siteDetails['s_theme'].'' .DIRECTORY_SEPARATOR); //theme url
	define ('ISVIPI_ACT_ADMIN_URL', ISVIPI_URL .$isv_siteSettings['adminEnd'].'' .DIRECTORY_SEPARATOR); //admin url
	
	/*** TIMEZONE SETTINGS ***/
	if($isv_siteSettings['defaultTzone'] === 1){
		date_default_timezone_set (ISV_DEFAULT_TZ);
	} else {
		date_default_timezone_set ($isv_siteDetails['s_time_zone']);
	}

	/*** HIDE PHP ERRORS SETTINGS ***/
	if($isv_siteSettings['hide_errors'] === 1){
		error_reporting(0);
		ini_set('display_errors', 0);
	}
	
	/*** CRON JOBS SETTINGS ***/
	if($isv_siteSettings['sys_cron'] === 1){
		require_once(ISVIPI_CRON_BASE .'cron.php');
	}
	
	/*** IMAGE SIZES ***/
	define('ISVIPI_THUMBS', '150x150_');
	define('ISVIPI_600', '600x600_');

?>