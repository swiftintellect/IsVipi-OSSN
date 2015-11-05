<?php
class siteManager {
	public $s_url;
	public $s_title;
	public $s_email;
	public $s_lang;
	public $s_theme;
	public $s_time_zone;
	private $s_enable_ssl;
	public $s_lst_updt_check;
	public $s_status;
	
	public function __construct(){}
	
	public function getSiteInfo(){
		global $isv_db;
		$stmt = $isv_db->prepare("SELECT s_url,s_title,s_email,s_lang,s_theme,s_time_zone,s_enable_ssl,s_last_update_check,s_status FROM s_info WHERE id=1");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($s_url,$s_title,$s_email,$s_lang,$s_theme,$s_time_zone,$s_enable_ssl,$s_lst_updt_check,$s_status);
		$stmt->fetch();
		$stmt->close( );
		
		$this->s_url = $s_url;
		$this->s_title = $s_title;
		$this->s_email = $s_email;
		$this->s_lang = $s_lang;
		$this->s_theme = $s_theme;
		$this->s_time_zone = $s_time_zone;
		$this->s_enable_ssl = $s_enable_ssl;
		$this->s_lst_updt_check = $s_lst_updt_check;
		$this->s_status = $s_status;
		
		return array(
			's_url' => $this->s_url,
			's_title' => $this->s_title,
			's_email' => $this->s_email,
			's_lang' => $this->s_lang,
			's_theme' => $this->s_theme,
			's_time_zone' =>$this->s_time_zone,
			's_enable_ssl' =>$this->s_enable_ssl,
			's_lst_updt_check' => $this->s_lst_updt_check,
			's_status' => $this->s_status
		);
	}
	
		public function getSiteSettings(){
		global $isv_db;
		$stmt = $isv_db->prepare("SELECT user_reg,user_validate,sys_cron,timezone,admin_end,logo_name,favicon,mobile,plugins,errors,newuser_notice,last_upd_check,upd_avail FROM s_settings WHERE id=1");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($sett_userReg,$sett_userValid,$sett_sysCron,$sett_defTimeZone,$sett_adminEnd,$sett_logo,$sett_favicon,$sett_mobile,$sett_plugins,$sett_errors,$sett_newuserNotice,$last_upd_check,$upd_avail);
		$stmt->fetch();
		$stmt->close( );
		
		return array(
			'user_reg' => $sett_userReg,
			'user_validate' => $sett_userValid,
			'sys_cron' => $sett_sysCron,
			'defaultTzone' => $sett_defTimeZone,
			'adminEnd' => $sett_adminEnd,
			'logo' =>$sett_logo,
			'favicon' =>$sett_favicon,
			'enable_mobile' => $sett_mobile,
			'enable_plugins' => $sett_plugins,
			'hide_errors' => $sett_errors,
			'notifyAdmin_newUser' => $sett_newuserNotice,
			'last_upd_check' => $last_upd_check,
			'upd_avail' => $upd_avail
		);
	}

	public function maintenanceMode(){
		if ($this -> s_status === 0){
			require_once(ISVIPI_PAGES_BASE .'maintenance.php');
			exit();
		}
	}
	
	public function enableSSL(){
		if ($this -> s_enable_ssl === 1 && $_SERVER["HTTPS"] != "on"){
			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
			exit();
		}
	}
}

/*** load our global site variables */
$siteInfo = new siteManager();
$isv_siteDetails = $siteInfo->getSiteInfo();
$isv_siteSettings = $siteInfo->getSiteSettings();

/*** check if SSL active and enable */
$enableSSL = $siteInfo->enableSSL();

