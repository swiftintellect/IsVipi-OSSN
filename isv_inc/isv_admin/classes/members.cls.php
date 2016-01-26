<?php
	class member {
		
		public function __construct(){}
		
		public function activate($m_id){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//activate user
			$stmt = $isv_db->prepare("UPDATE users SET status=1 WHERE id=?");
			$stmt->bind_param('i',$m_id);
			$stmt->execute();
			$stmt->close();
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'This member has been activated.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		public function suspend($m_id){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//suspend user
			$stmt = $isv_db->prepare("UPDATE users SET status=2 WHERE id=?");
			$stmt->bind_param('i',$m_id);
			$stmt->execute();
			$stmt->close();
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'This member has been suspended.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		public function unsuspend($m_id){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//unsuspend user
			$stmt = $isv_db->prepare("UPDATE users SET status=1 WHERE id=?");
			$stmt->bind_param('i',$m_id);
			$stmt->execute();
			$stmt->close();
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'This member has been unsuspended.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		public function delete($m_id){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//shedule member for deletion
			$stmt = $isv_db->prepare("UPDATE users SET status=9 WHERE id=?");
			$stmt->bind_param('i',$m_id);
			$stmt->execute();
			$stmt->close();
			
			//save into our scheduled deletions table
			$stmt = $isv_db->prepare("
				INSERT IGNORE INTO scheduled_del
				SET user_id = ?,
				scheduled_by = 0,
				schedule_time = UTC_TIMESTAMP()
			");
			$stmt->bind_param('i',$m_id);
			$stmt->execute();
			$stmt->close();
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'This member has been scheduled for deletion.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		public function undelete($m_id){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//activate user
			$stmt = $isv_db->prepare("UPDATE users SET status=1 WHERE id=?");
			$stmt->bind_param('i',$m_id);
			$stmt->execute();
			$stmt->close();
			
			//remove user from scheduled deletion
			$stmt = $isv_db->prepare("DELETE from scheduled_del WHERE user_id=?");
			$stmt->bind_param('i',$m_id);
			$stmt->execute();
			$stmt->close();
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'This member has been removed from scheduled deletion.';
			 header('location:'.$from_url.'');
			 exit();
		}
		
		public function mass_activate($users){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			foreach ($users as $id){
				if(!is_numeric($id)){
					 $_SESSION['isv_error'] = "User IDs must be numbers only. Non-numeric characters detected.";
					 header('location:'.$from_url.'');
					 exit();
				}
				
				//activate user
				$stmt = $isv_db->prepare("UPDATE users SET status=1 WHERE id=? AND status=0");
				$stmt->bind_param('i',$id);
				$stmt->execute();
				$stmt->close();
			}
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'Members activated successfully.';
			 header('location:'.$from_url.'');
			 exit();
			
		}
		
		public function mass_suspend($users){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			foreach ($users as $id){
				if(!is_numeric($id)){
					 $_SESSION['isv_error'] = "User IDs must be numbers only. Non-numeric characters detected.";
					 header('location:'.$from_url.'');
					 exit();
				}
				
				//suspend user
				$stmt = $isv_db->prepare("UPDATE users SET status=2 WHERE id=? AND status !=9");
				$stmt->bind_param('i',$id);
				$stmt->execute();
				$stmt->close();
			}
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'Members suspended successfully.';
			 header('location:'.$from_url.'');
			 exit();
			
		}
		
		public function mass_unsuspend($users){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			foreach ($users as $id){
				if(!is_numeric($id)){
					 $_SESSION['isv_error'] = "User IDs must be numbers only. Non-numeric characters detected.";
					 header('location:'.$from_url.'');
					 exit();
				}
				
				//unsuspend user
				$stmt = $isv_db->prepare("UPDATE users SET status=1 WHERE id=? AND status =2");
				$stmt->bind_param('i',$id);
				$stmt->execute();
				$stmt->close();
			}
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'Members unsuspended successfully.';
			 header('location:'.$from_url.'');
			 exit();
			
		}
		
		public function mass_delete($users){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			foreach ($users as $id){
				if(!is_numeric($id)){
					 $_SESSION['isv_error'] = "User IDs must be numbers only. Non-numeric characters detected.";
					 header('location:'.$from_url.'');
					 exit();
				}
				
				//delete user
				$stmt = $isv_db->prepare("UPDATE users SET status=9 WHERE id=?");
				$stmt->bind_param('i',$id);
				$stmt->execute();
				$stmt->close();
				
				//save into our scheduled deletions table
				$stmt = $isv_db->prepare("
					INSERT IGNORE INTO scheduled_del
					SET user_id = ?,
					scheduled_by = 0,
					schedule_time = UTC_TIMESTAMP()
				");
				$stmt->bind_param('i',$id);
				$stmt->execute();
				$stmt->close();
			}
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'Members scheduled for deletion successfully.';
			 header('location:'.$from_url.'');
			 exit();
			
		}
		
		public function mass_undelete($users){
			global $isv_db;
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			foreach ($users as $id){
				if(!is_numeric($id)){
					 $_SESSION['isv_error'] = "User IDs must be numbers only. Non-numeric characters detected.";
					 header('location:'.$from_url.'');
					 exit();
				}
				
				//undelete user
				$stmt = $isv_db->prepare("UPDATE users SET status=1 WHERE id=?");
				$stmt->bind_param('i',$id);
				$stmt->execute();
				$stmt->close();
				
				//remove user from scheduled deletion
				$stmt = $isv_db->prepare("DELETE from scheduled_del WHERE user_id=?");
				$stmt->bind_param('i',$id);
				$stmt->execute();
				$stmt->close();
			}
			
			//redirect the user back with a success message
			 $_SESSION['isv_success'] = 'Members undeleted successfully.';
			 header('location:'.$from_url.'');
			 exit();
			
		}
		
		public function new_member($req,$type,$pwd2){
			global $isv_db,$converter;
			
			$siteInfo = new siteManager();
			$s_s = $siteInfo->getSiteSettings();
			$s_d = $siteInfo->getSiteInfo();
			
			//validate username
			/*(allow only alphanumeric,hyphen and underscores) */
			if(preg_match('/[^a-z_\-0-9]/i', $req['Username'])){
				$array['err'] = true;
				$array['message'] = 'Username cannot have any space. It MUST be one word with 8 or more characters.';
				echo json_encode($array);
				exit();
			}
			
			//minimum number of characters for username is 6
			if(strlen($req['Username']) < 6){
				$array['err'] = true;
				$array['message'] = 'Username MUST be 6 or more characters.';
				echo json_encode($array);
				exit();
			}
			
			//check if the username is taken
			if($this->isRegistered($req['Username'], 'username')){
				$array['err'] = true;
				$array['message'] = ''.$req['Username'].' is taken. Please try another.';
				echo json_encode($array);
				exit();
			}
			
			//validate email
			if (!filter_var($req['Email'], FILTER_VALIDATE_EMAIL)) {
				$array['err'] = true;
				$array['message'] = 'Your email is invalid.';
				echo json_encode($array);
				exit();
			}
			
			//check if a user with the same email exists
			if($this->isRegistered($req['Email'], 'email')){
				$array['err'] = true;
				$array['message'] = 'A user with this email is already registered.';
				echo json_encode($array);
				exit();
			}
			
			//validate date format
			$format = "d/m/Y";
			$req['DoB'] = $this->validateDate($req['DoB'], $format);
			
			//check if the date of birth meets minimum reg requirements
			$min_age = 12;
			
			if(!validate_age($req['DoB'],$min_age)){
				$array['err'] = true;
				$array['message'] = "Minimum age limit is $min_age years.";
				echo json_encode($array);
				exit();
			}
			
			if($type === "auto"){
				$varCo = $req['Email'].$req['Username'];
				$pwd2save = randomCode($varCo,'12');
			} else {
				$pwd2save = $pwd2;
			}
			
			//hash the password
			$hashedPWD = password_hash($pwd2save, PASSWORD_DEFAULT);
			
			//determine user status
			if($req['Status'] === 'activated'){
				$message = "
					<p>A new account has been created for you at ".$s_d['s_title'].". Your account credentials are as follow:</p>
					<p style='line-height:22px; margin-left:50px'>
						<strong>Email:</strong> ".$req['Email']."<br/>
						<strong>Username:</strong> ".$req['Username']."<br/>
						<strong>Password:</strong> ".$pwd2save."
					</p>
					<p>Please follow ".$s_d['s_url']." to log into your new account.</p>
				";
				$status = 1;
			} else if($req['Status'] === 'send_email'){
				
				//generate activation code
				$varCo = $req['Email'].$req['Username'];
				$act_code = randomCode($varCo,"25");
				
				//save validation code
				$stmt = $isv_db->prepare("INSERT INTO user_validations (email,code,time) VALUES (?,?,UTC_TIMESTAMP())");
				$stmt->bind_param('ss', $req['Email'], $act_code);
				$stmt->execute();
				$stmt->close();
								
				$message = "
					<p>A new account has been created for you at ".$s_d['s_title'].". Your account credentials are as follows:</p>
					<p style='line-height:22px; margin-left:50px'>
						<strong>Email:</strong> ".$req['Email']."<br/>
						<strong>Username:</strong> ".$req['Username']."<br/>
						<strong>Password:</strong> ".$pwd2save."
					</p>
					<p>Before you can log in, you will have to validate your email. Please click the link below to validate your email.</p>
					<p>Validation Link: ".$s_d['s_url']."/p/users/".$converter->encode('validate')."/$act_code</p>
				";
				$status = 0;
			} else {
				$message = "
					<p>A new account has been created for you at ".$s_d['s_title'].". Your account credentials are as follow:</p>
					<p style='line-height:22px; margin-left:50px'>
						<strong>Email:</strong> ".$req['Email']."<br/>
						<strong>Username:</strong> ".$req['Username']."<br/>
						<strong>Password:</strong> ".$pwd2save."
					</p>
					<p>Please follow ".$s_d['s_url']." to log into your new account.</p>
				";
				$status = 0;
			}
			
			//save in a database
			$stmt = $isv_db->prepare("INSERT INTO users (username,email,pwd,status,reg_date,last_activity) VALUES (?,?,?,?,UTC_TIMESTAMP(),UTC_TIMESTAMP())");
			$stmt->bind_param('sssi',$req['Username'],$req['Email'],$hashedPWD,$status);
			$stmt->execute();
			
			//retrieve new user id
			$stmt->prepare("SELECT id FROM users WHERE email=?");
			$stmt->bind_param('s', $req['Email']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($userID);
			$stmt->fetch();
			
			//save other details in user_profile table
			$stmt->prepare("INSERT INTO user_profile (user_id,fullname,gender,dob,country) VALUES (?,?,?,?,?)");
			$stmt->bind_param('issss',$userID,$req['Full Name'],$req['Gender'],$req['DoB'],$req['Country']);
			$stmt->execute();
			
			//save details in user_settings table
			$feeds = 1;
			$phone = 1;
			$stmt->prepare("INSERT INTO user_settings (user_id,feeds,phone,time) VALUES (?,?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('iii',$userID,$feeds,$phone);
			$stmt->execute();
			$stmt->close();
			
			/* include our email class file */
			require_once ISVIPI_CLASSES_BASE . 'emails/emails_cls.php';
			$send = new emails();
			
			//send email
			$subject = "New Account Created";
			$send->send_email($req['Email'],$req['Full Name'],$subject,$message);
			
			$array['err'] = false;
			$array['message'] = "New member has been created successfully";
			echo json_encode($array);
			exit();
			
		}
		
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
	}