<?php
  class site_stats {
	  
	  public function user_count($status){
		  global $isv_db;
		  
		  if($status === 'all'){
			$query = "WHERE ";
		  } else {
			$query = "WHERE status=$status AND ";  
		  }
		  
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM users $query reg_date > (UTC_TIMESTAMP() - INTERVAL 1 MONTH)"); 
		  $stmt->execute();  
		  $stmt->bind_result($count); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  return $count;
	  }
	  
	  public function user_count_all($status){
		  global $isv_db;
		  
		  if($status === 'all'){
			$query = "";
		  } else {
			$query = "WHERE status=$status";  
		  }
		  
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM users $query"); 
		  $stmt->execute();  
		  $stmt->bind_result($count); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  return $count;
	  }
	  
	  public function member_types($type){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM user_profile WHERE gender=?"); 
		  $stmt->bind_param('s',$type);
		  $stmt->execute();  
		  $stmt->bind_result($count); 
		  $stmt->fetch();
		  $stmt->close();
		 
		 return $count; 
	  }
	  
	  public function feed_stats(){
		  global $isv_db;
		  
		  $feed_st = array();
		  
		  //total feeds
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feeds"); 
		  $stmt->execute();  
		  $stmt->bind_result($Feed_count); 
		  $stmt->fetch();
		  $stmt->close();

		  //total likes
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_likes"); 
		  $stmt->execute();  
		  $stmt->bind_result($like_count); 
		  $stmt->fetch();
		  $stmt->close();	
		  
		  //total comments
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_comments"); 
		  $stmt->execute();  
		  $stmt->bind_result($comments_count); 
		  $stmt->fetch();
		  $stmt->close();	
		  
		  //total shares
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_shares"); 
		  $stmt->execute();  
		  $stmt->bind_result($share_count); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  //total comment likes
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM feed_comment_likes"); 
		  $stmt->execute();  
		  $stmt->bind_result($f_comment_like_count); 
		  $stmt->fetch();
		  $stmt->close();		  
		  
		  $total = $Feed_count + $like_count + $comments_count + $share_count + $f_comment_like_count;
		  //fill in our array
		  $feed_st = array(
		  	'all_feeds' => $Feed_count,
			'all_likes' => $like_count,
			'all_comments' => $comments_count,
			'all_shares' => $share_count,
			'all_comm_likes' => $f_comment_like_count,
			'total' => $total,
					  
		  );
		  
		  return $feed_st;
	  }
	  
	  public function friends_stats(){
		  global $isv_db;
		  
		  $fr = array();
		  
		  //total friend requests
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friend_requests"); 
		  $stmt->execute();  
		  $stmt->bind_result($f_req); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  //total friend requests
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friends"); 
		  $stmt->execute();  
		  $stmt->bind_result($friends); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  //total friend requests ignore
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM friend_requests WHERE status=0"); 
		  $stmt->execute();  
		  $stmt->bind_result($ignored); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  //total blocked
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM users_blocked"); 
		  $stmt->execute();  
		  $stmt->bind_result($blocked); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  //total blocked
		  $stmt = $isv_db->prepare ("SELECT COUNT(*) FROM user_pm"); 
		  $stmt->execute();  
		  $stmt->bind_result($pm); 
		  $stmt->fetch();
		  $stmt->close();
		  
		  $fr = array(
		  	'f_request' => $f_req,
			'friends' => $friends/2,
			'ignored' => $ignored,
			'blocked' => $blocked,
			'pm' => $pm
		  );
		  
		  return $fr;
		  
	  }
	  
	  public function get_latest_members($limit){
		  global $isv_db;
		  
		  $stmt = $isv_db->prepare ("
			SELECT 
				u.username,
				u.reg_date,
				p.fullname,
				p.profile_pic 
			FROM users u
			LEFT JOIN user_profile p ON u.id = p.user_id 
			ORDER BY u.id DESC LIMIT $limit
		"); 
		$stmt->execute(); 
		$stmt->store_result(); 
		$stmt->bind_result($username,$reg_date,$fullname,$ppic); 
		$count = $stmt->num_rows();
		$members = array();
		while($stmt->fetch()){
				$members[] = array(
					'username' => $username,
					'reg_date'  => $reg_date,
					'fullname' => $fullname,
					'profile_pic' => $ppic,
					'count' => $count,
				);
			}
		$stmt->close();
		  //print_r($members); exit();
		  return $members;
	  }
	  
	  public function get_latest_feeds(){
		    $rss = new DOMDocument();
			$rss->load('http://forum.isvipi.org/index.php?action=.xml;type=rss');
			$feed = array();
			foreach ($rss->getElementsByTagName('item') as $node) {
				$item = array ( 
					'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
					'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
					'guid' => $node->getElementsByTagName('guid')->item(0)->nodeValue,
					'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
					);
				array_push($feed, $item);
			}
			
			return $feed;
			/*$limit = 2;
			for($x=0;$x<$limit;$x++) {
				$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
				$link = $feed[$x]['guid'];
				$description = $feed[$x]['desc'];
				$descr = truncate_($description, 20);
				$date = date('l F d, Y', strtotime($feed[$x]['date']));
				echo '<small><em> Posted On '.$date.'</em></small></p>';
				echo '<p><strong><a href="'.$link.'" title="'.$title.'" target="_blank">'.$title.'</a></strong><br />';
				echo '<p>'.$descr.'</p>';
			}*/
		  
	  }
  
  }