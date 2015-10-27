<?php
	function install_folder_exists(){
		if(file_exists(ISVIPI_ROOT. 'isv_install')){
			return TRUE;
		} else {
			return FALSE;
		}
	}