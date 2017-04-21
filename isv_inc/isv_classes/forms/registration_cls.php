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
		global $converter;
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
		
		//check if the date of birth meets minimum reg requirements
		$min_age = 12;
		
		if(!validate_age($this->dob,$min_age)){
			$array['err'] = true;
			$array['message'] = "Minimum age limit is $min_age years.";
			echo json_encode($array);
			exit();
		}
		
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
		
		//save detaile in user_settings table
		$feeds = 1;
		$phone = 1;
		$stmt->prepare("INSERT INTO user_settings (user_id,feeds,phone,time) VALUES (?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('iii',$userID,$feeds,$phone);
		$stmt->execute();
		$stmt->close();
		
		//send activation email if this is enabled
		$siteInfo = new siteManager();
		$isv_siteSettings = $siteInfo->getSiteSettings();
		$isv_siteDetails = $siteInfo->getSiteInfo();
		
		//if the user must validate new account
		if(MUST_VALIDATE){
			
			/* generate our validation code */
			$validCode = $this->getValidationCode($hashedPWD);
			
			/* include our email class file */
			require_once ISVIPI_CLASSES_BASE . 'emails/emails_cls.php';
			$send = new emails();
			
			/*send the email */
			//email message
			$message = "<p>Your account has been created. Please click the link below to activate your account and sign in.</p>
			<p> Link: ".$isv_siteDetails['s_url']."/p/users/".$converter->encode('validate')."/".$validCode."</p>
			<p> If for some reason you cannot click on the link above, copy and paste it in your browser.</p>
			";
			$subject = "Validate new Account";
			$send->send_email($this->email,$this->name,$subject,$message);
			
			//onsite message
			$msg = 'Account created. We have sent an email with an activation code to '.$this->email.'. Follow instructions in the email to activate your account.';
		} else {
			$subject = "Welcome to ".$isv_siteDetails['s_title'];
			
			//email message
			$message = "<p>This is our official email to welcome you to My SITE. We hope that you will enjoy our services while having fun creating new connections and networks. </p>
			<p>Follow this link to sign in to your new account ".$isv_siteDetails['s_url']."</p>
";
			$send->send_email($this->email,$this->name,$subject,$message);
			
			//onsite message
			$msg = 'Account created. You can now login.';
		}
		
		//notify admin if this is enabled
		if(NOTIFY_ADMIN_NEW_USER){
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
		
		//retrieve user id and log in the user
		$stmt = $isv_db->prepare("SELECT id FROM users WHERE email=?");
		$stmt->bind_param('s',$exstEmail);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($userID);
		$stmt->fetch();
		
		//set session
		$_SESSION['isv_user_id'] = $userID;
		
		//delete code
		$stmt->prepare("DELETE from user_validations where code=?");
		$stmt->bind_param('s',$this->code);
		$stmt->execute();
		$stmt->close();
		
		//redirect to index page with success message
			$_SESSION['isv_success'] = 'Your account has been activated.';
			header('location:'.ISVIPI_URL.'home');
			exit();
	}
	
	
}