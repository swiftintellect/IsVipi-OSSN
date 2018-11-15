<?php
	class plugins {
		public function install(){
			
		}
		
		public function uninstall(){
			
		}
		
		public function load_all_plugins($status){
			global $isv_db;
			
			if($status == "all"){
				$q = "";
			} else {
				$q = " WHERE status = ".$status."";
			}

			$stmt = $isv_db->prepare("SELECT * FROM isv_plugins ".$q."");
			$stmt->execute();
			$stmt->store_result();
			
			$a = array();
				while($result = fetchAssocStatement($stmt)){
					$a[]  = $result;
			}
			
			return $a;
		}
		
		public function load_active_plugins($page = ""){
			global $isv_db;
			
			$stmt = $isv_db->prepare("SELECT pluginname, displayname FROM isv_plugins WHERE status = 1");
			$stmt->execute();
			$stmt->store_result();
			
			$a = array();
				while($result = fetchAssocStatement($stmt)){
					$a[]  = $result;
			}
			
			if(is_array(array_filter($a))){
				foreach($a as $key => $ap){
					
					//set plugin icons
					if($ap['pluginname'] == "groups"){
						$icon = "<i class='fa fa-users'></i>";
					} else if($ap['pluginname'] == "pages"){
						$icon = "<i class='fa fa-bookmark-o'></i>";
					} else {
						$icon = "";
					}
					
					echo "<li ".(($ap['pluginname'] == $page) ? "class='active'" : "")."><a href='".ISVIPI_URL.$ap['pluginname']."'>".$icon." ".$ap['displayname']."</a></li>";
				}
			}
		}
		
		public function load_plugin_styles($page) {
			global $isv_db;
			
			$stmt = $isv_db->prepare("SELECT * FROM isv_plugins");
			$stmt->execute();
			$stmt->store_result();
			//$result = $stmt->get_result();
			$a = array();
				while($result = fetchAssocStatement($stmt)){
					$a[]  = $result;
				}
			
			//check for plugins which require their stylesheets loaded
			foreach($a as $key => $styles){

				if(!empty($styles['styles'])){
					$set = array_filter(explode(',',$styles['styles']));
					if(is_array($set) && in_array($page, $set)){
						echo '<link href="'.ISVIPI_PLUGINS_URL.$styles['pluginname'].'/style/'.$styles['pluginname'].'.css" rel="stylesheet">';
					}
				}
			}
		}
		
		public function load_plugin_js($page) {
			global $isv_db;
			
			$stmt = $isv_db->prepare("SELECT * FROM isv_plugins");
			$stmt->execute();
			$stmt->store_result();
			//$result = $stmt->get_result();
			$a = array();
				while($result = fetchAssocStatement($stmt)){
					$a[]  = $result;
				}
			
			//check for plugins which require their stylesheets loaded
			foreach($a as $key => $styles){
				
				if(!empty($styles['styles'])){
					$set = array_filter(explode(',',$styles['styles']));
					if(is_array($set) && in_array($page, $set)){
						echo '<script src="'.ISVIPI_PLUGINS_URL.$styles['pluginname'].'/style/'.$styles['pluginname'].'.js"></script>';
					}
				}
			}
		}
	}