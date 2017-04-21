<?php
class changePassword {
	private $user_id;
	private $new_pwd;
	
	public function __construct($user,$pwd){
		$this->user_id = $user;
		$this->new_pwd = $pwd;
		
		//hash our new changePassword
		$hashedPWD = password_hash($this->new_pwd, PASSWORD_DEFAULT);
		global $isv_db;
		
		$stmt = $isv_db->prepare("UPDATE users SET pwd=? WHERE id=?");
		$stmt->bind_param('si',$hashedPWD,$this->user_id);
		$stmt->execute();
		$stmt->close();
	}
	
	public function deleteResetCode($code){
		global $isv_db;
		$stmt = $isv_db->prepare("DELETE FROM user_validations WHERE code=?");
		$stmt->bind_param('s',$code);
		$stmt->execute();
		$stmt->close();
	}
}