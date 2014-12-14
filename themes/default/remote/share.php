<?php include_once ISVIPI_THEMES_BASE."remote/shareHead.php";
$fId = $ACTION[2];
$fId = preg_replace('/[^0-9]/','',$fId);
selectFeed($fId);
 ?>
<style type="text/css">
body {overflow:hidden}
.share_inline_content { width: 470px; overflow: hidden; color:#000; margin:2px auto}
.share_inline_content hr {margin:3px}
.share_inline_content h4 {padding:0px; margin:0px}
.share_popup {
	text-align: justify;
	color: #7A7A7A
}
.share_popup .share_popup_content {
	border-left: solid 5px #09F;
	padding: 10px;
	border-top: solid thin #EEEEEE;
	min-height: 180px;
	overflow: hidden;
	background-color: #FBFBFB;
	font-size:12px;
	
}
.share_popup .btn {margin-top:10px;}
.share_popup_user {display:block; color:#999; font-size:13px; height:20px;}
.share_popup_user span {margin-left:20px}
.feed_popupImg {margin:10px 5px auto}
.feed_popupImg img{
	margin: 10px auto;
	border: 2px solid #CCC
}
</style>
<div class="share_inline_content">
	
	<h4><?php echo SHARE_ON_TIMELINE ?></h4>
  <hr />
    <div id="sharedBox">
    <form id="shareUpdate" action="<?php echo ISVIPI_URL. 'users/processFeed/'?>" method="post" >
    <input type="hidden" value="3" name="action" />
    <input type="hidden" value="<?php echo $fId; ?>" name="feedId" />
    
    <div class="form-group">
    <textarea name="myfeed" class="form-control" id="inputField" placeholder="<?php echo SAY_SMTHN ?>"></textarea>
    </div>
    <div style="clear:both"></div>
<div class="share_popup">
<div style="clear:both"></div>
<div style="clear:both"></div>
<div class="share_popup_content emoticon">
<?php if (empty($feedImage)){?>
<?php echo trunc_text($activity,50) ?>
<?php } else {?>
<?php echo trunc_text($activity,20)?>
<center>
<div class="feed_popupImg">
<img src="<?php echo ISVIPI_TIMELINE_PICS_URL.$feedImage;?>" height="150" />
</div>
</center>
</div>
<?php } ?>
</div>
<div id="workingGenPost" style="float:left; margin-left:350px; margin-top:10px; display:none">
<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15"/>
</div>
<hr />
<div class="share_popup_user">
<?php getUserDetails($feedUID); ?>
<i class="fa fa-user"></i> <?php echo $username;?>   
 <span><i class="fa fa-clock-o"></i> <?php echo relativeTime($time);?></span>
</div>
<hr />
<input type="submit" id="submitted" class="btn btn-primary pull-right" value="<?php echo SHARE ?>"/>
</form>

</div>

</div>
<center>
<div id="sharedBoxAfter" style="display:none; width:300px">
<div class="alert alert-success">
<?php echo S_SUCCESS ?>
</div>
</div>
</center>
<?php include_once ISVIPI_THEMES_BASE."remote/shareFoot.php"; ?>