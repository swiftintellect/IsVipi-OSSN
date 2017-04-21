<?php 
	class install {
		
		public function __construct(){}
		
		public function step_two($db){
			$from_url = $_SERVER['HTTP_REFERER'];
			
			//create db file
			$this->create_db_file($db);
			
			//import sql file
			$this->import_sql_file($db);
			
			//end step two and start step three
			unset($_SESSION['isv_s1']);
			
			$_SESSION['isv_s1'] = 's3';
			
			//redirect with success back
			$_SESSION['isv_success'] = 'Database file created and sql file imported successfully.';
			header('location:'.$from_url.'');
			exit();
		}
		
		public function step_three($var){
			
			$from_url = $_SERVER['HTTP_REFERER'];
			require_once('../isv_inc/isv_db/db.php');
			
			//save
			$stmt = $isv_db->prepare("INSERT INTO s_info (s_url,s_title,s_email,s_time_zone,s_last_update_check) VALUES (?,?,?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('ssss',$var['URL'],$var['Title'],$var['Email'],$var['Timezone']);
			$stmt->execute();
			$stmt->close();
			
			//end step three and start step four
			unset($_SESSION['isv_s1']);
			
			$_SESSION['isv_s1'] = 's4';
			
			//redirect with success back
			$_SESSION['isv_success'] = 'Site details updated successfully.';
			header('location:'.$from_url.'');
			exit();
			
		}
		
		public function step_four($var){
			$from_url = $_SERVER['HTTP_REFERER'];
			require_once('../isv_inc/isv_db/db.php');
			
			//check if email already registered
			$stmt = $isv_db->prepare("SELECT id FROM isv_admin where email=?");
			$stmt->bind_param('s',$email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($_id);
			$stmt->fetch();
			$found = $stmt->num_rows();
			$stmt->close();
			
			if($found > 0){
				$_SESSION['isv_error'] = 'An admin with this email already exists.';
				 header('location:'.$from_url.'');
				 exit();
			}
			
			//hash the password
			$hashPWD = password_hash($var['Password'], PASSWORD_DEFAULT);
			
			//save
			$stmt = $isv_db->prepare("INSERT INTO isv_admin (email,pwd,name,status,reg_date) VALUES (?,?,?,1,UTC_TIMESTAMP())");
			$stmt->bind_param('sss',$var['Email'],$hashPWD,$var['Name']);
			$stmt->execute();
			$stmt->close();
			
			//end step four and go to finish
			unset($_SESSION['isv_s1']);
			
			$_SESSION['isv_s1'] = 'end';
			
			//redirect with success back
			$_SESSION['isv_success'] = 'Admin added successfully.';
			header('location:'.$from_url.'');
			exit();
			
		}
		
		private function create_db_file($db){
			
			//first check if the db file exists we rename it
			$db_file = '../isv_inc/isv_db/db.php';
			$newname = 'db_old_'.microtime().'.php';
			if (file_exists($db_file)){
				rename ($db_file, '../isv_inc/isv_db/'.$newname);	
			}
			
//then we create the new one
$handle = fopen($db_file, 'a') or die('Cannot open file:  '.$db_file);
$copyr = '<?php
	/*******************************************************
	*   Copyright (C) 2014  http://isvipi.org
							
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
							
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
							
	You should have received a copy of the GNU General Public License along
	with this program; if not, write to the Free Software Foundation, Inc.,
	51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
	******************************************************/ 
';
				fwrite($handle, $copyr);
				$localhost = "\n".'	$db_host = "'.$db['Host'].'";';
				fwrite($handle, $localhost);
				$database = "\n".'	$db_name = "'.$db['Database'].'";';
				fwrite($handle, $database);
				$username = "\n".'	$db_user = "'.$db['User'].'";';
				fwrite($handle, $username);
				$password = "\n".'	$db_pass = "'.$db['Password'].'";';
				fwrite($handle, $password);
				$conn_db = "\n"."\n".'	//Try to connect to the database';
				fwrite($handle, $conn_db);
				$dbconnect = "\n".'	$isv_db = @new mysqli($db_host, $db_user, $db_pass, $db_name);
	if ($isv_db->connect_errno) {
		die("<h2>Database Connection Error...</h2>");
		exit();
	}';
				fwrite($handle, $dbconnect);
				$close_php = "\n".'?>';
				fwrite($handle, $close_php);

		}
		
		private function import_sql_file($db){
			
			$from_url = $_SERVER['HTTP_REFERER'];
			
			$isv_db = new mysqli($db['Host'], $db['User'], $db['Password'], $db['Database']);
			$filename = 'sql.sql';
			$op_data = '';
			$lines = file($filename);
				foreach ($lines as $line){
					if (substr($line, 0, 2) == '--' || $line == ''){
						continue;
					}
					$op_data .= $line;
					if (substr(trim($line), -1, 1) == ';'){
						$isv_db->query($op_data);
						$op_data = '';
					}
				}
			
			}
	
		private function email_registered($email){
			require_once('../isv_inc/isv_db/db.php');
			global $isv_db;
			var_dump($isv_db);exit();
			
			$stmt = $isv_db->prepare("SELECT id FROM isv_admin where email=?");
			$stmt->bind_param('s',$email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($_id);
			$stmt->fetch();
			$Found = $stmt->num_rows();
			$stmt->close();
			
			if($Found > 0){
				return TRUE;
			} else {
				return FALSE;
			}
			
		}
	
	
	} //end of class install