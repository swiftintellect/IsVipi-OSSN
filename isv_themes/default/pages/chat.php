<div class="box-header with-border">
	<h3 class="box-title">Chat with <strong><?php echo $full_name ?></strong></h3>
	<div class="box-tools pull-right">
    	<div class="mailbox-controls">
       		<div class="btn-group">
           		<button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
              	<button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
               	<button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
         	</div><!-- /.btn-group -->
     	</div>
 	</div>
</div>

<div class="box-body no-padding">
	<div class="mailbox-read-message">
		<div class="direct-chat-messages">
        	
			<?php if(is_array($msgs) && !empty($msgs)) foreach ($msgs as $key => $chat) {?>
				<?php if($chat['from_id'] !== $_SESSION['isv_user_id']){?>
                <div class="direct-chat-msg">
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left"><?php echo $chat['fullname'] ?></span>
                        <span class="direct-chat-timestamp pull-right"><?php echo elapsedTime($chat['sent_time']) ?></span>
                    </div><!-- /.direct-chat-info -->
                    <a href="<?php echo ISVIPI_URL .'profile/'.$chat['username'] ?>">
                    <img class="direct-chat-img" src="<?php echo user_pic($chat['profile_pic']) ?>" alt="message user image">
                    </a>
                    <div class="direct-chat-text">
                        <?php echo $chat['message'] ?>
                    </div><!-- /.direct-chat-text -->
                </div><!-- /.direct-chat-msg -->
                <?php } else { ?>                    
                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-timestamp pull-left"><?php echo elapsedTime($chat['sent_time']) ?></span>
                    </div><!-- /.direct-chat-info -->
                    <div class="direct-chat-text bg-blue">
                        <?php echo $chat['message'] ?>
                    </div><!-- /.direct-chat-text -->
                </div><!-- /.direct-chat-msg -->
                <?php } ?>
            <?php } ?>
            
        </div>
   	</div>
</div>
