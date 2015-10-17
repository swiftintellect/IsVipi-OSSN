<?php
	require_once(ISVIPI_CLASSES_BASE .'global/getFriends_cls.php');
	$fr = new get_friends();
	$allFriendsCount = $fr->totalFriends($_SESSION['isv_user_id']);
	$userFriends = $fr->all_friends($_SESSION['isv_user_id'],'online',10);
?>
<?php if($allFriendsCount > 0 ){?>
<div style="margin-top:-20px;">
<?php if(is_array($userFriends)) foreach ($userFriends as $key => $friend_info) {?>
    <div class="friend_sidebar">
        <a href="<?php echo ISVIPI_URL .'profile/'.$friend_info['m_username'] ?>" class="pull-left" data-toggle="tooltip" title="<?php echo $friend_info['m_fullname'] ?>">
            <img class="square-circle" src="<?php echo user_pic($friend_info['m_profile_pic']) ?>" alt="<?php echo $friend_info['m_fullname'] ?>">
        </a>
        <div class="sidebar_friends_spacer"></div>
        <a href="<?php echo ISVIPI_URL .'profile/'.$friend_info['m_username'] ?>" class="username-sidebar-friend"><?php echo $friend_info['m_fullname'] ?></a> <?php echo is_online($friend_info['m_last_activity']) ?>
      <div class="clear"></div>     
    </div>
    <div class="clear"></div>
<?php } ?>
</div>
<?php } else { ?>
    <li class="list-group-item">No friends found.</li>
<?php } ?>