<?php
class feeds {
	private $feedText;
	private $feedImg;
	private $user_id;
	private $feedType;
	private $size;
	private $newName;
	
	public $feedArray;
	
	
	public function __construct($feed,$type){
		$this->feedArray = $feed;
		$this->feedType = $type;
		$this->size = '1000000';
		$maxSize = $this->size / 1000000;
		
		if ($this->feedType == 'text'){

			$this->feedText = $feed;
			
		} else if ($this->feedType == 'img'){
			$this->feedImg = $feed['image'];
			$this->feedText = $feed['text'];
			
			$this->newName = $_SESSION['isv_user_id'] . str_replace(' ', '', microtime());
			$this->newName = str_replace('.', '', $this->newName);
			$path = ISVIPI_UPLOADS_BASE .'feeds/';
			
			//check file size
			if ($this->feedImg["size"] > $this->size) {
				 $array['err'] = true;
				 $array['message'] = 'The file is too large. Maximum file size is '.$maxSize.' MB.';
				 echo json_encode($array);
				 exit();
			}
			
			//check file type
			if($this->feedImg["type"] != "image/jpg" && 
				$this->feedImg["type"] != "image/png" && 
				$this->feedImg["type"] != "image/jpeg" && 
				$this->feedImg["type"] != "image/gif" ) {
					$array['err'] = true;
				 	$array['message'] = 'Allowed file types are .jpg .jpeg .png .gif';
				 	echo json_encode($array);
				 	exit();
			}

			
			//require file upload class
			require_once(ISVIPI_CLASSES_BASE .'utilities/class.upload.php');
			
			$newUpload = new Upload($this->feedImg); 
			
			$newUpload->file_new_name_body = '600x600_'.$this->newName;
		    $newUpload->image_resize = true;
		    $newUpload->image_convert = 'jpg';
		    $newUpload->image_x = 600;
		    $newUpload->image_ratio_y = true;
		    $newUpload->Process($path);
			
			$newUpload->file_new_name_body = '150x150_'.$this->newName;
			$newUpload->image_resize = true;
		    $newUpload->image_convert = 'jpg';
		    $newUpload->image_x = 250;
		    $newUpload->image_ratio_y = true;
		    $newUpload->Process($path);
			
		    if (!$newUpload->processed) {
				 $array['err'] = true;
				 $array['message'] = 'An error occurred: '.$newUpload->error.'';
				 echo json_encode($array);
				 exit();
		    }
			$newUpload->Clean();
			
		}
		
		/** add our feed to the database **/
		$this->addFeed();
		
		/** return success **/
		$array['err'] = false;
		echo json_encode($array);
		exit();
	}
	
	private function addFeed(){
		global $isv_db;
		if (!isset($this->newName) || empty($this->newName)){
			$newName = '';
		} else {
			$newName = $this->newName.'.jpg';
		}
			$stmt = $isv_db->prepare("INSERT INTO feeds (user_id,text_feed,img_feed,time) VALUES (?,?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('iss',$_SESSION['isv_user_id'], $this->feedText,$newName);
			$stmt->execute();
			$stmt->close();
	}



}