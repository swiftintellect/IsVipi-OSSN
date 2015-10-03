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
		$this->limit = 10;
		$this->user_id = $_SESSION['isv_user_id'];
		$this->feedTotal = $this->getTotalFeeds();
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
$getFeeds = new getFeeds(2);
$feed = $getFeeds->allFeeds();

class getFeedProperties {
	private $f_id;
	private $user_id;
	public $total_likes;
	public $total_shares;
	public $total_comments;
	
	public function __construct($feedID){
		$this->f_id = $feedID;
		$this->user_id = $_SESSION['isv_user_id'];
	}
	
	public function f_likes_count(){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_likes WHERE feed_id=?"); 
		$stmt->bind_param('i', $this->f_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if($this->hasLiked() && $totalCount > 1){
			return "You and $totalCount others like this";
		} else if ($this->hasLiked() && $totalCount === 1){
			return "You like this";
		} else if (!$this->hasLiked() && $totalCount > 1){
			return "$totalCount like this";
		} else if (!$this->hasLiked() && $totalCount === 1){
			return "$totalCount likes this";
		} else if (!$this->hasLiked() && $totalCount < 1){
			return "";
		}
		
	}
	
	public function f_comment_count(){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_comments WHERE feed_id=?"); 
		$stmt->bind_param('i', $this->f_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if ($totalCount === 1){
			return $totalCount ." Comment";
		} else if ($totalCount > 1){
			return $totalCount ." Comments";
		} else {
			return "";
		}
	}
	
		public function f_comments_available(){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_comments WHERE feed_id=?"); 
		$stmt->bind_param('i', $this->f_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		return $totalCount;
	}

	
	public function hasLiked(){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_likes WHERE feed_id=? AND user_id=?"); 
		$stmt->bind_param('ii', $this->f_id, $this->user_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if ($totalCount > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}

class getComments {
	public $feed_id;
	public $comm_id;
	public $comment;
	public $comm_time;
	public $comm_username;
	public $comm_fullname;
	public $comm_profilepic;
	public $feedComments;
	
	public function __construct($feedID){
		$this->feed_id = $feedID;
	}
	
	public function allComments(){
		global $isv_db;
		
		$sqlAllComments = $isv_db->prepare ("SELECT 
		c.id,
		c.feed_comment,
		c.time,
		u.username,
		p.fullname,
		p.profile_pic
		FROM feed_comments c
		JOIN users u ON u.id = c.user_id
		JOIN user_profile p ON p.user_id = c.user_id
		WHERE c.feed_id=? ORDER BY c.id"); 
		$sqlAllComments->bind_param('i', $this->feed_id);
		$sqlAllComments->execute(); 
		$sqlAllComments->store_result(); 
		$resultCount =  $sqlAllComments->num_rows();
		$sqlAllComments->bind_result($this->comm_id,$this->comment,$this->comm_time,$this->comm_username,$this->comm_fullname,$this->comm_profilepic); 
		
			while($sqlAllComments->fetch()){
				$this->feedComments[] = array(
					'comm_id' => $this->comm_id,
					'comment' => $this->comment,
					'comm_time' => $this->comm_time,
					'comm_username' => $this->comm_username,
					'comm_fullname' => $this->comm_fullname,
					'comm_profilepic' => $this->comm_profilepic,
				);
			}
		return $this->feedComments;
	}
	
	public function hasLikedComment($comm_id){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_comment_likes WHERE comment_id=? AND user_id=?"); 
		$stmt->bind_param('ii', $comm_id, $_SESSION['isv_user_id']);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if ($totalCount > 0){
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
	
	public function totalCommentLikes($comm_id){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_comment_likes WHERE comment_id=?"); 
		$stmt->bind_param('i', $comm_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if($totalCount > 0){
			return "<i class='fa fa-thumbs-o-up'></i> $totalCount";
		} else {
			return "";
		}
	}
	
}
