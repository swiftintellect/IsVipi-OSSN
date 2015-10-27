				 <?php if (is_array($feed)) foreach ($feed as $key => $f) {
					/** get feed properties (likes, comments, if liked) **/
				  	$feedProperties = new getFeedProperties($f['feed_id']);
					
					/** get share properties **/
					$fSharePropeties = new getShares($f['feed_id']);
					$sh = $fSharePropeties->isSharedFeed($f['old_feed_id']);
				  ?>
                  
				   <?php if(
                        ($_SESSION['isv_user_id'] === $f['feed_user']) /* if profile owner */||
						($_SESSION['isv_user_id'] !== $f['feed_user'] && $f['feed_settings'] === 2) /* if everyone */ ||
						($_SESSION['isv_user_id'] !== $f['feed_user'] && $f['feed_settings'] === 1 
						&& $friends->are_friends($_SESSION['isv_user_id'],$f['feed_user'])) /* if only friends */
						
                    ){ ?>
                <div class="box box-widget" style="margin:0;" id="f_content<?php echo $f['feed_id'] ?>">
                <div class='box-header with-border'>
                  <div class='user-block'>
                  <a href="<?php echo ISVIPI_URL .'profile/'.$f['feed_username'] ?>" title="<?php echo $f['feed_fullname'] ?>">
                    <img class='img-square' src='<?php echo user_pic($f['feed_profilePIC']) ?>' alt='<?php echo $f['feed_fullname'] ?> photo update'>
                  </a>
                    <div class='username' style="display:block; font-size:15px;"><a href="<?php echo ISVIPI_URL .'profile/'.$f['feed_username'] ?>" title="<?php echo $f['feed_fullname'] ?>">&nbsp; <?php echo $f['feed_fullname'] ?></a>
                    	<!--check if it is a shared feed and show corresponding details -->
						<?php if (isset($sh['s_id']) && !empty($sh['s_id'])){?>
                        
                        <!-- if sharing own status, show corresponding text -->
						<?php 
							if ($sh['s_from_username'] === $f['feed_username'] && userGender($f['feed_user']) === 'male'){
								$shtxt = "his own";
							} else if ($sh['s_from_username'] === $f['feed_username'] && userGender($f['feed_user']) === 'female'){
								$shtxt = "her own";
							} else {
								$shtxt = "<a href='".ISVIPI_URL."profile/".$sh['s_from_username']."'> ".$sh['s_from_fullname']."</a>'s";
							}
						?>
                        <span class="sharedTtext">shared <?php echo $shtxt ?> <a href="<?php echo ISVIPI_URL .'post/'.$converter->encode($f['old_feed_id']) ?>" title="<?php echo $sh['s_from_fullname'] ?> update">post</a></span>
                        <?php } ?>
                    </div>
                    <span class='description' style="display:block">&nbsp; <i class="fa fa-clock-o"></i> <?php echo elapsedTime($f['feed_time']) ?></span>
                  </div><!-- /.user-block -->
                  <div class='box-tools'>
                  <?php if ($f['feed_user'] == $_SESSION['isv_user_id']){?>
                  <ul class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                      	<a href="javascript:void(0)" onclick="deleteFeed(<?php echo $f['feed_id'] ?>,'delete',<?php echo $f['feed_user'] ?>);">Delete</a>
                      </li>
                    </ul>
                   </ul>
                    <?php } ?>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class='box-body'>
                  <!-- feed text -->
                  <?php if (isset($f['feed_text']) && !empty($f['feed_text'])){?>
                  	<p class="brkn" style="padding-left:10px;"><?php echo $f['feed_text'] ?></p>
                  <?php } ?>
                  
                  <!-- feed image -->
                  <?php if (empty($sh['s_id']) && !empty($f['feed_image'])){?>
                  	<img class="img-responsive pad" src="<?php echo ISVIPI_UPLOADS_URL.'feeds/'.ISVIPI_600.$f['feed_image']?>" alt="<?php echo $f['feed_fullname'] ?> image post">
                  <?php }?>
                  
                  <hr style="margin:5px 0"/>
                  
                  <!-- shared feed -->
                  <?php if(isset($f['feed_shared_text']) && !empty($sh['s_id'])){?>
                  <div class="sh-feed">
                  
                  	<p><?php echo $f['feed_shared_text'] ?></p>
                  
                  <?php if (isset($f['feed_image']) && !empty($f['feed_image'])){?>
                  	<img class="img-responsive pad" src="<?php echo ISVIPI_UPLOADS_URL.'feeds/'.ISVIPI_600.$f['feed_image']?>" alt="image post">
                  <?php }?>
                  </div>
                  <?php } ?>
                  
                  <!--show social counter if at least one of them is provided -->
				  <?php if(!empty($feedProperties->f_likes_count()) || !empty($feedProperties->f_comment_count()) || !empty($fSharePropeties->totalFeedShares())){?>
                  <div class='text-muted social-count'><?php echo $feedProperties->f_likes_count() ?> <?php echo $feedProperties->f_comment_count() ?> <?php echo $fSharePropeties->totalFeedShares() ?></div>
                  <?php } ?>
                  <!-- Social sharing buttons -->
                  <?php if(!$feedProperties->hasLiked()) {?>
                  <a href="javascript:void(0)" class="feed-action" onclick="feedAction(<?php echo $f['feed_id'] ?>,'like',<?php echo $f['feed_user'] ?>);"><i class='fa fa-thumbs-o-up'></i> Like</a>
                  <?php } else {?>
                  <a href="javascript:void(0)" class="feed-action" onclick="feedAction(<?php echo $f['feed_id'] ?>,'unlike',<?php echo $f['feed_user'] ?>);">Unlike</a>
                  <?php } ?>
                  <a href="javascript:void(0)" class="feed-action" data-toggle="modal" data-target="#share<?php echo $f['feed_id'] ?>"><i class='fa fa-share'></i> Share</a>
                  
                  <div id="FAction<?php echo $f['feed_id'] ?>" class="processingFAction"><i class="fa fa-spinner fa-pulse"></i></div>
				  <div id="FActionComment<?php echo $f['feed_id'] ?>" class="processingFAction"><i class="fa fa-spinner fa-pulse"></i></div>                
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <form action="<?php echo ISVIPI_URL .'p/feeds' ?>" method="post" id="comment<?php echo $f['feed_id'] ?>">
                    <img class="img-responsive img-square img-sm" src="<?php echo user_pic($memberinfo['profile_pic']) ?>" alt="alt text">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                      <input type="text" name="comment" class="form-control input-sm" placeholder="Press enter to post comment">
                    </div>
                    
                    <input type="hidden" name="f_id" value="<?php echo $f['feed_id'] ?>" />
                    <input type="hidden" name="isv_op" value="new-comment" />
                  </form>
                </div><!-- /.box-footer -->
                
                <?php if($feedProperties->f_comment_count() > 0){
					/** instantiate comments **/
					$getComments = new getComments($f['feed_id']);
					$allComments = $getComments->allComments();
					
					foreach ($allComments as $key => $c) {
				?>
                <div class='box-footer box-comments bordered-bottom' id="comBox<?php echo $c['comm_id'] ?>">
                  <div class='box-comment'>
                    <!-- User image -->
                    <a href="<?php echo ISVIPI_URL .'profile/'.$c['comm_username'] ?>">
                    <img class='img-square img-sm' src='<?php echo user_pic($c['comm_profilepic']) ?>' alt='user image'>
                    </a>
                    <div class='comment-text'>
                      <span class="username">
                      <a href="<?php echo ISVIPI_URL .'profile/'.$c['comm_username'] ?>">
                        <?php echo $c['comm_fullname'] ?>
                      </a>
                        <span class='text-muted pull-right'><?php echo elapsedTime($c['comm_time']) ?></span>
                      </span><!-- /.username -->
                      <?php echo $c['comment'] ?>
                    </div><!-- /.comment-text -->
                  </div><!-- /.box-comment -->
                 <?php if (!$getComments->hasLikedComment($c['comm_id'])){?>
                  <a href="javascript:void(0)" class="feed-action" onclick="commentAction(<?php echo $c['comm_id'] ?>,'comm_like',<?php echo $f['feed_user'] ?>);"><i class='fa fa-thumbs-o-up'></i> Like</a>
                  <?php } else {?>
                  <a href="javascript:void(0)" class="feed-action" onclick="commentAction(<?php echo $c['comm_id'] ?>,'comm_unlike',<?php echo $f['feed_user'] ?>);"><i class='fa fa-thumbs-o-up'></i> Unlike</a>
                  <?php } ?>
                  <!-- only the owner of the comment or the owner of the post can delete a comment -->
                  <?php if ($c['comm_user_id'] === $_SESSION['isv_user_id']){?>
                  <a href="javascript:void(0)" class="feed-action pull-right" onclick="deleteComment(<?php echo $c['comm_id'] ?>,'comm_del',<?php echo $f['feed_user'] ?>);"> Delete</a>
                   <?php } ?>
                   <div class="comm_like_count"><?php echo $getComments->totalCommentLikes($c['comm_id']) ?></div>
                  <div id="CAction<?php echo $c['comm_id'] ?>" class="processingFAction"><i class="fa fa-spinner fa-pulse"></i></div>
                  
                </div><!-- /.box-footer -->
                
                <?php } ?>
                <?php } ?>
              </div><!-- /.box -->
              <!-- end of timeline feed -->
              <br/>
              
              <!-- COMMENT -->
              <script>
                $(document).ready(function() { 
                    $('#comment<?php echo $f['feed_id'] ?>').ajaxForm(function() { 
                        $('#FActionComment<?php echo $f['feed_id'] ?>').css('display','inline-block');
                        setTimeout(function(){
                            $('#comment<?php echo $f['feed_id'] ?>').resetForm();
                            $('#comment<?php echo $f['feed_id'] ?>').clearForm();
                            $('#FActionComment<?php echo $f['feed_id'] ?>').css('display','none');
                            loadWall(<?php echo $f['feed_user'] ?>);
                        }, 2000);
                    }); 
                });
                </script>
                
                <!-- Share -->
                <div class="modal fade" id="share<?php echo $f['feed_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="shareFeed">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Share this Status</h4>
                      </div>
                      <form action="<?php echo ISVIPI_URL .'p/feeds' ?>" method="POST">
                      <div class="modal-body">
                          <div class="box box-widget" style="margin:0; border:none !important; padding:0">
                          	<div class="box-body">
                            <textarea name="feed" class="form-control no-bottom-border" rows="2" placeholder="Say something about this"  ></textarea>
                              <!-- shared feed -->
							  <?php if(isset($f['feed_shared_text']) && !empty($sh['s_id'])){?>
                              <div class="sh-block2">
                              <div class='user-block' style="margin-bottom:5px;">
                                <span class='username2' style="display:block"><a href="#"><?php echo $sh['s_from_fullname'] ?></a></span>
                              </div><!-- /.user-block -->
                              
                                <p><?php echo $f['feed_shared_text'] ?></p>
                                                              
                              <?php if (isset($f['feed_image']) && !empty($f['feed_image'])){?>
                                <img class="img-responsive pad" src="<?php echo ISVIPI_UPLOADS_URL.'feeds/'.ISVIPI_600.$f['feed_image']?>" alt="image post">
                              <?php }?>
                              </div>
                              <input type="hidden" name="f_id" value="<?php echo $sh['s_old_feed_id'] ?>" />
                              <?php } else {?>
                              
                              <!-- feed image -->
                              <?php if (isset($f['feed_image']) && !empty($f['feed_image'])){?>
                                <img class="img-responsive pad" src="<?php echo ISVIPI_UPLOADS_URL.'feeds/'.ISVIPI_600.$f['feed_image']?>" alt="feed image">
                              <?php }?>
                              <!-- feed text -->
							  <?php if (isset($f['feed_text']) && !empty($f['feed_text'])){?>
                              <div class="sh-block">
                              	<div class='user-block' style="margin-bottom:5px;">
                                <span class='username2' style="display:block"><a href="#"><?php echo $f['feed_fullname'] ?></a></span>
                                <span class='description2 frmt' style="display:block"><?php echo elapsedTime($f['feed_time']) ?></span>
                              </div><!-- /.user-block -->
                                <p class="brkn sh-fd"><?php echo $f['feed_text'] ?></p>
                              </div>
                              <?php } ?>
                              <input type="hidden" name="f_id" value="<?php echo $f['feed_id'] ?>" />
                              <?php } ?>
                            
                            </div>  
                          </div>
                    	  <input type="hidden" name="isv_op" value="share" />
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button> &nbsp;&nbsp;
                        <button type="submit" class="btn btn-primary btn-sm">Share</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

              <?php } else {?>
               		<li class="list-group-item" style="margin-bottom:10px">This user has restricted access to this wall.</li>
              <?php exit();} ?>
			  <?php } ?>
              <?php if($getFeeds->getTotalFeeds($user) < 1){?>
              	<div class="col-md-12" style="margin-bottom:10px">
                    <li class="list-group-item">No posts found.</li>
                </div>
              <?php } ?>
			  