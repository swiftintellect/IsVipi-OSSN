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
		global $userStatus;
		
		if ($userStatus === 0){
			$_SESSION['isv_error'] = 'Your account has not been activated. Please activate your account to sign in.';
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
		global $isv_db,$userID,$userPWD,$userStatus;
		$stmt = $isv_db->prepare("SELECT id,pwd,status FROM users WHERE $type=?");
		$stmt->bind_param('s', $user);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($userID,$userPWD,$userStatus);
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