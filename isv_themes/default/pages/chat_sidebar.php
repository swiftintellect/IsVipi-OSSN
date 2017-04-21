<?php require_once(ISVIPI_CLASSES_BASE .'global/getMessages_cls.php'); 
	$chats = new get_messages();
	//$total_chats = $chats->msg_count($_SESSION['isv_user_id']);
	$myChats = array_filter($chats->chat_users($_SESSION['isv_user_id']));
?>
<ul class="nav nav-pills nav-stacked">
    <?php if(is_array($myChats) && !empty($myChats)) foreach ($myChats as $key => $chUser) {?>
	
    
    <li <?php if(isset($PAGE[1]) && $PAGE[1] == $chUser['username'] ){echo "class='active'"; } ?>>
		<a href="<?php echo ISVIPI_URL. 'messages/'.$chUser['username'] ?>">
		<i class="fa fa-comments"></i> 
    	<?php echo $chUser['fullname'] ?>
        
        <?php if(unread_msgs_from($chUser['from_id']) > 0 ){?>
        	<span class="label label-success pull-right"><?php echo unread_msgs_from($chUser['from_id']) ?></span>
        <?php } ?>
      	</a>
   	</li>
    
    
    <?php } else {?>
    	<li class="active" style="padding:10px">
        	No active chats found.
        </li>
    <?php } ?>
</ul>