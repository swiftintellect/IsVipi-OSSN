<?php
class feeds {
	private $feedText;
	private $feedImg;
	private $user_id;
	private $feedType;
	private $size;
	private $newName;
	
	public $feedArray;
	
	
	public function __construct($feed,$type){
		$this->feedArray = $feed;
		$this->feedType = $type;
		$this->size = '1000000';
		$maxSize = $this->size / 1000000;
		
		if ($this->feedType == 'text'){

			$this->feedText = $feed;
			
		} else if ($this->feedType == 'img'){
			$this->feedImg = $feed['image'];
			$this->feedText = $feed['text'];
			
			$this->newName = $_SESSION['isv_user_id'] . str_replace(' ', '', microtime());
			$this->newName = str_replace('.', '', $this->newName);
			$path = ISVIPI_UPLOADS_BASE .'feeds/';
			
			//check file size
			if ($this->feedImg["size"] > $this->size) {
				 $array['err'] = true;
				 $array['message'] = 'The file is too large. Maximum file size is '.$maxSize.' MB.';
				 echo json_encode($array);
				 exit();
			}
			
			//check file type
			if($this->feedImg["type"] != "image/jpg" && 
				$this->feedImg["type"] != "image/png" && 
				$this->feedImg["type"] != "image/jpeg" && 
				$this->feedImg["type"] != "image/gif" ) {
					$array['err'] = true;
				 	$array['message'] = 'Allowed file types are .jpg .jpeg .png .gif';
				 	echo json_encode($array);
				 	exit();
			}

			
			//require file upload class
			require_once(ISVIPI_CLASSES_BASE .'utilities/class.upload.php');
			
			$newUpload = new Upload($this->feedImg); 
			
			$newUpload->file_new_name_body = '600x600_'.$this->newName;
		    $newUpload->image_resize = true;
		    $newUpload->image_convert = 'jpg';
		    $newUpload->image_x = 600;
		    $newUpload->image_ratio_y = true;
		    $newUpload->Process($path);
			
			$newUpload->file_new_name_body = '150x150_'.$this->newName;
			$newUpload->image_resize = true;
		    $newUpload->image_convert = 'jpg';
		    $newUpload->image_x = 250;
		    $newUpload->image_ratio_y = true;
		    $newUpload->Process($path);
			
		    if (!$newUpload->processed) {
				 $array['err'] = true;
				 $array['message'] = 'An error occurred: '.$newUpload->error.'';
				 echo json_encode($array);
				 exit();
		    }
			$newUpload->Clean();
			
		}
		
		/** add our feed to the database **/
		$this->addFeed();
		
		/** return success **/
		$array['err'] = false;
		echo json_encode($array);
		exit();
	}
	
	private function addFeed(){
		global $isv_db;
		if (!isset($this->newName) || empty($this->newName)){
			$newName = '';
		} else {
			$newName = $this->newName.'.jpg';
		}
			$stmt = $isv_db->prepare("INSERT INTO feeds (user_id,text_feed,img_feed,time) VALUES (?,?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('iss',$_SESSION['isv_user_id'], $this->feedText,$newName);
			$stmt->execute();
			$stmt->close();
	}
}

class feedActions {
	private $feed_id;
	private $feed_user;
	private $me;
	private $notice;
	private $comment;
	private $comm_id;
	
	public function __construct(){}
	
	/******************************
	__________ LIKE ______________
	
	******************************/
	
