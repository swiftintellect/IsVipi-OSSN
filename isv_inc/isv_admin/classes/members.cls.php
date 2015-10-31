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
		
		
		
	}