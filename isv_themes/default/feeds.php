                <?php $last_id = 0; if (is_array($feed)) foreach ($feed as $key => $f) { $last_id = $f['feed_id'];
				  	/** get feed properties (likes, comments, shares, if liked, if shared) **/
				  	$feedProperties = new getFeedProperties($f['feed_id']);
				  	
				  ?>
                <div class="box box-widget" style="margin:0;" id="f_content">
                <div class='box-header with-border'>
                  <div class='user-block'>
                    <img class='img-square' src='<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>' alt='user image'>
                    <span class='username'><a href="#"><?php echo $f['feed_fullname'] ?></a></span>
                    <span class='description'><i class="fa fa-clock-o"></i> <?php echo elapsedTime($f['feed_time']) ?></span>
                  </div><!-- /.user-block -->
                  <div class='box-tools'>
                  	<?php if ($f['feed_user'] == $_SESSION['isv_user_id']){?>
                    	<button class='btn btn-box-tool'><i class='fa fa-times'></i></button>
                    <?php } ?>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class='box-body'>
                  <!-- feed text -->
                  <?php if (isset($f['feed_text']) && !empty($f['feed_text'])){?>
                  	<p style="padding-left:10px;"><?php echo $f['feed_text'] ?></p>
                  <?php } ?>
                  <!-- feed image -->
                  <?php if (isset($f['feed_image']) && !empty($f['feed_image'])){?>
                  	<img class="img-responsive pad" src="<?php echo ISVIPI_UPLOADS_URL.'feeds/'.ISVIPI_600.$f['feed_image']?>" alt="feed image">
                  <?php }?>
                  
                  <hr style="margin:5px 0"/>
                  
                  <?php if(isset($f_att)){?>
                  <!-- Attachment -->
                  <div class="attachment-block clearfix">
                    <img class="attachment-img" src="../dist/img/photo1.png" alt="attachment image">
                    <div class="attachment-pushed">
                      <h4 class="attachment-heading"><a href="http://www.lipsum.com/">Lorem ipsum text generator</a></h4>
                      <div class="attachment-text">
                        Description about the attachment can be placed here.
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry... <a href="#">more</a>
                      </div><!-- /.attachment-text -->
                    </div><!-- /.attachment-pushed -->
                  </div><!-- /.attachment-block -->
                  <?php } ?>

                  <div class='text-muted social-count'><?php echo $feedProperties->f_likes_count() ?> &nbsp;&nbsp; <?php echo $feedProperties->f_comment_count() ?> &nbsp;&nbsp; 3 shares</div>
                  <!-- Social sharing buttons -->
                  <?php if(!$feedProperties->hasLiked()) {?>
                  <a href="javascript:void(0)" class="feed-action" onclick="feedAction(<?php echo $f['feed_id'] ?>, 'like');"><i class='fa fa-thumbs-o-up'></i> Like</a>
                  <?php } else {?>
                  <a href="javascript:void(0)" class="feed-action" onclick="feedAction(<?php echo $f['feed_id'] ?>, 'unlike');">Unlike</a>
                  <?php } ?>
                  <a href="javascript:void(0)" class="feed-action"><i class='fa fa-share'></i> Share</a>
                  
                  <div id="FAction<?php echo $f['feed_id'] ?>" class="processingFAction"><i class="fa fa-spinner fa-pulse"></i></div>
				  <div id="FActionComment<?php echo $f['feed_id'] ?>" class="processingFAction"><i class="fa fa-spinner fa-pulse"></i></div>                
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <form action="<?php echo ISVIPI_URL .'p/feeds' ?>" method="post" id="comment<?php echo $f['feed_id'] ?>">
                    <img class="img-responsive img-square img-sm" src="<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>" alt="alt text">
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
                <div class='box-footer box-comments bordered-bottom'>
                  <div class='box-comment'>
                    <!-- User image -->
                    <img class='img-square img-sm' src='<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>' alt='user image'>
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
                  <a href="javascript:void(0)" class="feed-action" onclick="commentAction(<?php echo $c['comm_id'] ?>, 'comm_like');"><i class='fa fa-thumbs-o-up'></i> Like</a>
                  <?php } else {?>
                  <a href="javascript:void(0)" class="feed-action" onclick="commentAction(<?php echo $c['comm_id'] ?>, 'comm_unlike');"><i class='fa fa-thumbs-o-up'></i> Unlike</a>
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
                            loadTimeline();
                        }, 2000);
                    }); 
                });
                </script>

              <?php } ?>
              

