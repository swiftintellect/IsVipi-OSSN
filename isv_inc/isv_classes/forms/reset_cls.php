<?php
class resetPassword {
	private $username;
	private $type;
	private $email;
	
	public function __construct(){}
	public function resetPWD($user,$type){
		$this->type = $type;
		
		if ($this->type == 'username'){
			$this->username = $user;
			global $isv_db;
			
			//select email from the db
			$stmt = $isv_db->prepare("SELECT email FROM users WHERE username=?");
			$stmt->bind_param('s', $this->username);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($userEmail);
			$stmt->fetch();
				if ($stmt->num_rows() < 1){
					$stmt->close();
					$_SESSION['isv_error'] = 'No such user found in our database';
					header('location:'.ISVIPI_URL.'forgot');
					exit();
				}
			
			$this->email = $userEmail;
			
			//check if a validation code already exists in our db
			if (valid_codeExists($this->email,'email')){
				global $exstCode;
				$newCode = $exstCode;
				
				//update our query time
				$stmt->prepare("UPDATE user_validations SET time=UTC_TIMESTAMP() WHERE code=?");
				$stmt->bind_param('s', $newCode);
				$stmt->execute();
				$stmt->close();
			} else {
				//generate validation code
				$newCode = randomCode($this->email,'25');
				
				//save in our db
				$stmt->prepare("INSERT INTO user_validations (email,code,time) VALUES (?,?,UTC_TIMESTAMP())");
				$stmt->bind_param('ss', $this->email, $newCode);
				$stmt->execute();
				$stmt->close();
			}
			
		} else if($this->type == 'email'){
			$this->email = $user;
			
			//check if a user with this email exists
			global $isv_db;
			$stmt = $isv_db->prepare("SELECT id FROM users WHERE email=?");
			$stmt->bind_param('s', $this->email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($userID);
			$stmt->fetch();
				if ($stmt->num_rows() < 1){
					$stmt->close();
					$_SESSION['isv_error'] = 'No such user found in our database';
					header('location:'.ISVIPI_URL.'forgot');
					exit();
				}
			
			//check if a validation code already exists in our db
			if (valid_codeExists($this->email,'email')){
					global $exstCode;
					$newCode = $exstCode;
					
					//update our query time
					$stmt->prepare("UPDATE user_validations SET time=UTC_TIMESTAMP() WHERE code=?");
					$stmt->bind_param('s', $newCode);
					$stmt->execute();
					$stmt->close();
				} else {
					//generate validation code
					$newCode = randomCode($this->email,'25');
					
					//save in our db
					$stmt = $isv_db->prepare("INSERT INTO user_validations (email,code,time) VALUES (?,?,UTC_TIMESTAMP())");
					$stmt->bind_param('ss', $this->email, $newCode);
					$stmt->execute();
					$stmt->close();
				}
		}
		
		/* include our email functions file */
		require_once(ISVIPI_FUNCTIONS_BASE .'emails/resetPWD_email.php');
		
		// send our email
		$siteInfo = new siteManager();
		$isv_siteSettings = $siteInfo->getSiteSettings();
		$isv_siteDetails = $siteInfo->getSiteInfo();
		
		sendResetPWDEmail($this->email,$newCode,$isv_siteDetails['s_email'],$isv_siteDetails['s_title'],$isv_siteDetails['s_url'],$isv_siteSettings['logo']);
		
		//redirect with a success message
		$_SESSION['isv_success'] = 'An email with your password reset link has been sent to '.$this->email.'. Follow instructions in the email to change your password.';
		header('location:'.ISVIPI_URL .'forgot');
		exit();
		
	}
	
}