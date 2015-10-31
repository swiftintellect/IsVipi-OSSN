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
			return "<span class='label label-default'>Inactive</span>";
		} else if($status === 1){
			return "<span class='label label-success'>Active</span>";
		} else if($status === 2){
			return "<span class='label label-warning'>Suspended</span>";
		} else if($status === 9){
			return "<span class='label label-danger'>Sch. Deletion</span>";
		} else {
			return "<span class='label label-primary'>Unknown</span>";
		}
	}