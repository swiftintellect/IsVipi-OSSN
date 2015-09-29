<?php
class getFeeds {
	public $feedTotal;
	public $user_id;
	public $limit;
	public $page;
	public $start;
	public $nextP;
	
	//from feeds table
	public $feedID;
	public $feedUser;
	public $feedText;
	public $feedImg;
	public $feedStatus;
	public $feedTime;
	
	//from users table
	public $f_username;
	
	//from user profiles table
	public $f_fullname;
	public $f_profilePIC;
	
	public $feed;
	
	public function __construct ($page){
		$this->limit = 4;
		$this->user_id = $_SESSION['isv_user_id'];
		$this->feedTotal = $this->getTotalFeeds();
		//return ($this->allFeeds()); 
	}
	
	private function getTotalFeeds(){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feeds WHERE user_id=?"); 
		$stmt->bind_param('i', $this->user_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		return $totalCount;
	}
	
	public function allFeeds(){
		global $isv_db,$feed;

		$sqlAllFeeds = $isv_db->prepare ("SELECT 
		f.id,
		f.user_id,
		f.text_feed,
		f.img_feed,
		f.status,
		f.time,
		u.username,
		p.fullname,
		p.profile_pic
		FROM feeds f
		JOIN users u ON u.id = f.user_id
		JOIN user_profile p ON p.user_id = f.user_id
		WHERE f.user_id=? ORDER BY f.id DESC LIMIT 0,?"); 
		$sqlAllFeeds->bind_param('ii', $this->user_id,$this->limit);
		$sqlAllFeeds->execute(); 
		$sqlAllFeeds->store_result(); 
		$resultCount =  $sqlAllFeeds->num_rows();
		$sqlAllFeeds->bind_result($this->feedID,$this->feedUser,$this->feedText,$this->feedImg,$this->feedStatus,$this->feedTime,$this->f_username,$this->f_fullname,$this->f_profilePIC); 
		
			while($sqlAllFeeds->fetch()){
				$this->feed[] = array(
					'feed_id' => $this->feedID,
					'feed_user' => $this->feedUser,
					'feed_text' => $this->feedText,
					'feed_image' => $this->feedImg,
					'feed_status' => $this->feedStatus,
					'feed_time' => $this->feedTime,
					'feed_username' => $this->f_username,
					'feed_fullname' => $this->f_fullname,
					'feed_profilePIC' => $this->f_profilePIC
				);
			}
		return $this->feed;
	} 

}
$getFeeds = new getFeeds($_SESSION['isv_feed_p']);
$feed = $getFeeds->allFeeds();