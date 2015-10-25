<?php
class member {
	public $user_id;
	
	//edit profile fields
	private $f_name;
	private $gender;
	private $dob;
	private $phone;
	private $country;
	private $city;
	private $relationship;
	private $hobbies;
	
	//change password
	private $pwd;
	private $new_pwd;
	
	//update privacy
	private $feed_settings;
	private $phone_settings;
	
	//image upload (both profile pic anc cover photo)
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
			p.relshp_status,
			st.feeds,
			st.phone
			FROM users AS u
			LEFT JOIN user_profile AS p ON u.id = p.user_id 
			LEFT JOIN user_settings AS st ON p.user_id = st.user_id 
			WHERE u.id=?;");
		$stmt->bind_param('i', $this->user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($username,$email,$userStatus,$level,$regDate,$lastActvty,$fullName,$gender,$dob,$country,$city,$phone,$profilePic,$coverPhoto,$hobbies,$relshpStatus,$feedSettings,$phoneSettings);
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
				'rel_status' => $relshpStatus,
				'm_feed_settings' => $feedSettings,
				'm_phone_settings' => $phoneSettings
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
	
	public function edit_profile($userFields){
		
		$from_url = $_SERVER['HTTP_REFERER'];
		
		//check if our array is set
		if(!is_array($userFields)){
			$_SESSION['isv_error'] = 'Something went wrong. Please try again.';
			header('location:'.$from_url.'');
			exit();
		}
		
		//assign our variables
		$this->f_name = $userFields['Full Name'];
		$this->gender = $userFields['Gender'];
		$this->dob = $userFields['Date of Birth'];
		$this->phone = $userFields['Phone'];
		$this->country = $userFields['Country'];
		$this->city = $userFields['City'];
		$this->relationship = $userFields['Relationship'];
		$this->hobbies = $userFields['Hobbies'];
		
		$format = "d/m/Y";
		$this->dob = $this->validateDate($this->dob, $format);
		
		//check if the date of birth meets minimum reg requirements
		$min_age = 12;
		
		if(!validate_age($this->dob,$min_age)){
			$_SESSION['isv_error'] = "Minimum age limit is $min_age years.";
			header('location:'.$from_url.'');
			exit();
		}
		
		//update our database
		global $isv_db;
		
		$stmt = $isv_db->prepare("UPDATE user_profile SET 
			fullname=?,
			gender =?,
			dob=?,
			country=?,
			city=?,
			phone=?,
			hobbies=?,
			relshp_status=?
		
		WHERE user_id=?");
		$stmt->bind_param('ssssssssi',
			$this->f_name,
			$this->gender,
			$this->dob,
			$this->country,
			$this->city,
			$this->phone,
			$this->hobbies,
			$this->relationship,
			$this->user_id
		);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Profile updated!';
		header('location:'.$from_url.'');
		exit();
	}
	
	public function change_pwd($pwd){
		
		$from_url = $_SERVER['HTTP_REFERER'];
		
		$this->pwd = $pwd['Current Password'];
		$this->new_pwd = $pwd['New Password'];
		
		//check if the current password matches the one in our db
		global $isv_db;
		
		$stmt = $isv_db->prepare("SELECT pwd FROM users WHERE id=?");
		$stmt->bind_param('i',$this->user_id);
		$stmt->execute();
		$stmt->bind_result($dbPWD);
		$stmt->fetch();
		
		if (!password_verify($this->pwd, $dbPWD)) {
			$_SESSION['isv_error'] = 'Your current password is incorrect.';
			header('location:'.$from_url.'');
			exit();
		}
		
		//hash and save the new password
		$this->new_pwd = password_hash($this->new_pwd, PASSWORD_DEFAULT);
		
		$stmt->prepare("UPDATE users SET pwd=? WHERE id=?");
		$stmt->bind_param('si',$this->new_pwd,$this->user_id);
		$stmt->execute();
		$stmt->close();
		
		//return success
		$_SESSION['isv_success'] = 'Password changed.';
		header('location:'.$from_url.'');
		exit();
	}
	
	public function update_privacy($settings){
		global $isv_db;
		
		$from_url = $_SERVER['HTTP_REFERER'];
		
		$this->feed_settings = $settings['Feeds'];
		$this->phone_settings = $settings['Phone'];
		
		/***************************
			nobody = 0
			friends only = 1
			everyone = 2
		***************************/
		
		//assign corresponding values
		if($this->feed_settings == 'nobody'){
			$this->feed_settings = 0;
		} else if ($this->feed_settings == 'friends only'){
			$this->feed_settings = 1;
		} else if ($this->feed_settings == 'everyone'){
			$this->feed_settings = 2;
		}
		
		if($this->phone_settings == 'nobody'){
			$this->phone_settings = 0;
		} else if ($this->phone_settings == 'friends only'){
			$this->phone_settings = 1;
		} else if ($this->phone_settings == 'everyone'){
			$this->phone_settings = 2;
		}
		
		//check if this user has his/her settings db row
		if($this->settings_row_exists($this->user_id)){
			//update
			$stmt = $isv_db->prepare("UPDATE user_settings SET feeds=?,phone=?,time=UTC_TIMESTAMP() WHERE user_id=?");
			$stmt->bind_param('iii',$this->feed_settings,$this->phone_settings,$this->user_id);
			$stmt->execute();
			$stmt->close();
			
		} else {
			//insert
			$stmt = $isv_db->prepare("INSERT INTO user_settings (user_id,feeds,phone,time) VALUES (?,?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('iii',$this->user_id,$this->feed_settings,$this->phone_settings);
			$stmt->execute();
			$stmt->close();
		}
		
		//return success
		$_SESSION['isv_success'] = 'Privacy settings updated';
		header('location:'.$from_url.'');
		exit();
	}
	
	private function settings_row_exists($user){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM user_settings WHERE user_id=?"); 
		$stmt->bind_param('i', $user);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if($totalCount > 0){
			return true;
		} else {
			return false;
		}
	}
	
	private function validateDate($date, $format){
		$from_url = $_SERVER['HTTP_REFERER'];
			$DoB = DateTime::createFromFormat($format, $date);
			
			if(!$DoB) {
				$_SESSION['isv_error'] = "Your Date of Birth does not match the DD-MM-YYYY required format.";
				header('location:'.$from_url.'');
			 	$array['err'] = true;
				$array['message'] = 'Your Date of Birth does not match the DD-MM-YYYY required format.';
				echo json_encode($array);
				exit();
			} else {
			    $date = DateTime::createFromFormat('j/m/Y', $date);
				return $date->format('d-m-Y');
			}
	}
	
}