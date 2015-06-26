<?php
	include_once(ISVIPI_THEMES_BASE.'functions.php');
	$load = 25;
	xtractUID($ACTION[2]);
	myPersonalSettings($uid);
	global $FriendsOnlyComment;
	if ($FriendsOnlyComment == 1 && $_SESSION['user_id'] != $uid){
		if (!checkFriendship($uid,$_SESSION['user_id'])){
			echo FRIENDS_ONLY_COMMENT;
			exit();
		}
	}

	getFeeds($uid,$load); 
	while ($getusrFeed->fetch()) {
	xtractUID($act_user);
	sideBarUserDet($uid);
	GetUsernameOnly($uid);
?>
<ul class="timeline">
<li>
<div class="timeline-item">
<?php if(empty($s_thumbnail)&& $s_gender == "Male"){
	$s_thumbnail="m_.png";
} else if (empty($s_thumbnail)&& $s_gender == "Female"){
	$s_thumbnail="f_.png";	
}?>
<img src='<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.$s_thumbnail ?>' height='40' width='40' alt=''class="t_thumb_img" />
<h3 class="timeline-header"><a href="<?php echo ISVIPI_URL.'profile/'.$usrname.'' ?>"><?php echo $usrname ?></a> 
<?php if ($shared !== 0){?>
<?php echo SHARED ?> <a href="<?php echo ISVIPI_URL.'profile/' ?><?php getUserDetails($shared); echo $username;?>"><?php echo $username; ?>'<?php echo LETTER_S ?></a> <?php echo STATUS ?>
<?php } ?>

</h3>
<span class="time"><i class="fa fa-clock-o"></i> <?php echo relativeTime($time)?></span>
<div class="clear"></div>
<hr style="margin:3px">
<div class="timeline-body">
<?php echo makeLinks($activity);?>
</div>
<?php if($feedImage !=""){?>
<div class="timeline_img">
	<!--<a class="boxer" href="<?php //echo ISVIPI_TIMELINE_PICS_URL.$feedImage;?>">-->
		<img src="<?php echo ISVIPI_TIMELINE_PICS_URL.$feedImage;?>" width="100%"/>
	<!--</a>-->
</div>

<?php } ?>
<div class="clear"></div>
<hr style="margin-bottom:5px">
<div class='timeline-footer'>
<?php $feedposter = $_SESSION['user_id']; ?>
<?php if (hasLiked($FIDentinty,$_SESSION['user_id'])){?>
<span><i class="fa fa-smile-o"></i></span>
<a href ="javascript:postFunction('<?php echo encryptHardened('2') ?>','<?php echo $FIDentinty ?>','<?php echo $feedposter?>');" class=""><?php echo UNLIKE ?></a>
<?php } else {?>
<a href ="javascript:postFunction('<?php echo encryptHardened('1') ?>','<?php echo $FIDentinty ?>','<?php echo $feedposter?>')" class=""><?php echo LIKE ?></a>
<?php } ?>

<a href ="#" class="" id="shareStatus<?php echo $FIDentinty ?>"><?php echo SHARE ?></a>

<?php if($_SESSION['user_id'] == $feedUID){?>
<a href ="javascript:postFunction('<?php echo encryptHardened('5') ?>','<?php echo $FIDentinty ?>','<?php echo $_SESSION['user_id']?>')" class="pull-right">
	<?php echo DELETE ?>
</a>
<?php } ?>
<div class="feed_option_notices2">
	<?php AllLikes($FIDentinty); if ($allLikes >0 ){?>
		<i class="fa fa-thumbs-o-up"></i> <?php echo $allLikes ?>
	<?php } ?>
	<?php AllComments($FIDentinty); if ($allComms > 0){?>
		<i class="fa fa-comment-o"></i> <?php echo $allComms ?>
	<?php } ?>
	<?php AllShares($FIDentinty); if ($allShares > 0){?>
		<i class="fa fa-share"> <?php echo $allShares ?></i>
<?php } ?>
</div>
<div id="working<?php echo $FIDentinty ?>" style="float:right; margin-right:10px; margin-top:-2px; display:none">
	<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
</div>

</div>
<form action="<?php echo ISVIPI_URL. 'users/processFeed/'?>" method="post" id="<?php echo $FIDentinty; ?>" class="comment-form">
	<?php sideBarUserDet($_SESSION['user_id']);?>
    <?php if(empty($s_thumbnail)&& $s_gender == "Male"){
		$s_thumbnail="m_.png";
	} else if (empty($s_thumbnail)&& $s_gender == "Female"){
		$s_thumbnail="f_.png";	
	}?>
	<div class="comment_thumb">
	<a href="<?php echo ISVIPI_URL.'profile/' ?><?php getUserDetails($_SESSION['user_id']); echo $username;?>" data-toggle="tooltip" data-placement="top" title="<?php getUserDetails($_SESSION['user_id']); echo $username;?>">
    <img src='<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.$s_thumbnail ?>' height='40' width='40' alt=''class="t_thumb_img" />
    </a>
	</div>
    <div class="comment_text_area">
	<textarea class="form-control common" name="comment_reply" id="coMMentArea" placeholder="<?php echo N_PLEASE_TYPE_COMM;?>" required></textarea>
    </div>
	<input type="hidden" name="feed_identity" value="<?php echo $FIDentinty; ?>" />
	<input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>" />
	<input type="hidden" name="action" value="4" />
	<input type="submit" class="btn btn-primary btn-xs pull-right" style="margin-right:10px" value="<?php echo COMMENT ?>" id="CommSubMButt" />
    <div id="workingGen<?php echo $FIDentinty?>" style="float:left; margin-left:50px; display:none">
		<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
	</div>
	<div style="clear:both"></div>
</form>
<script>
$( "textarea" ).on({
	mouseenter: function() {
	$('.profile_timeline').timer('stop');
	},
	mouseleave: function() {
	$('.profile_timeline').timer('start');
	},
	click: function() {
	$('.profile_timeline').timer('stop');
	}
});
$( ".timeline-body" ).on({
	mouseenter: function() {
	$('.profile_timeline').timer('stop');
	},
	mouseleave: function() {
	$('.profile_timeline').timer('start');
	},
	click: function() {
	$('.profile_timeline').timer('stop');
	}
});

</script>
<!-- We submit the comment form -->
 	<script>
	$(document).ready(function() { 
	$('#<?php echo $FIDentinty; ?>').ajaxForm(function() {
	$('#<?php echo $FIDentinty; ?>').resetForm();
	$("#workingGen<?php echo $FIDentinty; ?>").show(); 
	LoadTimeline();
	}); 
	}); 
	</script>
</div>
</li>

<div class="comments_section">
<?php getComments ($FIDentinty);
	while ($getComm->fetch()) {
?>
<div class="comment_item"><!-- start of comments -->	
	<?php sideBarUserDet($feedCommentBy);?>
    <?php if(empty($s_thumbnail)&& $s_gender == "Male"){
		$s_thumbnail="m_.png";
	} else if (empty($s_thumbnail)&& $s_gender == "Female"){
		$s_thumbnail="f_.png";	
	}?>
	<div class="thumb">
    	<img src='<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.$s_thumbnail ?>' height='40' width='40' alt=''class="t_thumb_img" />
    </div>
    <div class="comment_time"><i class="fa fa-clock-o"></i> <?php echo relativeTime($commentTime);?></div>
    <div class="text">
    	<?php echo $feedComment ?>
    </div>
<div class="clear"></div>
<hr style="margin:5px 0;">
<?php hasLikedComment($FeedCommentID,$_SESSION['user_id']) ?>
<?php if ($haslikedComm > 0){ ?>
<span><?php echo YOU_LIKE_THIS ?></span>
<a href="javascript:postCommentFunction('<?php echo encryptHardened('7') //action?>','<?php echo $FIDentinty //feed id?>','<?php echo $FeedCommentID //comment id ?>');"><?php echo UNLIKE ?></a>
<?php } else { ?>
<a href="javascript:postCommentFunction('<?php echo encryptHardened('6')//action ?>','<?php echo $FIDentinty //feed id?>','<?php echo $FeedCommentID //comment id?>')"><?php echo LIKE ?></a>
<?php }?>
<?php if ($_SESSION['user_id'] == $feedCommentBy || $_SESSION['user_id'] == $feedUID){?>
<a href="javascript:postCommentFunction('<?php echo encryptHardened('8')//action ?>','<?php echo $FeedCommentID //feed id?>','<?php echo $FeedCommentID //comment id?>')"><?php echo DELETE ?></a>
<?php } ?>
<div id="processing<?php echo $FeedCommentID ?>" style="float:right; margin-right:10px; margin-top:-2px; display:none">
	<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
</div>
</div>
<?php } ?><!-- closing of comments loop -->
</div>

</ul>
<!------ share user status -->
                 <div style="display: none; width:400px" id="shareUserStatus<?php echo $FIDentinty ?>">
                 <?php selectFeed($FIDentinty); ?>
                 	<form id="shareUpdate" action="<?php echo ISVIPI_URL. 'users/processFeed/'?>" method="post" >
                  		<input type="hidden" value="3" name="action" />
                        <input type="hidden" value="<?php echo $FIDentinty; ?>" name="feedId" />
                        <div class="form-group">
                        <textarea id="message" style="width:400px" rows="3" name="myfeed" required placeholder="<?php echo SAY_SMTHN ?>"></textarea>
                        </div>
                        <p style="padding:5px; width:400px;">
                        <?php if (empty($feedImage)){?>
                        <div class="well" style="padding:5px; font-size:13px; width:400px">
						<?php echo trunc_text($activity,50) ?>
                        </div>
                        <?php } else {?>
                        <?php echo trunc_text($activity,20)?>
                        </p>
                        <center>
                        <div class="share_img">
                        <img src="<?php echo ISVIPI_TIMELINE_PICS_URL.$feedImage;?>" width="100%" />
                        </div>
                        </center>
                        <?php } ?>
                     	<button type="submit" class="btn btn-primary" style="margin-top:5px; display:block">
							<?php echo SHARE ?>
                        </button>
                 	</form>
                 </div>
<script>
$('#shareStatus<?php echo $FIDentinty ?>').jBox('Modal', {
title: 'Share Status',
animation: 'zoomIn',
content: $('#shareUserStatus<?php echo $FIDentinty ?>')
});
</script>

<?php } ?><!-- closing of timeline loop -->
