<?php 
selectFeed($ACTION[2]); ?>
<?php
$user = $_SESSION['user_id'];
xtractUID($act_user)
?>
    <div id="feed_block">
    	<div class="feed_user_head">
        	<div class='timeline_pic'>
            <?php t_thumb($uid);?>
            <?php if(htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8') == ""){$t_thumb=".gif";}?>
            <div class="member_pic_home">
            <a href="<?php echo ISVIPI_URL.'profile/' ?><?php getUserDetails($uid); echo $username;?>" data-toggle="tooltip" data-placement="top" title="<?php getUserDetails($uid); echo $username;?>"><img src='<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8');?>' height='40' width='40' alt='' /></a>
            </div>
            <div class="homeUserhead"><a href='<?php echo ISVIPI_URL.'profile/' ?><?php echo $username;?>'><?php echo htmlspecialchars($username, ENT_QUOTES, 'utf-8');?></a>
                                    <?php if ($shared !== 0){?>
                                    <div class="shared_txt"><?php echo SHARED ?> <a href="<?php echo ISVIPI_URL.'profile/' ?><?php getUserDetails($shared); echo $username;?>"><?php echo $username; ?>'s</a> <?php echo STATUS ?>
                                    </div>
                                    <?php } ?>
                                    </div>
                                    </div>
                                    <?php if($user == $feedUID){?>
                                    <div class="manage_feed_display_delete">
       <a href="javascript:postFunction('<?php echo encryptHardened('5') ?>','<?php echo $FIDentinty ?>','<?php echo $_SESSION['user_id']?>')" data-toggle="tooltip" data-placement="top" title="<?php echo DELETE.' '.POST ?>"><i class="fa fa-times"></i></a>
                                    </div>
                                    <?php } ?>
                                    <div class="hometime"><span class='time_stamp'><i class="fa fa-clock-o"></i> <?php echo relativeTime($time)?></span></div>
                                    <div style="clear:both"></div>
                                    </div>
                                    <div class='timeline_posts'>
                                        <div class="emoticon">
											<?php echo makeLinks($activity);?><br/>
                                            <?php xtractUID($act_user) ?>
                                        </div>
                                    </div>
                                    <?php if($feedImage !=""){?>
                                    <div class="timeline_img">
                                    <a class="boxer" href="<?php echo ISVIPI_TIMELINE_PICS_URL.$feedImage;?>">
                                    <img src="<?php echo ISVIPI_TIMELINE_PICS_URL.$feedImage;?>" width="300"/>
                                    </a>
                                    </div>
                                    <?php } ?>
                                    <hr />
                                    <div style="clear:both"></div>
                                    <div class="feed_options">
                                    <?php $feedposter = $_SESSION['user_id']; ?>
                                    <?php if (hasLiked($FIDentinty,$user)){?>
                                    <span><?php echo YOU_LIKE_THIS ?></span>
                                    <a href="javascript:postFunction('<?php echo encryptHardened('2') ?>','<?php echo $FIDentinty ?>','<?php echo $feedposter?>');"><?php echo UNLIKE ?></a>
                                    <?php } else {?>
                                    <a href="javascript:postFunction('<?php echo encryptHardened('1') ?>','<?php echo $FIDentinty ?>','<?php echo $feedposter?>')"><?php echo LIKE ?></a>
                                    <?php } ?>
                                    <a href="<?php echo $site_url."/remote/share/".$FIDentinty?>" class="boxer" data-boxer-width="500" data-boxer-height="400"><?php echo SHARE ?></a>
                                    <div id="hiddenShareBox" style="display: none;">
                                        <div class="inline_content">
                                        <h4><?php echo SHARE_ON_TIMELINE ?></h4>
                                        <hr />
                                        <p>
                                    <?php echo $FIDentinty ?><br/>
                                    	</p>
                                        
                                    </div>
                                    </div>
                                    </div>
                                     <div class="feed_option_notices">
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
                                    <div class="manage_feed_display">
                            <div id="workingGen" style="float:left; margin-left:-50px; display:none">
                            <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                            </div>
                            <div id="working<?php echo $FIDentinty ?>" style="float:left; margin-left:-50px; display:none">
                                <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                                </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <hr />
                                    <div class="comments_show">
                                    
                                    <div id="slidepanel<?php echo $FIDentinty; ?>">
                                        <form action="<?php echo ISVIPI_URL. 'users/processFeed/'?>" method="post" id="commentBoxSingle">
                                    <?php t_thumb($user);?>
                                    <?php if(htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8') == ""){$t_thumb=".gif";}?>
                                    <div class="comment_thumb">
                                    <a href="<?php echo ISVIPI_URL.'profile/' ?><?php getUserDetails($user); echo $username;?>" data-toggle="tooltip" data-placement="top" title="<?php getUserDetails($user); echo $username;?>"><img src='<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8');?>' height='40' width='40' alt='' /></a>
                                    </div>
                                        <textarea class="form-control common" name="comment_reply" id="coMMentArea" placeholder="<?php echo N_PLEASE_TYPE_COMM;?>" required="required"></textarea>
                                        <input type="hidden" name="feed_identity" value="<?php echo $FIDentinty; ?>" />
                                        <input type="hidden" name="userid" value="<?php echo $user; ?>" />
                                        <input type="hidden" name="action" value="4" />
                                        <input type="submit" class="btn btn-primary btn-xs pull-right" value="<?php echo COMMENT ?>" id="CommSubMButt" />
                                        <div style="clear:both"></div>
                                        </form>
                                        
                                        <!--//end of comment form submit-->
                                        </div>
                                        <div class="comment_display_container">
									<?php getComments ($FIDentinty) ?>
                                    <?php while ($getComm->fetch()) {
										?>
                                    <div class="comments_display_block">
                                    <?php t_thumb($feedCommentBy);?>
                                    <?php if(htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8') == ""){$t_thumb=".gif";}?>
                                    <div class="member_pic_home_comment"><a href="<?php echo ISVIPI_URL.'profile/' ?><?php getUserDetails($feedCommentBy); echo $username;?>" data-toggle="tooltip" data-placement="top" title="<?php getUserDetails($feedCommentBy); echo $username;?>"><img src='<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8');?>' height='35' width='35' alt='' /></a></div>
                                    <div class="actual_comment"><?php echo $feedComment ?></div>
                                    <div style="clear:both"></div>
                                    <div class="like_comment">
                                    <div class="like_comment_count">
                                    <?php AllCommentsLikes($FeedCommentID)?>
                                    <?php if ($allCommsLike == 1){?>
                                    <?php echo $allCommsLike ?> <?php echo LIKES_THIS ?>
                                    <?php } else if ($allCommsLike > 1){?>
                                    <?php echo $allCommsLike ?> <?php echo LIKE_THIS ?>
                                    <?php } ?>
                                    </div>
                           <div id="save<?php echo $FeedCommentID ?>" style="margin-right:5px; display:none; float:left">
                                        <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="10" />
                                        </div>
                                    <?php hasLikedComment($FeedCommentID,$user) ?>
                                    <?php if ($haslikedComm > 0){ ?>
                                    <a href="javascript:postSingCommentFunction('<?php echo encryptHardened('7') //action?>','<?php echo $FIDentinty //feed id?>','<?php echo $FeedCommentID //comment id ?>');"><?php echo UNLIKE ?></a>
                                    <?php } else { ?>
                                    <a href="javascript:postSingCommentFunction('<?php echo encryptHardened('6')//action ?>','<?php echo $FIDentinty //feed id?>','<?php echo $FeedCommentID //comment id?>')"><?php echo LIKE ?></a>
                                    <?php }?>
                                    <?php if ($user == $feedCommentBy || $user == $feedUID){?>
                                    <a href="javascript:postSingCommentFunction('<?php echo encryptHardened('8')//action ?>','<?php echo $FeedCommentID //feed id?>','<?php echo $FeedCommentID //comment id?>')"><?php echo DELETE ?></a>
                                    <span class="comment_tyme"><i class="fa fa-clock-o"></i> <?php echo relativeTime($commentTime) ?> </span>
                      
                                    <?php } ?>
                                    
                                    </div>
                                    <div style="clear:both"></div>
                                    </div>
                                    <?php  } ?>
                                    
                                    </div>
                                    </div>
                                    </div>
                        <script>
						$(".boxer").boxer();
						$("[data-toggle='tooltip']").tooltip();
						//LoadTimeline();
					  </script>
                      <script>
						$(document).ready(function() { 
						$('#commentBoxSingle').ajaxForm(function() {
						$('#commentBoxSingle').resetForm();
						$("#workingGen").show(); 
						LoadSingTimeline();
						}); 
						}); 
					  </script>
