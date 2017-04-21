<?php
	require_once(ISVIPI_CLASSES_BASE .'global/getFriends_cls.php');
	$fr = new get_friends();
	$allFriendsCount = $fr->totalFriends($m_info['m_user_id']);
	$userFriends = $fr->all_friends($m_info['m_user_id'],'online',20);
?>
<?php if($allFriendsCount > 0 ){?>
<?php if(is_array($userFriends)) foreach ($userFriends as $key => $friend_info) {?>
<div class="profile_friend">
    <a href="<?php echo ISVIPI_URL .'profile/'.$friend_info['m_username'] ?>" data-toggle="tooltip" title="<?php echo $friend_info['m_fullname'] ?>">
        <img class="square-circle" src="<?php echo user_pic($friend_info['m_profile_pic']) ?>" alt="<?php echo $friend_info['m_fullname'] ?>">
    </a>
<div class="online_status"><?php echo is_online($friend_info['m_last_activity']) ?></div>
</div>
<?php } ?>
<?php } else { ?>
	<div class="col-md-12" style="margin-bottom:10px">
    	<li class="list-group-item">No friends found.</li>
	</div>
<?php } ?>