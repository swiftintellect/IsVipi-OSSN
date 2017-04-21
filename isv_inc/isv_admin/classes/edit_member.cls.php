<?php
	class edit {
		
		public function __construct(){}
		
		public function change_username($username,$id){
			require_once(ISVIPI_CLASSES_BASE .'utilities/encrypt_decrypt.php'); 
			$converter = new Encryption;
			
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//check if the username is taken
			$stmt = $isv_db->prepare("SELECT id from users WHERE username=?");
			$stmt->bind_param('s',$username);
			$stmt->execute(); 
			$stmt->store_result(); 
			$stmt->bind_result($uid);
			$stmt->fetch();
			$stmt->close();
			
			if(isset($uid) && !empty($uid) && $uid == $id){
				$_SESSION['isv_error'] = 'You supplied the same username.';
		 		header('location:'.$from_url.'');
		 		exit();
			} else if (isset($uid) && !empty($uid) && $uid != $id){
				$_SESSION['isv_error'] = 'Another member with this username already exists.';
		 		header('location:'.$from_url.'');
		 		exit();
			}
			
			//if it passes
			$stmt = $isv_db->prepare("UPDATE users SET username=? WHERE id=?");
			$stmt->bind_param('si',$username, $id);
			$stmt->execute(); 
			$stmt->close();
			
			//redirect back
			$_SESSION['isv_success'] = 'Username has been changed.';
		 	header('location:'.ISVIPI_ACT_ADMIN_URL.'edit/'.$converter->encode($username));
		 	exit();
			
		}
		
		public function change_email($email,$id){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//check if the email is taken
			$stmt = $isv_db->prepare("SELECT id from users WHERE email=?");
			$stmt->bind_param('s',$email);
			$stmt->execute(); 
			$stmt->store_result(); 
			$stmt->bind_result($uid);
			$stmt->fetch();
			$stmt->close();
			
			if(isset($uid) && !empty($uid) && $uid == $id){
				$_SESSION['isv_error'] = 'You supplied the same email.';
		 		header('location:'.$from_url.'');
		 		exit();
			} else if (isset($uid) && !empty($uid) && $uid != $id){
				$_SESSION['isv_error'] = 'Another member with this email already exists.';
		 		header('location:'.$from_url.'');
		 		exit();
			}
			
			//if it passes
			$stmt = $isv_db->prepare("UPDATE users SET email=? WHERE id=?");
			$stmt->bind_param('si',$email, $id);
			$stmt->execute(); 
			$stmt->close();
			
			//redirect back
			$_SESSION['isv_success'] = 'Email has been changed.';
		 	header('location:'.$from_url.'');
		 	exit();
			
		}
		
		public function change_other($array){
			global $isv_db;
			$from_url = $_SERVER['HTTP_REFERER'];

			//update
			$stmt = $isv_db->prepare("UPDATE user_profile SET hobbies=?,relshp_status=? WHERE id=?");
			$stmt->bind_param('ssi',$array['hobbies'],$array['rel'],$array['user_id']);
			$stmt->execute(); 
			$stmt->close();
			
			//redirect back
			$_SESSION['isv_success'] = 'Details updated successfully.';
		 	header('location:'.$from_url.'');
		 	exit();
			
		}
		
		
		
	}