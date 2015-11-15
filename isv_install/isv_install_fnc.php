<?php
	function php_version($ver){
		if (phpversion() >= $ver){
			return "<i class='fa fa-check passed'></i>";
		 } else {
			 global $error;
			 $error = true;
			 return "<i class='fa fa-times failed'></i>";
		 }
	}
	
	function curl_exists(){
		if (function_exists('curl_init')){ 
		 	return "<i class='fa fa-check passed'></i>";
		 } else {
			global $error;
			$error = true;
			return "<i class='fa fa-times failed'></i>";
		}

	}
	
	function gd_lib_exists(){
		if (function_exists('imagecreatefromstring')){
			return "<i class='fa fa-check passed'></i>";
		} else {
			global $error;
			$error = true;
			return "<i class='fa fa-times failed'></i>";
		}
	}
	
	function mysql_version($ver){
		ob_start(); 
		phpinfo(INFO_MODULES); 
		$info = ob_get_contents(); 
		ob_end_clean(); 
		$info = stristr($info, 'Client API version'); 
		preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match); 
		$gd = $match[0]; 
		
			if ($gd >= $ver){
				return "<i class='fa fa-check passed'></i>";
			} else {
				global $error;
			    $error = true;
				return "<i class='fa fa-times failed'></i>";
			}
		
	}
	
	function mode_rewrite_installed(){
		if (function_exists('apache_get_modules')) {
			if(in_array('mod_rewrite', apache_get_modules())){
				return "<i class='fa fa-check passed'></i>";
			} else {
				global $error;
				$error = true;
				return "<i class='fa fa-times failed'></i>";
			}
		} else {
			global $error;
			$error = true;
			return "<i class='fa fa-times failed'></i>";
		}
	}
	
	function load_timezones(){
		$regions = array(
			'Africa' => DateTimeZone::AFRICA,
			'America' => DateTimeZone::AMERICA,
			'Antarctica' => DateTimeZone::ANTARCTICA,
			'Aisa' => DateTimeZone::ASIA,
			'Atlantic' => DateTimeZone::ATLANTIC,
			'Europe' => DateTimeZone::EUROPE,
			'Indian' => DateTimeZone::INDIAN,
			'Pacific' => DateTimeZone::PACIFIC
		);
		
		$timezones = array();
		foreach ($regions as $name => $mask){
			$zones = DateTimeZone::listIdentifiers($mask);
			foreach($zones as $timezone){
				// Lets sample the time there right now
				$time = new DateTime(NULL, new DateTimeZone($timezone));
				// Us dumb Americans can't handle millitary time
				$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
				// Remove region name and add a sample time
				$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
			}
		}
		foreach($timezones as $region => $list){
			print '<optgroup label="' . $region . '">' . "\n";
				foreach($list as $timezone => $name){
					print '<option value="' . $timezone . '">' . $name . '</option>' . "\n";
				}
				print '<optgroup>' . "\n";
			}

				
	}