<?php
class userRegistration {
	private $username;
	private $name;
	private $email;
	private $password;
	private $rPassword;
	private $country;
	private $dob;
	private $sex;
	
	public function __construct($userFields){
		//check if supplied/empty
		foreach( $userFields as $field => $value){
			if(!isSupplied($value)){
				 $array['err'] = true;
				 $array['message'] = 'Please fill in '.$field.'!';
				 echo json_encode($array);
				 exit();
			}
		}
		//assign our variables
		$this->username = $userFields['Username'];
		$this->name = $userFields['Full Name'];
		$this->email = $userFields['Email'];
		$this->password = $userFields['Password'];
		$this->rPassword = $userFields['Repeat Password'];
		$this->country = $userFields['Country'];
		$this->dob = $userFields['Date of Birth'];
		$this->sex = $userFields['Gender'];
		
		//validate username
		/*(allow only alphanumeric,hyphen and underscores) */
		if(preg_match('/[^a-z_\-0-9]/i', $this->username)){
		  	$array['err'] = true;
			$array['message'] = 'Username cannot have any space. It MUST be one word with 8 or more characters.';
			echo json_encode($array);
			exit();
		}

		if(strlen($this->username) < 6){
			$array['err'] = true;
			$array['message'] = 'Username MUST be 6 or more characters.';
			echo json_encode($array);
			exit();
		}
		//check if the username is already taken
		if($this->isRegistered($this->username, 'username')){
			$array['err'] = true;
			$array['message'] = ''.$this->username.' is taken. Please try another.';
			echo json_encode($array);
			exit();
		}
		//validate email
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$array['err'] = true;
			$array['message'] = 'Your email is invalid.';
			echo json_encode($array);
			exit();
		}
		
		//check if a user with the same email exists
		if($this->isRegistered($this->email, 'email')){
			$array['err'] = true;
			$array['message'] = 'A user with this email is already registered.';
			echo json_encode($array);
			exit();
		}
		
		//check if passwords is long enough
		if(strlen($this->password) < 8){
			$array['err'] = true;
			$array['message'] = 'Password MUST be 8 or more characters.';
			echo json_encode($array);
			exit();
		}
		
		//check if the two passwords match
		if ($this->password !== $this->rPassword){
			$array['err'] = true;
			$array['message'] = 'Password and Re-enter Password do not match.';
			echo json_encode($array);
			exit();
		}
		
		//validate date format
		$format = "d/m/Y";
		$this->dob = $this->validateDate($this->dob, $format);
		
		//hash the password
		$hashedPWD = password_hash($this->password, PASSWORD_DEFAULT);
		
		//save in a database
		global $isv_db;
		$stmt = $isv_db->prepare("INSERT INTO users (username,email,pwd,reg_date,last_activity) VALUES (?,?,?,UTC_TIMESTAMP(),UTC_TIMESTAMP())");
		$stmt->bind_param('sss',$this->username,$this->email,$hashedPWD);
		$stmt->execute();
		
		//retrieve new user id
		$stmt->prepare("SELECT id FROM users WHERE email=?");
		$stmt->bind_param('s', $this->email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($userID);
		$stmt->fetch();
		
		//save other details in user_profile table
		$stmt->prepare("INSERT INTO user_profile (user_id,fullname,gender,dob,country) VALUES (?,?,?,?,?)");
		$stmt->bind_param('issss',$userID,$this->name,$this->sex,$this->dob,$this->country);
		$stmt->execute();
		$stmt->close();
		
		//send activation email if this is enabled
		$siteInfo = new siteManager();
		$isv_siteSettings = $siteInfo->getSiteSettings();
		$isv_siteDetails = $siteInfo->getSiteInfo();
		
		if($isv_siteSettings['user_validate'] === 1){
			
			/* generate our validation code */
			$validCode = $this->getValidationCode($hashedPWD);
			
			/* include our email functions file */
			require_once(ISVIPI_FUNCTIONS_BASE .'emails/reg_emails.php');
			
			/*send the email */
			sendValidationEmail($this->email,$this->name,$validCode,$isv_siteDetails['s_email'],$isv_siteDetails['s_title'],$isv_siteDetails['s_url'],$isv_siteSettings['logo']);
			
			$msg = 'Account created. We have sent an email with an activation code to '.$this->email.'. Follow instructions in the email to activate your account.';
		} else {
			$msg = 'Account created. You can now login.';
		}
		
		//notify admin if this is enabled
		if($isv_siteSettings['notifyAdmin_newUser'] ===1){
			notifyAdmin($this->name,'New User',$isv_siteDetails['s_email'],$isv_siteDetails['s_title']);
		}
		
		//return success notice
		$array['err'] = false;
		$array['message'] = $msg;
		echo json_encode($array);
		exit();

	}/** end of __construct */
	
		private function isRegistered($term,$type){
			global $isv_db;
			$stmt = $isv_db->prepare("SELECT id FROM users WHERE $type=?");
			$stmt->bind_param('s',$term);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($userID);
			$stmt->fetch();
				if ($stmt->num_rows() > 0){
					return TRUE;
				} else {
					return FALSE;
				}
			$stmt->close( );
			
		}
		
		private function validateDate($date, $format){
			$DoB = DateTime::createFromFormat($format, $date);
			
			if(!$DoB) {
			 	$array['err'] = true;
				$array['message'] = 'Your Date of Birth does not match the DD-MM-YYYY required format.';
				echo json_encode($array);
				exit();
			} else {
			    $date = DateTime::createFromFormat('j/m/Y', $date);
				return $date->format('d-m-Y');
			}
		}
		
		private function getValidationCode($hashdP){
				//generate the validation code
				$code = randomCode($hashdP,'20');
				
				//save code in our db
				global $isv_db;
				$stmt = $isv_db->prepare("INSERT INTO user_validations (email,code,time) VALUES (?,?,UTC_TIMESTAMP())");
				$stmt->bind_param('ss', $this->email, $code);
				$stmt->execute();
				$stmt->close();
			return $code;
		}
}

class userValidation {
	private $code;
	
	public function __construct($_code){
		$this->code = $_code;
		
		//check if the code is valid
		if (!valid_codeExists($this->code,'code')){
			$_SESSION['isv_error'] = 'Invalid validation code. Check your email for the correct validation code.';
			notFound404Err();
			exit();
		}
		
		//activate user
		global $isv_db,$exstEmail;
		$newStatus = 1;
		$stmt = $isv_db->prepare("UPDATE users SET status=? where email=?");
		$stmt->bind_param('is',$newStatus,$exstEmail);
		$stmt->execute();
		
		//delete code
		$stmt->prepare("DELETE from user_validations where code=?");
		$stmt->bind_param('s',$this->code);
		$stmt->execute();
		$stmt->close();
		
		//redirect to index page with success message
			$_SESSION['isv_success'] = 'Account Activated. Please sign in to proceed.';
			header('location:'.ISVIPI_URL.'');
			exit();
	}
	
	
}