	public function like($feedID){
		global $isv_db;
		$this->feed_id = $feedID;
		$this->me = $_SESSION['isv_user_id'];
		
		//first check if this feed exists and check if already liked
		if (($this->feedExists($this->feed_id)) && ($this->feedLikeNotExists($this->feed_id,$this->me))){
		
			//save in the db
			$stmt = $isv_db->prepare("INSERT INTO feed_likes (user_id,feed_id,time) VALUES (?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('ii',$this->me,$this->feed_id);
			$stmt->execute();
			$stmt->close();
			
			//notify feed owner
			global $feed_user;
			$this->notice = 'liked your';
			$this->notifyFeedOwner($this->me,$feed_user,$this->feed_id,$this->notice);
		}
	}
	
	/******************************
	__________ UNLIKE _____________
	
	******************************/
	
	public function unlike($feedID){
	global $isv_db;
	$this->feed_id = $feedID;
	$this->me = $_SESSION['isv_user_id'];
		
	//first check if this feed exists and check if already liked
	if (($this->feedExists($this->feed_id)) && (!$this->feedLikeNotExists($this->feed_id,$this->me))){
		//save in the db
		$stmt = $isv_db->prepare("DELETE FROM feed_likes WHERE user_id=? AND feed_id=?");
		$stmt->bind_param('ii',$this->me,$this->feed_id);
		$stmt->execute();
		$stmt->close();
		}
	}
	
	/******************************
	__________ COMMENT ____________
	
	******************************/
	
	public function addComment($comment,$feedID){
		global $isv_db;
		
		$this->comment = $comment;
		$this->feed_id = $feedID;
		$this->me = $_SESSION['isv_user_id'];
		
		//check if feed exists -> do nothing if it doesnt exist
		if(!$this->feedExists($this->feed_id)){
			//do nothing
		}
		
		//save comment
		$stmt = $isv_db->prepare("INSERT INTO feed_comments (user_id,feed_id,feed_comment,time) VALUES (?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('iis',$this->me,$this->feed_id,$this->comment);
		$stmt->execute();
		$stmt->close();
		
		//notify feed owner
		global $feed_user;
		$this->notice = 'commented on your';
		$this->notifyFeedOwner($this->me,$feed_user,$this->feed_id,$this->notice);
	}

	/******************************
	________ COMMENT LIKE _________
	
	******************************/
	public function commentLike($commID){
		global $isv_db;
		
		global $isv_db;
		$this->comm_id = $commID;
		$this->me = $_SESSION['isv_user_id'];
		
		//first check if this feed exists and check if already liked
		if (($this->commentFeedExists($this->comm_id)) && ($this->feedCommLikeNotExists($this->comm_id,$this->me))){
		
			//save in the db
			$stmt = $isv_db->prepare("INSERT INTO feed_comment_likes (user_id,comment_id,time) VALUES (?,?,UTC_TIMESTAMP())");
			$stmt->bind_param('ii',$this->me,$this->comm_id);
			$stmt->execute();
			$stmt->close();
		}
	}
	
	/******************************
	________ COMMENT UNLIKE _________
	
	******************************/
	public function unlikeComment($commID){
	global $isv_db;
	$this->comm_id = $commID;
	$this->me = $_SESSION['isv_user_id'];
		
	//first check if this feed exists and check if already liked
	if (($this->commentFeedExists($this->comm_id)) && (!$this->feedCommLikeNotExists($this->comm_id,$this->me))){
			//save in the db
			$stmt = $isv_db->prepare("DELETE FROM feed_comment_likes WHERE user_id=? AND comment_id=?");
			$stmt->bind_param('ii',$this->me,$this->comm_id);
			$stmt->execute();
			$stmt->close();
		}
	}
	
	
	/******************************
	______ HELPER FUNCTIONS _______
	
	******************************/
	public function feedExists($feedID){
		global $isv_db,$feed_user;
		
		$stmt = $isv_db->prepare("SELECT user_id FROM feeds WHERE id=?");
		$stmt->bind_param('i',$feedID);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($feed_user);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close( );
	}
	
	public function commentFeedExists($commID){
		global $isv_db,$comm_user;
		
		$stmt = $isv_db->prepare("SELECT user_id FROM feed_comments WHERE id=?");
		$stmt->bind_param('i',$commID);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($comm_user);
		$stmt->fetch();
			if($stmt->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close( );
	}
	
	public function feedLikeNotExists($feed_id,$user){
		global $isv_db,$like_id;
		
		$stmt = $isv_db->prepare("SELECT id FROM feed_likes WHERE user_id=? AND feed_id=?");
		$stmt->bind_param('ii',$user,$feed_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($like_id);
		$stmt->fetch();
			if($stmt->num_rows() < 1){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close( );
	}
	
	public function feedCommLikeNotExists($comm_id,$user){
		global $isv_db,$commLike_id;
		
		$stmt = $isv_db->prepare("SELECT id FROM feed_comment_likes WHERE user_id=? AND comment_id=?");
		$stmt->bind_param('ii',$user,$comm_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($commLike_id);
		$stmt->fetch();
			if($stmt->num_rows() < 1){
				return TRUE;
			} else {
				return FALSE;
			}
		$stmt->close( );
	}
	
	public function notifyFeedOwner($userId,$feedOwner,$feed_id,$notice){
		global $isv_db;
		
		//save in the db
		$stmt = $isv_db->prepare("INSERT INTO feed_notices (user_id,feed_owner,feed_id,notice,time) VALUES (?,?,?,?,UTC_TIMESTAMP())");
		$stmt->bind_param('iiis',$userId,$feedOwner,$feed_id,$notice);
		$stmt->execute();
		$stmt->close();
	}
	
	
}