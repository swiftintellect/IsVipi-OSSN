<script>
	$('.chat').scrollTop($('.chat')[0].scrollHeight);
	setInterval(check_msg_id,15000 /* check if any data has changed every 15 seconds */);
</script>

<div class="box-header with-border">
	<h3 class="box-title">Chat with <strong><?php echo $full_name ?></strong></h3>
	<div class="box-tools pull-right">
    	<div class="mailbox-controls">
       		<div class="btn-group">
           		<button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
         	</div><!-- /.btn-group -->
     	</div>
 	</div>
</div>

<div class="box-body chat">
<?php if(is_array($msgs) && !empty($msgs)) foreach ($msgs as $key => $chat) {?>
<div class="item">
	<img src="<?php echo user_pic($chat['profile_pic']) ?>" class="img-square">
 	<p class="message">
    	<a href="<?php echo ISVIPI_URL .'profile/'.$chat['username'] ?>" class="name">
        	<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo elapsedTime($chat['sent_time']) ?></small>
         	<?php echo $chat['fullname'] ?>
      	</a>
        <?php echo $chat['message'] ?><br />
        <?php if(($chat['from_id'] === $_SESSION['isv_user_id']) && !empty($chat['read_time'])){?>
        	<small class="text-muted pull-left" style="display:block">Read <?php echo elapsedTime($chat['read_time']) ?></small>
        <?php } ?>
 	</p>
</div>
<!-- /.item -->
<?php } ?>
</div>
