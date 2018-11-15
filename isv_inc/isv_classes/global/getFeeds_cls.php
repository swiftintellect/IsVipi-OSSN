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
	public $feedSharedText;
	public $feedImg;
	public $old_feed_id;
	public $feedTime;
	public $friend_id;
	
	//from users table
	public $f_username;
	
	//from user profiles table
	public $f_fullname;
	public $f_profilePIC;
	
	public $feed;
	
	public function __construct (){
		$this->user_id = $_SESSION['isv_user_id'];
		$this->feedTotal = $this->getTotalFeeds();
	}
	
	public function getTotalFeeds(){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feeds WHERE user_id=?"); 
		$stmt->bind_param('i', $this->user_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		return $totalCount;
	}
	
	public function allFeeds($fLimit){
		global $isv_db,$feed;

		$sqlAllFeeds = $isv_db->prepare ("SELECT 
		f.id,
		f.user_id,
		f.text_feed,
		f.shared_feed,
		f.img_feed,
		f.old_feed_id,
		f.time,
		f.att_link,
		f.att_title,
		f.att_description,
		f.att_video,
		f.att_image,
		f.groupshare,
		f.pageshare,
		f.sharedgroup,
		f.sharedpage,
		fr.user1,
		u.username,
		p.fullname,
		p.profile_pic
		FROM feeds f
		LEFT JOIN friends fr ON f.user_id = fr.user1
		JOIN users u ON u.id = f.user_id
		JOIN user_profile p ON p.user_id = u.id
		WHERE f.user_id=? OR (fr.user1=? OR fr.user2=?) GROUP BY f.id ORDER BY f.id DESC LIMIT 0,?"); 
		$sqlAllFeeds->bind_param('iiii', $this->user_id,$this->user_id,$this->user_id,$fLimit);
		$sqlAllFeeds->execute(); 
		$sqlAllFeeds->store_result(); 
		$resultCount =  $sqlAllFeeds->num_rows();
		$sqlAllFeeds->bind_result($this->feedID,$this->feedUser,$this->feedText,$this->feedSharedText,$this->feedImg,$this->old_feed_id,$this->feedTime,$attlink,$atttitle,$attdescription,$attvideo,$attimage,$groupshare,$pageshare,$gshared,$pshared,$this->friend_id,$this->f_username,$this->f_fullname,$this->f_profilePIC); 
		
			while($sqlAllFeeds->fetch()){
				$this->feed[] = array(
					'feed_id' => $this->feedID,
					'feed_user' => $this->feedUser,
					'feed_text' => $this->feedText,
					'feed_shared_text' => $this->feedSharedText,
					'feed_image' => $this->feedImg,
					'old_feed_id' => $this->old_feed_id,
					'feed_time' => $this->feedTime,
					'att_link' => $attlink,
					'att_title' => $atttitle,
					'att_description' => $attdescription,
					'att_video' => $attvideo,
					'att_image' => $attimage,
					'feed_username' => $this->f_username,
					'feed_fullname' => $this->f_fullname,
					'feed_profilePIC' => $this->f_profilePIC,
					'groupshare' => $groupshare,
					'pageshare' => $pageshare,
					'sharedgroup' => $gshared,
					'sharedpage' => $pshared 
				);
			}
		return $this->feed;
	} 

}

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
			return "You and $totalCount others like this &nbsp;&nbsp;";
		} else if ($this->hasLiked() && $totalCount === 1){
			return "You like this &nbsp;&nbsp;";
		} else if (!$this->hasLiked() && $totalCount > 1){
			return "$totalCount like this &nbsp;&nbsp;";
		} else if (!$this->hasLiked() && $totalCount === 1){
			return "$totalCount likes this &nbsp;&nbsp;";
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
			return $totalCount ." Comment &nbsp;&nbsp;";
		} else if ($totalCount > 1){
			return $totalCount ." Comments &nbsp;&nbsp;";
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
	public $comm_user_id;
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
		c.user_id,
		c.feed_comment,
		c.time,
		u.username,
		p.fullname,
		p.profile_pic
		FROM feed_comments c
		JOIN users u ON u.id = c.user_id
		JOIN user_profile p ON p.user_id = c.user_id
		WHERE c.feed_id=? GROUP BY c.id ORDER BY c.id"); 
		$sqlAllComments->bind_param('i', $this->feed_id);
		$sqlAllComments->execute(); 
		$sqlAllComments->store_result(); 
		$resultCount =  $sqlAllComments->num_rows();
		$sqlAllComments->bind_result($this->comm_id,$this->comm_user_id,$this->comment,$this->comm_time,$this->comm_username,$this->comm_fullname,$this->comm_profilepic); 
		
			while($sqlAllComments->fetch()){
				$this->feedComments[] = array(
					'comm_id' => $this->comm_id,
					'comm_user_id' => $this->comm_user_id,
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

class getShares {
	private $feed_id;
	private $me;
	public $shares;
	
	public function __construct($feed_id){
		$this->feed_id = $feed_id;
		$this->me = $_SESSION['isv_user_id'];
		
	}
	
	public function isSharedFeed($oldFeed){
		global $isv_db;
		$isShared = $isv_db->prepare ("SELECT 
		s.id,
		s.time,
		s.old_feed_id,
		u.username,
		p.fullname,
		p.profile_pic
		FROM feed_shares s
		JOIN users u ON u.id = s.feed_user
		JOIN user_profile p ON p.user_id = s.feed_user
		WHERE s.old_feed_id=? AND s.new_feed_id=?"); 
		$isShared->bind_param('ii', $oldFeed,$this->feed_id);
		$isShared->execute(); 
		$isShared->store_result(); 
		$resultCount =  $isShared->num_rows();
		$isShared->bind_result($share_id,$share_time,$sOldFeed_id,$sFromUsername,$sFromFullName,$sFromProfPic);
		$isShared->fetch();
			$this->shares = array(
				's_id' => $share_id,
				's_time' => $share_time,
				's_old_feed_id' => $sOldFeed_id,
				's_from_username' => $sFromUsername,
				's_from_fullname' => $sFromFullName,
				's_from_prof_pic' => $sFromProfPic,
			);
		return $this->shares; 
		
	}
	
	public function totalFeedShares(){
		global $isv_db;
		
		$stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_shares WHERE old_feed_id=?"); 
		$stmt->bind_param('i', $this->feed_id);
		$stmt->execute();  
		$stmt->bind_result($totalCount); 
		$stmt->fetch();
		$stmt->close();
		
		if ($totalCount == 1 ){
			return $totalCount .' Share';
		} else if ($totalCount > 1){
			return $totalCount .' Shares';
		} else {
			return "";
		}
		
	}
	
}

class single_feed {
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
	public $feedSharedText;
	public $feedImg;
	public $old_feed_id;
	public $feedTime;
	public $friend_id;
	
	//from users table
	public $f_username;
	
	//from user profiles table
	public $f_fullname;
	public $f_profilePIC;
	
	public $feed;
	
	public function __contstruct(){}
	
	public function feed_id($feed_id){
		global $isv_db,$feed;
		
		$this->user_id = $_SESSION['isv_user_id'];

		$singleFeed = $isv_db->prepare ("SELECT 
			f.id,
			f.user_id,
			f.text_feed,
			f.shared_feed,
			f.img_feed,
			f.old_feed_id,
			f.time,
			f.att_link,
			f.att_title,
			f.att_description,
			f.att_video,
			f.att_image,
			u.username,
			p.fullname,
			p.profile_pic
			FROM feeds f
			JOIN users u ON u.id = f.user_id
			JOIN user_profile p ON p.user_id = u.id
			WHERE f.id=?
		"); 
		
		$singleFeed->bind_param('i', $feed_id);
		$singleFeed->execute(); 
		$singleFeed->store_result(); 
		$resultCount =  $singleFeed->num_rows();
		$singleFeed->bind_result($this->feedID,$this->feedUser,$this->feedText,$this->feedSharedText,$this->feedImg,$this->old_feed_id,$this->feedTime,$attlink,$atttitle,$attdescription,$attvideo,$attimage,$this->f_username,$this->f_fullname,$this->f_profilePIC); 
		$singleFeed->fetch();
		$singleFeed->close();
				$this->feed = array(
					'feed_id' => $this->feedID,
					'feed_user' => $this->feedUser,
					'feed_text' => $this->feedText,
					'feed_shared_text' => $this->feedSharedText,
					'feed_image' => $this->feedImg,
					'old_feed_id' => $this->old_feed_id,
					'feed_time' => $this->feedTime,
					'att_link' => $attlink,
					'att_title' => $atttitle,
					'att_description' => $attdescription,
					'att_video' => $attvideo,
					'att_image' => $attimage,
					'feed_username' => $this->f_username,
					'feed_fullname' => $this->f_fullname,
					'feed_profilePIC' => $this->f_profilePIC
				);
		return $this->feed;
	} 

}