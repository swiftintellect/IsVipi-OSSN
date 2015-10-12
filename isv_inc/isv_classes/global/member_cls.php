<?php
class member {
	public $user_id;
	
	private $newName;
	private $path;
	private $feedImg;
	private $size;
	
	public function __construct($user){
		$this->user_id = $user;
	}
	
	public function memberDetails(){
		global $isv_db;
		
		$stmt = $isv_db->prepare("SELECT
		  	u.username,
			u.email,
			u.status,
			u.level,
			u.reg_date,
			u.last_activity,
		  	p.fullname,
			p.gender,
			p.dob,
			p.country,
			p.city,
			p.phone,
			p.profile_pic,
			p.cover_photo,
			p.hobbies,
			p.relshp_status
			FROM users AS u
			INNER JOIN user_profile AS p ON u.id = p.user_id WHERE u.id=?;");
		$stmt->bind_param('i', $this->user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($username,$email,$userStatus,$level,$regDate,$lastActvty,$fullName,$gender,$dob,$country,$city,$phone,$profilePic,$coverPhoto,$hobbies,$relshpStatus);
		$stmt->fetch();
		$stmt->close();
			return array(
				'username' => $username,
				'email' => $email,
				'status' => $userStatus,
				'level' => $level,
				'reg_date' => $regDate,
				'last_activity' => $lastActvty,
				'full_name' => $fullName,
				'gender' => $gender,
				'dob' => $dob,
				'country' => $country,
				'city' => $city,
				'phone' => $phone,
				'profile_pic' => $profilePic,
				'cover_photo' => $coverPhoto,
				'hobbies' => $hobbies,
				'rel_status' => $relshpStatus
			);
	}
	
	public function profile_pic($pic){
		global $isv_db;
		
		$from_url = $_SERVER['HTTP_REFERER'];
		
		$this->feedImg = $pic;
		$this->size = '1000000';
		$maxSize = $this->size / 1000000;
		
		$this->newName = $_SESSION['isv_user_id'] . str_replace(' ', '', microtime());
		$this->newName = str_replace('.', '', $this->newName);
		$this->path = ISVIPI_UPLOADS_BASE .'ppics/';
		
		//check file size
		if ($this->feedImg["size"] > $this->size) {
			 $_SESSION['isv_error'] = 'The file is too large. Maximum file size is '.$maxSize.' MB.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//check file type
		if($this->feedImg["type"] != "image/jpg" && 
			$this->feedImg["type"] != "image/png" && 
			$this->feedImg["type"] != "image/jpeg" && 
			$this->feedImg["type"] != "image/gif" ) {
				 $_SESSION['isv_error'] = 'Allowed file types are .jpg .jpeg .png .gif';
				 header('location:'.$from_url.'');
				 exit();
		}
		
			//require file upload class
			require_once(ISVIPI_CLASSES_BASE .'utilities/class.upload.php');
		
			$newUpload = new Upload($this->feedImg); 
			
			$newUpload->file_new_name_body = ISVIPI_THUMBS.$this->newName;
		    $newUpload->image_resize = true;
		    $newUpload->image_convert = 'jpg';
		    $newUpload->image_x = 150;
		    $newUpload->image_ratio_y = true;
		    $newUpload->Process($this->path);
			
		    if (!$newUpload->processed) {
				 $_SESSION['isv_error'] = 'An error occurred: '.$newUpload->error.'';
				 header('location:'.$from_url.'');
				 exit();
		    }
			$newUpload->Clean();
		
		//update our db
		$newN = $this->newName .'.jpg';
		$stmt = $isv_db->prepare("UPDATE user_profile SET profile_pic=? WHERE user_id=?");
		$stmt->bind_param('si',$newN,$this->user_id);
		$stmt->execute();
		$stmt->close();	
		
		//return success
		$_SESSION['isv_success'] = 'Profile picture uploaded.';
		header('location:'.$from_url.'');
		exit();
		
	}
	
	public function cover_photo($pic){
		global $isv_db;
		
		$from_url = $_SERVER['HTTP_REFERER'];
		
		$this->feedImg = $pic;
		$this->size = '1000000';
		$maxSize = $this->size / 1000000;
		
		$this->newName = $_SESSION['isv_user_id'] . str_replace(' ', '', microtime()) . 'cover';
		$this->newName = str_replace('.', '', $this->newName);
		$this->path = ISVIPI_UPLOADS_BASE .'cover/';
		
		//check file size
		if ($this->feedImg["size"] > $this->size) {
			 $_SESSION['isv_error'] = 'The file is too large. Maximum file size is '.$maxSize.' MB.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		//check file type
		if($this->feedImg["type"] != "image/jpg" && 
			$this->feedImg["type"] != "image/png" && 
			$this->feedImg["type"] != "image/jpeg" && 
			$this->feedImg["type"] != "image/gif" ) {
				 $_SESSION['isv_error'] = 'Allowed file types are .jpg .jpeg .png .gif';
				 header('location:'.$from_url.'');
				 exit();
		}
		
		//check image dimension
		$image_info = getimagesize($this->feedImg["tmp_name"]);
		if ($image_info[0] < 800 || $image_info[1] < 250){
			$_SESSION['isv_error'] = 'Image dimension MUST be a minimum of 800px by 250px';
			header('location:'.$from_url.'');
			exit();
		}
		
			//require file upload class
			require_once(ISVIPI_CLASSES_BASE .'utilities/class.upload.php');
		
			$newUpload = new Upload($this->feedImg); 
			
			$newUpload->file_new_name_body = $this->newName;
		    $newUpload->image_resize = true;
		    $newUpload->image_convert = 'jpg';
		    $newUpload->image_x = 800;
		    $newUpload->image_ratio_y = true;
		    $newUpload->Process($this->path);
			
		    if (!$newUpload->processed) {
				 $_SESSION['isv_error'] = 'An error occurred: '.$newUpload->error.'';
				 header('location:'.$from_url.'');
				 exit();
		    }
			$newUpload->Clean();
		
		//update our db
		$newN = $this->newName .'.jpg';
		$stmt = $isv_db->prepare("UPDATE user_profile SET cover_photo=? WHERE user_id=?");
		$stmt->bind_param('si',$newN,$this->user_id);
		$stmt->execute();
		$stmt->close();	
		
		//return success
		$_SESSION['isv_success'] = 'Cover photo uploaded.';
		header('location:'.$from_url.'');
		exit();
		
	}
	
}