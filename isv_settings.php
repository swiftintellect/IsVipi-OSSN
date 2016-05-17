<?php
	/*** SITE SETTINGS ***/
	define('ISV_VERSION', '2.0.2'); //IsVipi OSSN current installed version
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
	define('NOTIFY_ADMIN_NEW_USER', !!$m_settings['notify_admin_newuser']); //notify admin new user registered
	define('ISV_FEEDS_TO_LOAD', $f_settings['number_feeds']); //set the default number of feeds to load.
	define('MAX_PHOTO_ALBMS', $m_settings['max_albums']); //set maximum number of photo albums per memmber
	define('MAX_PHOTOS_IN_ALBM', $m_settings['max_photos_in_album']); //set maximum number of photos in an album per memmber
	
	/*** DEFINE URL PARAMETERS ***/
	define ('ISVIPI_ACT_THEME_URL', ISVIPI_URL .'themes/' .$isv_siteDetails['s_theme'].'' .DIRECTORY_SEPARATOR); //theme url
	define ('ISVIPI_ACT_ADMIN_URL', ISVIPI_URL .$isv_siteSettings['adminEnd'].'' .DIRECTORY_SEPARATOR); //admin url
	
	/*** Define language ***/
	define ('SITE_LANG', $isv_siteDetails['s_lang']); //set site language
	
	/*** TIMEZONE SETTINGS ***/
	if($isv_siteSettings['defaultTzone'] === 1){
		date_default_timezone_set (ISV_DEFAULT_TZ); //set timezone to system default one
	} else {
		date_default_timezone_set ($isv_siteDetails['s_time_zone']); //set timezone to admin defined
	}

	/*** HIDE PHP ERRORS SETTINGS ***/
	if($isv_siteSettings['hide_errors'] === 1){
		error_reporting(0); //disable php site errors
		ini_set('display_errors', 0);
	}
	
	/*** CRON JOBS SETTINGS ***/
	if($isv_siteSettings['sys_cron'] === 1){
		require_once(ISVIPI_CRON_BASE .'cron.php'); //run system cronjob when someone loads a page on the site
	}
	
	/*** SITE INDEXING ***/
	define('DISCOURAGE_INDEXING', true); // allow/disallow search engines from indexing and following your site
	
	/*** IMAGE SIZES ***/
	define('ISVIPI_THUMBS', '150x150_'); //photo thumbnails that appear as profile pictures
	define('ISVIPI_600', '600x600_');//photos that load using lightbox

?>
