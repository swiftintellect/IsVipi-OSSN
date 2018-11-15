<?php
	class banner {
		
		public function get_banner(){
			global $isv_db;
	
			$stmt = $isv_db->prepare("SELECT id,banner,link,ntab,uploadtime from isv_banners ORDER BY id DESC LIMIT 1");
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id,$banner,$link,$ntab,$uploadtime);
			$stmt->fetch();
			$stmt->close();	
			
			$res = array(
				'id' => $id,
				'banner' => $banner,
				'link' => $link,
				'ntab' => $ntab,
				'uploadtime' => $uploadtime
			);
			
			return $res;
		}
		
		public function banner_count(){
			global $isv_db;
			$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM isv_banners"); 
			$stmt->execute();  
			$stmt->bind_result($count); 
			$stmt->fetch();
			$stmt->close();
			
			return $count;
		}
		
		public function get_all_banners(){
			global $isv_db;
			
			$res = [];
			$stmt = $isv_db->prepare("SELECT id,banner,link,ntab,uploadtime from isv_banners ORDER BY id DESC");
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id,$banner,$link,$ntab,$uploadtime);
			while($stmt->fetch()){
				$res[] = array(
					'id' => $id,
					'banner' => $banner,
					'link' => $link,
					'ntab' => $ntab,
					'uploadtime' => $uploadtime
				);
			}
			$stmt->close();
			
			//print_r($res); exit();
			return $res;	
		}
	}