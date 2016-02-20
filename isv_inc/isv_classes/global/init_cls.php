<?php
class siteManager {
	
	private $s_status;
	private $s_enable_ssl;

	public function __construct(){}
	
	public function getSiteInfo(){
		global $isv_db;
		$stmt = $isv_db->prepare("
			SELECT s_url,
					s_title,
					s_email,
					s_lang,
					s_theme,
					s_time_zone,
					s_enable_ssl,
					s_last_update_check,
					s_status 
			FROM s_info WHERE id=1
		");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($s_url,$s_title,$s_email,$s_lang,$s_theme,$s_time_zone,$s_enable_ssl,$s_lst_updt_check,$s_status);
		$stmt->fetch();
		$stmt->close( );
		
		$this->s_status = $s_status;
		$this->s_enable_ssl = $s_enable_ssl;
		
		return array(
			's_url' => $s_url,
			's_title' => $s_title,
			's_email' => $s_email,
			's_lang' => $s_lang,
			's_theme' => $s_theme,
			's_time_zone' => $s_time_zone,
			's_enable_ssl' => $s_enable_ssl,
			's_lst_updt_check' => $s_lst_updt_check,
			's_status' => $s_status
		);
	}
	
		public function getSiteSettings(){
		global $isv_db;
		$stmt = $isv_db->prepare("
			SELECT user_reg,
				sys_cron,
				timezone,
				admin_end,
				encry_key,
				logo_name,
				favicon,
				mobile,
				plugins,
				errors,
				last_upd_check,
				upd_avail 
			FROM s_settings WHERE id=1
		");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($sett_userReg,$sett_sysCron,$sett_defTimeZone,$sett_adminEnd,$encr_key,$sett_logo,$sett_favicon,$sett_mobile,$sett_plugins,$sett_errors,$last_upd_check,$upd_avail);
		$stmt->fetch();
		$stmt->close( );
		
		return array(
			'user_reg' => $sett_userReg,
			'sys_cron' => $sett_sysCron,
			'defaultTzone' => $sett_defTimeZone,
			'adminEnd' => $sett_adminEnd,
			'encry_key' => $encr_key,
			'logo' =>$sett_logo,
			'favicon' =>$sett_favicon,
			'enable_mobile' => $sett_mobile,
			'enable_plugins' => $sett_plugins,
			'hide_errors' => $sett_errors,
			'last_upd_check' => $last_upd_check,
			'upd_avail' => $upd_avail
		);
	}

	public function maintenanceMode(){
		if ($this -> s_status == 1){
			header('location:'.ISVIPI_URL.'maintenance');
			exit();
		}
	}
	
	public function enableSSL(){
		if ($this -> s_enable_ssl == 1 && $_SERVER["HTTPS"] != "on"){
			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
			exit();
		}
	}
	
	public function get_site_member_settings(){
		global $isv_db;
		
		$stmt = $isv_db->prepare("
			SELECT  allow_registration,
					must_validate,
					notify_acc_deletion,
					notify_acc_undeletion,
					notify_acc_suspension,
					notify_acc_unsuspension,
					notify_acc_activation,
					notify_admin_newuser,
					max_albums,
					max_photos_in_album
			FROM m_settings WHERE id=1
		");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($m1,$m2,$m3,$m4,$m5,$m6,$m7,$m8,$m9,$m10);
		$stmt->fetch();
		$stmt->close( );
		
		return array(
			'allow_registration' => $m1,
			'must_validate' => $m2,
			'notify_acc_deletion' => $m3,
			'notify_acc_undeletion' => $m4,
			'notify_acc_suspension' => $m5,
			'notify_acc_unsuspension' => $m6,
			'notify_acc_activation' => $m7,
			'notify_admin_newuser' => $m8,
			'max_albums' => $m9,
			'max_photos_in_album' => $m10
		);
		
	}
	
	public function get_site_feed_settings(){
		global $isv_db;
		
		$stmt = $isv_db->prepare("
			SELECT  
				number_feeds
			FROM f_settings WHERE id=1
		");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($f1);
		$stmt->fetch();
		$stmt->close( );
		
		return array(
			'number_feeds' => $f1
		);
		
	}
}

/*** load our global site variables */
$siteInfo = new siteManager();
$isv_siteDetails = $siteInfo->getSiteInfo();
$isv_siteSettings = $siteInfo->getSiteSettings();
$m_settings = $siteInfo->get_site_member_settings();
$f_settings = $siteInfo->get_site_feed_settings();

/*** check if SSL active and enable */
$enableSSL = $siteInfo->enableSSL();

