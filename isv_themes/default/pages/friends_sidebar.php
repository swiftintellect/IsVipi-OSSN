<?php
	require_once(ISVIPI_CLASSES_BASE .'global/getFriends_cls.php');
	$fr = new get_friends();
	$allFriendsCount = $fr->totalFriends($_SESSION['isv_user_id']);
	$userFriends = $fr->all_friends($_SESSION['isv_user_id'],'online',10);
?>
<?php if($allFriendsCount > 0 ){?>
<div style="margin-top:-20px;">
<?php if(is_array($userFriends)) foreach ($userFriends as $key => $friend_info) {  ?>
    <div class="friend_sidebar">
    	<a href="<?php echo ISVIPI_URL . 'profile/'. $friend_info['m_username'] ?>">
    	<li class="list-group-item">
            <img class="square-circle" src="<?php echo user_pic($friend_info['m_profile_pic']) ?>" width="100%" alt="<?php echo $friend_info['m_fullname'] ?>">
        <?php echo $friend_info['m_fullname'] ?> 
		<div class="pull-right text-blue" style="margin-top:10px;"><?php echo is_online($friend_info['m_last_activity']) ?></div>
	  
      <div class="clear"></div>   
      </li>  
      </a>
    </div>
    <div class="clear"></div>
<?php } ?>
</div>
<?php } else { ?>
    <li class="list-group-item">No friends found.</li>
<?php } ?>