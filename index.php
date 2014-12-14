<?php
ob_start();
session_set_cookie_params(0);
session_start();
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.org

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 ******************************************************/ 
if (!file_exists('inc/db/db.php')){
		include_once ('inc/install/prompt.php');
		exit;
	} 
		else 
	{
		//require_once important files
		require_once 'inc/db/db.php';
		require_once 'init.php';
		require_once ISVIPI_USER_INC_BASE. 'users.func.php';
		require_once ISVIPI_USER_INC_BASE. 'mods/mods.php';
		require_once 'inc/users.inc/mobile/mobile.php';
		
		/*
		let us get the user's country and timezone from his/her ip
		But we first need to check if there is a cookie set that indicates the session variables exist
		this is because we don't want our system to keep on checking for user country and timezone
		each time our user clicks on a page. It could cause massive performance issues
		*/
		$VisitorIP = get_client_ip();
		if (isset($_COOKIE['IsVipiCookie'])){
			$cookieVar = explode("/", $_COOKIE['IsVipiCookie']);
			$countryCode = $cookieVar[0];
			$countryName = $cookieVar[1];
		} else {
			//if these session variables are not present then we generate them
			require_once 'inc/users.inc/classes/geoip/geoip.php';
			$gi = geoip_open("inc/users.inc/classes/geoip/GeoIP.dat", GEOIP_STANDARD);
			$countryCode = geoip_country_code_by_addr($gi, $VisitorIP);
			$countryName = geoip_country_name_by_addr($gi, $VisitorIP);
				$cookieVar = $countryCode."/".$countryName;
				//then we set a cookie that tell's us if it is the same user
				//the cookie is valid for 30 days only
				$number_of_days = 30 ;
				$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
				setcookie( "IsVipiCookie", $cookieVar, $date_of_expiry );
			//we close our class
			geoip_close($gi);
		}
			require_once 'inc/users.inc/classes/geoip/timezone.php';
			$IPtimezone = @get_time_zone($countryCode,"");
		//We then call important functions
		getModUrls();
		getAdminGenSett();
		//We check to see if php errors are to be hidden
		//This is useful when you do not want your site users to see php errors from their end
		//Should be disabled in case you are troubleshooting
			if ($phpErrHide == 1){
				error_reporting(0);
				ini_set('display_errors', 0);
			}
		//We include our language file
		require_once "lang/".$lang.".php";
		//We check if the mobile version is enabled
		if ($mobileEnabled == "1"){
			isMobile();
		}
	//Define some important constants
	define('ISVIPI_THEMES_BASE', ISVIPI_ROOT . 'themes/'.$theme.'' . DIRECTORY_SEPARATOR);
	define ('ISVIPI_THEME_URL', ISVIPI_URL. 'themes/'.$theme.''.DIRECTORY_SEPARATOR);
	define('VERSION', '1.3.0');
	define('MODS', $addonEnabled);
	define('ALBUM', 'no');
	define('CHAT_ENB', 'no');
		//We then set our timezones
			if ($timeZ=="1"){
				$zone = ini_get('date.timezone');	
			} else if (isset($IPtimezone) && (filter_var($IPtimezone, FILTER_VALIDATE_IP))){ 
					$zone = $IPtimezone;
			} else {
				$zone = $time_zone;	
			}
		date_default_timezone_set ($zone);
		//This is where the mod_rewrite magic happens
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
		) die404();
		$ACTION = (
			($URL == '') ||
			($URL == 'index.php') ||
			($URL == 'index.html')
		) ? array('index') : explode('/',html_entity_decode($URL));
		$includeFile = ''.ISVIPI_USER_BASE.''.preg_replace('/[^\w]/','',$ACTION[0]).'.php';
//We set our site url parameters
if ($ACTION[0] == 'cron'){
			include_once ''.ISVIPI_CRON_BASE.'/'.preg_replace('/[^\w]/','',$ACTION[0]).'.php';
		}
else if ($ACTION[0] == 'auth'){
			include_once 'auth/'.preg_replace('/[^\w]/','',$ACTION[1]).'.php';
		}
else if ($ACTION[0] == 'sitemap'){
			include_once preg_replace('/[^\w]/','',$ACTION[0]).'.xml';
		}
else if ($ACTION[0] == 'users'){
			require_once ''.ISVIPI_USER_INC_BASE.''.preg_replace('/[^\w]/','',$ACTION[1]).'.php';
		}
else if ($ACTION[0] == $adminPath){
			if (!isset($ACTION[1])){$ACTION[1] = '/login';}
			require_once 'admincp/'.preg_replace('/[^\w]/','',$ACTION[1]).'.php';
		}
else if ($ACTION[0] == 'conf'){
			require_once ''.ISVIPI_ADMIN_INC_BASE.''.preg_replace('/[^\w]/','',$ACTION[1]).'.php';
		}
else if ($ACTION[0] == 'feed'){
			require_once 'inc/feeds/'.preg_replace('/[^\w]/','',$ACTION[0]).'.php';
		}	
else if ($ACTION[0] == 'admAddons'){
			require_once ISVIPI_ADMIN_INC_BASE.'addons/'.preg_replace('/[^\w]/','',$ACTION[1]).'.php';
		}	
else if ($ACTION[0] == 'chat'){
			require_once 'inc/mods/chat/'.preg_replace('/[^\w]/','',$ACTION[0]).'.php';
		}	
else if ($ACTION[0] == 'remote'){
			require_once ISVIPI_THEMES_BASE.'remote/'.preg_replace('/[^\w]/','',$ACTION[1]).'.php';
		}
else if ($ACTION[0] == "settings" && $ACTION[1] == "addon"){
			require_once ISVIPI_INC_MODS.$ACTION[2].'/admin/'.rtrim($ACTION[3], '/').'.php';
		}
else if (is_file($includeFile)) {
		include($includeFile);
} 
else if (MODS == "1" && $modeCount>0){
			while ($getModUrl->fetch()){
				if ($ACTION[0] == $modName){
					require_once ISVIPI_INC_MODS.$modName.'/'.rtrim($ACTION[1], '/').'.php';
					exit();
				} 
			}
			die404();
}
else die404();
}
ob_end_flush();
?>