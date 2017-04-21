<?php
class signIn {
	private $user;
	private $pwd;
	private $type;
	
	public function __construct($_type,$_user,$_pwd){
		$this->type = $_type;
		$this->user = $_user;
		$this->pwd = $_pwd;
		
		//check if user exists
		$userD = $this->userExists($this->user, $this->type);
		
		//check is user is active
		global $userStatus,$email;
		
		//if inactivated
		if ($userStatus === 0){
			$_SESSION['act_email'] = $email;
			$_SESSION['isv_error'] = 'Your account has not been activated. Please <a href="'.ISVIPI_URL.'p/users/resend_activation"><span style="color:#FFFF00">activate</span></a> your account to sign in.';
			header('location:'.ISVIPI_URL.'');
			exit();
		}
		
		//if suspended
		if ($userStatus === 2){
			$_SESSION['isv_error'] = 'Your account was suspended. Please contact an admin for help.';
			header('location:'.ISVIPI_URL.'');
			exit();
		}
		
		//if scheduled for deletion by an admin
		if ($userStatus === 9 && sched_del_by_admin($userD['user_id'])){
			$_SESSION['isv_error'] = 'Your account was scheduled for deletion. Please contact the admin if this is a mistake.';
			header('location:'.ISVIPI_URL.'');
			exit();
		}
		
		//check if passwords match
		if (!password_verify($this->pwd, $userD['user_pwd'])) {
				$_SESSION['isv_error'] = ''.$this->type.' or password not valid';
				header('location:'.ISVIPI_URL.'');
				exit();
		} else {
			$_SESSION['isv_user_id'] = $userD['user_id'];
			if (isset($_SESSION['isv_pre_signIn_url']) && !empty($_SESSION['isv_pre_signIn_url'])){
				$redirectURL = $_SESSION['isv_pre_signIn_url'];
				unset($_SESSION['isv_pre_signIn_url']);
			} else {
				$redirectURL = ''.ISVIPI_URL.'home/';
			}
			
			header('location:'.$redirectURL.'');
			exit();
		}
}
	
	private function userExists($user,$type){
		global $isv_db,$userID,$email,$userPWD,$userStatus;
		$stmt = $isv_db->prepare("SELECT id,email,pwd,status FROM users WHERE $type=?");
		$stmt->bind_param('s', $user);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($userID,$email,$userPWD,$userStatus);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				$userDetails = array(
					'user_id' => $userID,
					'user_pwd' => $userPWD,
				);
				return $userDetails;
			} else {
				$_SESSION['isv_error'] = 'No such user was found in our database';
				header('location:'.ISVIPI_URL.'');
				exit();
			}
		$stmt->close();
	}
}

class resendActEmail {
	private $email;
	private $code;
	
	public function __construct(){
		$this->email = $_SESSION['act_email'];
		
		//check if an activation code exists and generate one if it doesnt exist
		$this->code = $this->act_code_exists($this->email);
		
		//reuire our email file
		require_once(ISVIPI_FUNCTIONS_BASE .'emails/reg_emails.php');
		
		//send email
		global $isv_siteDetails,$isv_siteSettings;
		
		sendValidationEmail($this->email,"Member",$this->code,$isv_siteDetails['s_email'],$isv_siteDetails['s_title'],$isv_siteDetails['s_url'],$isv_siteSettings['logo']);
		
		//unset our session email
		unset($_SESSION['act_email']);
		
		//redirect to homepage with success message
		$_SESSION['isv_success'] = "We have sent an email with an activation code to $this->email. Follow instructions in the email to activate your account.";
		header('location:'.ISVIPI_URL.'');
		exit();
		
	}
	
	public function act_code_exists($email){
		global $isv_db;
		
		$stmt = $isv_db->prepare("SELECT code FROM user_validations WHERE email=?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($actv_code);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				return $actv_code;
			} else {
				//generate new code
				$this->code = randomCode($this->email,'25');
				//save in the db
				$stmt->prepare("INSERT INTO user_validations (email,code,time) VALUES (?,?,UTC_TIMESTAMP())");
				$stmt->bind_param('ss', $email,$this->code);
				$stmt->execute();
				
				return $this->code;	
			}
		$stmt->close();
	}
	
	
	
	
	
	
}