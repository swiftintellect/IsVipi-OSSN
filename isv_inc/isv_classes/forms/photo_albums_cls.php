<?php
	class photo_albums {
		
		public function new_album($photos,$alb_title){
			
			global $isv_db;
			$from_url = $_SERVER['HTTP_REFERER'];
			$output_dir = ISVIPI_UPLOADS_BASE."albums/";
			
			$fileCount = count($photos["name"]);
			
			if($fileCount > 5){
				$_SESSION['isv_error'] = 'You can upload a maximum of 5 pictures at a time.';
				header('location:'.$from_url.'');
				exit();
			}
			
			//check file type
			if($photos["type"][0] != "image/jpg" && 
				$photos["type"][0] != "image/png" && 
				$photos["type"][0] != "image/jpeg" && 
				$photos["type"][0] != "image/gif" ) {
					 $_SESSION['isv_error'] = 'Allowed file types are .jpg .jpeg .png .gif';
					 header('location:'.$from_url.'');
					 exit();
			}
				
			//create new album
			$stmt = $isv_db->prepare("INSERT INTO photo_albums (uid,album,timestamp) VALUES (?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('is',$_SESSION['isv_user_id'],$alb_title);
			$stmt->execute();
			$stmt->close();
			
			//retrieve id of the album
			$stmt = $isv_db->prepare("SELECT id from photo_albums WHERE uid=? ORDER BY id DESC LIMIT 1");
			$stmt->bind_param('i', $_SESSION['isv_user_id']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($album_id);
			$stmt->fetch();
			$stmt->close();
				
			$i = 0;
			while($i<$fileCount){
				$this->upload($photos['tmp_name'][$i],$album_id);
				$i++;
			}
			
			//return success
			$_SESSION['isv_success'] = 'New photo album created.';
			header('location:'.$from_url.'');
			exit();
			
		}//end of class function
		
		public function add_photos($photos,$album_id){
			
			global $isv_db;
			$from_url = $_SERVER['HTTP_REFERER'];
			$output_dir = ISVIPI_UPLOADS_BASE."albums/";
			
			//check if the album belongs to this user
			$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM photo_albums WHERE id = ? AND uid = ?"); 
			$stmt->bind_param('ii', $album_id,$_SESSION['isv_user_id']);
			$stmt->execute();  
			$stmt->bind_result($totalCount); 
			$stmt->fetch();
			$stmt->close();
			
			if ($totalCount < 1){
				$_SESSION['isv_error'] = 'No such album exists or you do not have permission to add photos in this album.';
			 	header('location:'.$from_url.'');
			 	exit();
			}
			
			$fileCount = count($photos["name"]);
			
			if($fileCount > 5){
				$_SESSION['isv_error'] = 'You can upload a maximum of 5 pictures at a time.';
				header('location:'.$from_url.'');
				exit();
			}
			
			//check file type
			if($photos["type"][0] != "image/jpg" && 
				$photos["type"][0] != "image/png" && 
				$photos["type"][0] != "image/jpeg" && 
				$photos["type"][0] != "image/gif" ) {
					 $_SESSION['isv_error'] = 'Allowed file types are .jpg .jpeg .png .gif';
					 header('location:'.$from_url.'');
					 exit();
			}
				
			$i = 0;
			while($i<$fileCount){
				$this->upload($photos['tmp_name'][$i],$album_id);
				$i++;
			}
			
			//return success
			$_SESSION['isv_success'] = 'New photos have been added to the album.';
			header('location:'.$from_url.'');
			exit();
			
		}//end of class function
		
		public function upload($photos,$al_id){
			global $isv_db;
			$from_url = $_SERVER['HTTP_REFERER'];
			
			$output_dir = ISVIPI_UPLOADS_BASE."albums/";
			//require file upload class
			require_once(ISVIPI_CLASSES_BASE .'utilities/class.upload.php');
			
				$temp = $photos;
				$n_name = $_SESSION['isv_user_id'] . str_replace(' ', '', microtime());
				$n_name = str_replace('.', '', $n_name);
				
				$newUpload = new Upload($temp); 
			
				$newUpload->file_new_name_body = ISVIPI_600.$n_name;
				$newUpload->image_resize = true;
				$newUpload->image_convert = 'jpg';
				$newUpload->image_x = 600;
				$newUpload->image_ratio_y = true;
				$newUpload->Process($output_dir);
				
				if (!$newUpload->processed) {
					 $_SESSION['isv_error'] = 'An error occurred: '.$newUpload->error.'';
					 header('location:'.$from_url.'');
					 exit();
				}
				
				$newUpload->Clean();
				
				//save photos
				$status = 1;
				$dbn_name = $n_name.".jpg";
				$stmt = $isv_db->prepare("INSERT INTO photos (album_id,photo,status,upload_date) VALUES (?,?,?,UTC_TIMESTAMP())");
				$stmt->bind_param('iss',$al_id,$dbn_name,$status);
				$stmt->execute();
				$stmt->close();
				
		}
		
	}//end of class
	
	class album_actions {
		
		public function del_album($alb_id){
			global $isv_db;
			$from_url = $_SERVER['HTTP_REFERER'];
			$output_dir = ISVIPI_UPLOADS_BASE."albums/";
			
			//check if the album belongs to this user
			$stmt = $isv_db->prepare("SELECT album from photo_albums WHERE uid=? AND id=?");
			$stmt->bind_param('ii', $_SESSION['isv_user_id'],$alb_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($album_id);
			$count = $stmt->num_rows();
			$stmt->fetch();
			$stmt->close();
			
			if ($count < 1){
				$_SESSION['isv_error'] = 'No such album exists or you do not have permission to delete it.';
			 	header('location:'.$from_url.'');
			 	exit();
			}
			
			//get all photos under this album
			$stmt = $isv_db->prepare("SELECT photo from photos WHERE album_id=?");
			$stmt->bind_param('i', $alb_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($photo);
			$count = $stmt->num_rows();
				if($count > 0){
					while($stmt->fetch()){
						//unlink file in the directory
						if(file_exists($output_dir.ISVIPI_600.$photo)){
							unlink($output_dir.ISVIPI_600.$photo);
						}
						
					}
				}
			$stmt->close();

			//delete photos for this album
			$stmt = $isv_db->prepare("DELETE from photos WHERE album_id=?");
			$stmt->bind_param('i', $alb_id);
			$stmt->execute();
									
			//delete album
			$stmt = $isv_db->prepare("DELETE from photo_albums WHERE id=?");
			$stmt->bind_param('i', $alb_id);
			$stmt->execute();
			$stmt->close();
			
			//return success
			$_SESSION['isv_success'] = 'Album deleted.';
			header('location:'.$from_url.'');
			exit();			
		}
		
		public function del_photo($photo_id){
			global $isv_db;
			$from_url = $_SERVER['HTTP_REFERER'];
			$output_dir = ISVIPI_UPLOADS_BASE."albums/";
			
			//retrieve photo
			$stmt = $isv_db->prepare("SELECT photo from photos WHERE id=?");
			$stmt->bind_param('i', $photo_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($photo);
			$count = $stmt->num_rows();
			$stmt->fetch();
			$stmt->close();
			
			if($count > 0){
				//unlink
				if(file_exists($output_dir.ISVIPI_600.$photo)){
					unlink($output_dir.ISVIPI_600.$photo);
				}
				
				$stmt = $isv_db->prepare("DELETE from photos WHERE id=?");
				$stmt->bind_param('i', $photo_id);
				$stmt->execute();
				$stmt->close();
				
				//return success
				$_SESSION['isv_success'] = 'Photo deleted.';
				header('location:'.$from_url.'');
				exit();
				
			} else {
				$_SESSION['isv_error'] = 'Photo was not deleted. Please try again.';
			 	header('location:'.$from_url.'');
			 	exit();
			}
			
		}
		
		
		
	}