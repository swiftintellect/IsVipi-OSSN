<?php
	class get_photo_albums {
		
		public function __construct(){}
		
		public function album_count($user){
			global $isv_db;
			
			$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM photo_albums WHERE uid=?"); 
			$stmt->bind_param('i', $user);
			$stmt->execute();  
			$stmt->bind_result($totalCount); 
			$stmt->fetch();
			$stmt->close();
			
			return $totalCount;
		}
		
		public function get_user_albums($user){
			global $isv_db;
			
			$stmt = $isv_db->prepare("SELECT
				id,
				album,
				timestamp
				FROM photo_albums
				WHERE uid=?
			");
			$stmt->bind_param('i', $user);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($album_id,$album_name,$album_date);
			$res = array();
				if($stmt->num_rows() > 0){
					while($stmt->fetch()){
						$res[] = array(
							'album_id' => $album_id,
							'album' => $album_name,
							'album_date' => $album_date,
						);
					}
				}
			//print_r($res); exit();
			
			return $res;
			
		}
		
		public function album_exists_n_allowed($album_id,$user){
			global $isv_db;
			
			$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM photo_albums WHERE id=? AND uid=?"); 
			$stmt->bind_param('ii', $album_id,$user);
			$stmt->execute();  
			$stmt->bind_result($totalCount); 
			$stmt->fetch();
			$stmt->close();
			
			if($totalCount > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		}
		
		
		public function album_photo_count($album_id){
			global $isv_db;
			
			$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM photos WHERE album_id=?"); 
			$stmt->bind_param('i', $album_id);
			$stmt->execute();  
			$stmt->bind_result($totalCount); 
			$stmt->fetch();
			$stmt->close();
			
			return $totalCount;
			
		}
		
		public function all_photos($alb_id){
			global $isv_db;
			
			$stmt = $isv_db->prepare("SELECT
				p.album,
				a.id,
				a.photo
				FROM photo_albums AS p
				LEFT JOIN photos AS a ON a.album_id = p.id 
				WHERE a.album_id=?
			");
			$stmt->bind_param('i', $alb_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($album,$photo_id,$photo);
			$res = array();
				if($stmt->num_rows() > 0){
					while($stmt->fetch()){
						$res[] = array(
							'photo_id' => $photo_id,
							'photo' => $photo,
							'album' => $album
						);
					}
				}
			//print_r($res); exit();
			
			return $res;
			
		}
	}