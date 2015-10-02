                <?php $last_id = 0; if (is_array($feed)) foreach ($feed as $key => $f) { $last_id = $f['feed_id'];?>
                <div class="box box-widget" style="margin:0;" id="f_content">
                <div class='box-header with-border'>
                  <div class='user-block'>
                    <img class='img-circle' src='<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>' alt='user image'>
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

                  <div class='text-muted social-count'>45 likes &nbsp;&nbsp; 2 comments &nbsp;&nbsp; 3 shares</div>
                  <!-- Social sharing buttons -->
                  <a href="" class="feed-action"><i class='fa fa-thumbs-o-up'></i> Like</a>
                  <a href="" class="feed-action"><i class='fa fa-share'></i> Share</a>
                  
                  
                </div><!-- /.box-body -->
                
                <?php if(isset($comments)){?>
                <div class='box-footer box-comments'>
                  <div class='box-comment'>
                    <!-- User image -->
                    <img class='img-circle img-sm' src='<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>' alt='user image'>
                    <div class='comment-text'>
                      <span class="username">
                        Maria Gonzales
                        <span class='text-muted pull-right'>8:03 PM Today</span>
                      </span><!-- /.username -->
                      It is a long established fact that a reader will be distracted
                      by the readable content of a page when looking at its layout.
                    </div><!-- /.comment-text -->
                  </div><!-- /.box-comment -->
                  
                  <div class='box-comment'>
                    <!-- User image -->
                    <img class='img-circle img-sm' src='<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>' alt='user image'>
                    <div class='comment-text'>
                      <span class="username">
                        Nora Havisham
                        <span class='text-muted pull-right'>8:03 PM Today</span>
                      </span><!-- /.username -->
                      The point of using Lorem Ipsum is that it has a more-or-less
                      normal distribution of letters, as opposed to using
                      'Content here, content here', making it look like readable English.
                    </div><!-- /.comment-text -->
                  </div><!-- /.box-comment -->
                </div><!-- /.box-footer -->
                <?php } ?>
                
                
                <div class="box-footer">
                  <form action="#" method="post">
                    <img class="img-responsive img-circle img-sm" src="<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>" alt="alt text">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                      <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                    </div>
                  </form>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
              <!-- end of timeline feed -->
              <br/>
              <?php } ?>
              

