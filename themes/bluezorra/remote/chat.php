<?php
include_once(ISVIPI_THEMES_BASE.'functions.php');
if (!isset($ACTION[2])){
	echo "<span style='margin:20px;'>".SELECT_CONV."</span>";
	exit();
}
xtractUID($ACTION[2]);
getConv($uid,$_SESSION['user_id']);
		if ($convCount < 1){
			echo "<span style='margin:20px;'>".NO_SUCH_CONV."<span>";
			exit();
		} 
?>
<script>
$(document).ready(function() {
	$(".table-responsive").animate({ scrollTop: $(".table-responsive")[0].scrollHeight }, 1000);
}); 
</script> 
<div class="box-body chat" id="chat-box">
<?php 
	while ($geUtmsgs->fetch()){
	//updMsgRead($_SESSION['user_id'],$uniqID);
	sideBarUserDet($user1);
?>
    <div class="item">
    <?php if(empty($s_thumbnail)&& $s_gender == "Male"){
		$s_thumbnail="m_.png";
		}else if(empty($s_thumbnail)&& $s_gender == "Female"){
		$s_thumbnail="f_.png";	
	}?>
    	<img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.$s_thumbnail ?>"/>
        <p class="message">
        <?php getUserDetails($user1); ?>
            <a href="<?php echo ISVIPI_URL.'profile/'.$username ?>" class="name">
                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo relativeTime($timestamp); ?></small>
                <?php echo $username ?>
            </a>
            <?php echo $message;?>
        </p>
    </div> 
<?php } ?>
</div>
