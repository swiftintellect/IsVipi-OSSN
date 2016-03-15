<?php if(is_array($msgs) && !empty($msgs)){?>
<script>
	$('.chat').scrollTop($('.chat')[0].scrollHeight);
	setInterval(check_msg_id,15000 /* check if any data has changed every 15 seconds */);
</script>

<div class="box-header with-border chat-header">
	<h3 class="box-title"><strong><?php echo $full_name ?></strong></h3>
	<div class="box-tools pull-right">
    	<div class="mailbox-controls">
       		<div class="btn-group">
           		<ul class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <span class="fa fa-chevron-down"></span>
                    </a>
                    
                    <ul class="dropdown-menu">
                      <li>
                      	<a href="#" data-toggle="modal" data-target="#delete_chat">Delete</a>
                      </li>
                    </ul>
                 </ul>
         	</div><!-- /.btn-group -->
     	</div>
 	</div>
</div>

<div class="box-body chat">
<?php foreach ($msgs as $key => $chat) {?>
<div class="item">
	<img src="<?php echo user_pic($chat['profile_pic']) ?>" class="img-square">
 	<p class="message">
    	<a href="<?php echo ISVIPI_URL .'profile/'.$chat['username'] ?>" class="name">
        	<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo elapsedTime($chat['sent_time']) ?></small>
         	<?php echo $chat['fullname'] ?>
      	</a>
        <?php echo clickable_links($chat['message']) ?><br />
        <?php if(($chat['from_id'] === $_SESSION['isv_user_id']) && !empty($chat['read_time'])){?>
        	<small class="text-muted pull-left" style="display:block">Read <?php echo elapsedTime($chat['read_time']) ?></small>
        <?php } ?>
 	</p>
    	
</div>
<!-- /.item -->
<!-- if the user has been suspended or deleted his/her account -->
<?php if($chat['user_status'] === 2){?>
	<div class="msg-err">
  		This user has been suspended. You will not be able to exchange any messages.
  	</div>
<?php } else if ($chat['user_status'] === 9){?>
	<div class="msg-err">
  		This user's account has been scheduled for deletion. You will therefore not be able to exchange any messages.
  	</div>
<?php } ?>
<?php } ?>

</div>
<?php } else {?>
<div class="box-header with-border">
	<div class="box-body">
    No chat found. You can send this user a message by using the message box below.
    </div>
</div>
<?php } ?>
