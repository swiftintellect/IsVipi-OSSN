<?php
	class staticpage {
		public function get_static_page($staticp){
			global $isv_db;
			
			//activate user
			$content = '';
			$stmt = $isv_db->prepare("SELECT ".$staticp." FROM isv_static_pages WHERE id=1");
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($content);
			$stmt->fetch();
			$stmt->close();
			
			return $content;
		}
		
	}