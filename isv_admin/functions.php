<?php
	function install_folder_exists(){
		if(file_exists(ISVIPI_ROOT. 'isv_install')){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function user_status($status){
		if ($status === 0){
			return "Inactive";
		} else if($status === 1){
			return "Active";
		} else if($status === 2){
			return "Suspended";
		} else if($status === 9){
			return "Sch. Deletion";
		} else {
			return "Unknown";
		}
	}