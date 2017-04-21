<?php
	function install_folder_exists(){
		if(file_exists(ISVIPI_ROOT. 'isv_install')){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function upgrade_file_exists(){
		if(file_exists(ISVIPI_ROOT. 'update')){
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
	
	function switch_system_status($value){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("UPDATE s_info SET s_status = ? WHERE id=1"); 
		$stmt->bind_param('i', $value);
		$stmt->execute();  
		$stmt->close();
		
	}