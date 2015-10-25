<?php
class pageManager {
	public function __construct(){
		$this->trackSession(); 
	}
	
	/*** if your guest and logged in head page is the same, call loadHead() function */ 
	public function loadHead(){
		global $p,$s_m,$isv_siteSettings,$converter;
		require_once(ISVIPI_ACT_THEME . 'ovr/head.php');
	}
	
	/*** if your guest and logged in head pages are different, call loadCustomHead($guest,$logged) function.
	Please note that you will have to supply two variables indicating the names of these pages, 
	guest and logged in that order. For example  loadCustomHead('myhead', 'memberhead')*/ 
	public function loadCustomHead($guest,$logged){
		global $p,$s_m,$isv_siteSettings,$isv_siteDetails,$converter;
		if (!isLoggedIn()){
			require_once(ISVIPI_ACT_THEME . 'ovr/'.$guest.'.php');
		} else {
			require_once(ISVIPI_ACT_THEME . 'ovr/'.$logged.'.php');
		}
	}
	
	/*** if your guest and logged in header page is the same, call loadHeader() function */ 
	public function loadHeader(){
		global $p,$s_m,$isv_siteSettings,$isv_siteDetails,$memberinfo,$converter,$PAGE;
		require_once(ISVIPI_ACT_THEME . 'ovr/header.php');
	}
	
	/*** if your guest and logged in header pages are different, call loadCustomHeader($guest,$logged) function.
	Please note that you will have to supply two variables indicating the names of these pages, 
	guest and logged in that order. For example  loadCustomHeader('g_header', 'm_header')*/ 
	public function loadCustomHeader($guest,$logged){
		global $p,$s_m,$isv_siteSettings,$isv_siteDetails,$memberinfo,$converter,$PAGE;
		if (!isLoggedIn()){
			require_once(ISVIPI_ACT_THEME . 'ovr/'.$guest.'.php');
		} else {
			require_once(ISVIPI_ACT_THEME . 'ovr/'.$logged.'.php');
		}
	}
	
	/*** if your guest and logged in header page is the same, call loadHeader() function */ 
	public function loadsideBar($sidebar){
		global $p,$s_m,$isv_siteSettings,$isv_siteDetails,$memberinfo,$PAGE,$converter;
		require_once(ISVIPI_ACT_THEME . 'ovr/'.$sidebar.'.php');
	}
	
	/*** if your guest and logged in footer page is the same, call loadFooter() function */ 
	public function loadFooter(){
		global $p,$s_m,$isv_siteSettings,$isv_siteDetails,$converter;
		require_once(ISVIPI_ACT_THEME . 'ovr/footer.php');
	}
	
	/*** if your guest and logged in footer pages are different, call loadCustomFooter($guest,$logged) function.
	Please note that you will have to supply two variables indicating the names of these pages, 
	guest and logged in that order. For example  loadCustomFooter('isv_footer', 'isvipi_footer')*/ 
	public function loadCustomFooter($guest,$logged){
		global $p,$s_m,$isv_siteSettings,$isv_siteDetails,$converter;
		if (!isLoggedIn()){
			require_once(ISVIPI_ACT_THEME . 'ovr/'.$guest.'.php');
		} else {
			require_once(ISVIPI_ACT_THEME . 'ovr/'.$logged.'.php');
		}
	}
	
	public function siteTitle($p){
		$siteInfo = new siteManager();
		$isv_siteDetails = $siteInfo->getSiteInfo();
		if (empty($p) || $p === 'home'){
			return $isv_siteDetails['s_title'];
		} else if ($p === 'index'){
			return $isv_siteDetails['s_title'] .' - Welcome ';
		} else if (isset($p) && file_exists(ISVIPI_PAGES_BASE .$p.'.php')){
			$p = str_replace("_", " ", $p);
			$p = ucwords($p);
			return $p .' - '. $isv_siteDetails['s_title'];
		} else { 
			return '404 Error - '. $isv_siteDetails['s_title'];
		}
	}
	
	public function adminTitle($p){
		$siteInfo = new siteManager();
		$isv_siteDetails = $siteInfo->getSiteInfo();
		if ($p === 'login'){
			return 'Login - '.$isv_siteDetails['s_title']. ' Admin';
		} else if (isset($p) && file_exists(ISVIPI_ADMIN_BASE .$p.'.php')){
			$p = str_replace("_", " ", $p);
			$p = ucwords($p);
			return $p .' - '.$isv_siteDetails['s_title']. ' Admin';
		} else { 
			return '404 Error - '. $isv_siteDetails['s_title'];
		}
	}
	
	public function footerText(){
		$siteInfo = new siteManager();
		$isv_siteDetails = $siteInfo->getSiteInfo();
		echo 'Copyright &copy; '.date('Y').' <a href="'.$isv_siteDetails['s_url'].'" title="'.$isv_siteDetails['s_title'].'">'.$isv_siteDetails['s_title'].'</a>. Powered by <a href="//isvipi.org" title="Open Source Social Networking Software" target="_blank">IsVipi OSSN</a>.';
	}
	
	public function trackSession(){
		global $isv_db,$sessFound;
		$sess_id = session_id();
		if (!isLoggedIn() /*if the user is not logged in */){
			//check if the session is in our db and add if not found
			checkUserSession($sess_id);
			if ($sessFound > 0){
				//we update last activity
				$stmt = $isv_db->prepare("UPDATE sessions SET last_activity=UTC_TIMESTAMP() where sess_id=?");
				$stmt->bind_param('s',$sess_id);
				$stmt->execute();
				$stmt->close();
			} else {
				//add session
				$stmt = $isv_db->prepare("INSERT INTO sessions (sess_id,last_activity) VALUES (?,UTC_TIMESTAMP())");
				$stmt->bind_param('s',$sess_id);
				$stmt->execute();
				$stmt->close();
			}
			
		} else /*if the user is logged in*/{
			$stmt = $isv_db->prepare("UPDATE users SET last_activity=UTC_TIMESTAMP() where id=?");
			$stmt->bind_param('s',$_SESSION['isv_user_id']);
			$stmt->execute();
			$stmt->close();
			
			checkUserSession($sess_id);
			if ($sessFound > 0){
				//we update last activity
				$stmt = $isv_db->prepare("UPDATE sessions SET user_id=?,last_activity=UTC_TIMESTAMP() where sess_id=?");
				$stmt->bind_param('is',$_SESSION['isv_user_id'],$sess_id);
				$stmt->execute();
				$stmt->close();
			} else {
				//add session
				$stmt = $isv_db->prepare("INSERT INTO sessions (sess_id,user_id,last_activity) VALUES (?,?,UTC_TIMESTAMP())");
				$stmt->bind_param('si',$sess_id,$_SESSION['isv_user_id']);
				$stmt->execute();
				$stmt->close();
			}
		}
	}
	
	public function siteMeta(){
		global $isv_db;
		$id = 1;
		$stmt = $isv_db->prepare("SELECT tags,description FROM s_meta WHERE id=1");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($meta_tags,$meta_descr);
		$stmt->fetch();
		$stmt->close( );
		
		return array(
			'meta_tags' => $meta_tags,
			'meta_descr' => $meta_descr,
		);
	}
}

/* -------------------------------------  */
