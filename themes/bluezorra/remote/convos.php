<ul class="nav nav-pills nav-stacked">
<li class="header"><?php echo CHAT_WITH ?></li>
<?php getAllmsgs($_SESSION['user_id']);
	if ($AllmsgCount >0){
		while ($geAllmsgs->fetch()){
		newSingMsg($_SESSION['user_id'],$unique_id);
?>
<?php if ($_SESSION['user_id'] == $msg_from){$msgFrom=$msg_to;} else {$msgFrom=$msg_from;}getUserDetails($msgFrom)?>
<li <?php if(isset ($ACTION[2]) && $ACTION[2] == $username && $newmsgs < 1){ echo "class='active'";} else if (isset ($ACTION[2]) && $ACTION[2] == $username && $newmsgs > 0){ echo "class='new_msg'";} ?>>
<a href="<?php echo ISVIPI_URL.'messages/'.$username?>"><?php echo $username ?> <?php if($newmsgs > 0){?><div class="label label-success" style="margin-left:5px"><?php echo NEW_M ?></div><?php } ?>
</a>
</li>
<?php } ?>
<?php } ?>
