<?php
	class news {
		
		public function __construct(){}
		
		public function get_news_count($status){
			global $isv_db;
			
			if($status === "all"){
				$query = "";
			} else {
				$query = " WHERE status = $status";
			}
			
			$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM isv_news $query"); 
			$stmt->execute();  
			$stmt->bind_result($totalCount); 
			$stmt->fetch();
			$stmt->close();
			
			return $totalCount;
		}
		
		public function get_all_news_stats_page($status,$limit){
			global $isv_db;
			
			if($status === "all"){
				$query = "";
			} else {
				$query = " WHERE status = $status";
			}
			
			//get our news items
			$stmt = $isv_db->prepare ("
				SELECT id,title,news,status,pub_date from isv_news $query ORDER by id desc LIMIT $limit
			"); 
			$stmt->execute();  
			$stmt->store_result();
			$stmt->bind_result($id,$title,$news,$n_status,$pub_date); 
				$res = array();
				while($stmt->fetch()){
					$res[] = array(
						'id' => $id,
						'title' => $title,
						'news' => $news,
						'status' => $n_status,
						'pub_date' => $pub_date
					);
				}
			$stmt->close();
			
			//print_r($res); exit();
			return $res;
		}
		
		public function get_all_news($status){
			global $isv_db;
			
			if($status === "all"){
				$query = "";
			} else {
				$query = " WHERE status = $status";
			}
			
			//get our news items
			$stmt = $isv_db->prepare ("
				SELECT id,title,news,status,pub_date from isv_news $query ORDER by id desc
			"); 
			$stmt->execute();  
			$stmt->store_result();
			$stmt->bind_result($id,$title,$news,$n_status,$pub_date); 
				$res = array();
				while($stmt->fetch()){
					$res[] = array(
						'id' => $id,
						'title' => $title,
						'news' => $news,
						'status' => $n_status,
						'pub_date' => $pub_date
					);
				}
			$stmt->close();
			
			//print_r($res); exit();
			return $res;
		}
		
		public function get_sidebar_news($status){
			global $isv_db;
			
			if($status === "all"){
				$query = "";
			} else {
				$query = " WHERE status = $status";
			}
			
			//get our news items
			$stmt = $isv_db->prepare ("
				SELECT id,title,news,status,pub_date from isv_news $query ORDER by id desc LIMIT 2
			"); 
			$stmt->execute();  
			$stmt->store_result();
			$stmt->bind_result($id,$title,$news,$n_status,$pub_date); 
				$res = array();
				while($stmt->fetch()){
					$res[] = array(
						'id' => $id,
						'title' => $title,
						'news' => $news,
						'status' => $n_status,
						'pub_date' => $pub_date
					);
				}
			$stmt->close();
			
			//print_r($res); exit();
			return $res;
		}
		
		public function single_item($news_id){
			global $isv_db;
			
			$stmt = $isv_db->prepare ("
				SELECT id,title,news,pub_date from isv_news WHERE id = $news_id
			"); 
			$stmt->execute();  
			$stmt->store_result();
			$stmt->bind_result($id,$title,$news,$pub_date); 
			$stmt->fetch();
			
			$n_item = array();
			$n_item = array(
				'id' => $id,
				'title' => $title,
				'news' => $news,
				'pub_date' => $pub_date
			
			);
			
			//print_r($n_item); exit();
			return $n_item;
		}
	}