<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        	<?php if(!is_array(array_filter($m_info)) || empty(array_filter($m_info))){?>
            	<section class="col-lg-9">
                	<div class="box box-solid members">
                    	No such member was found. You could try <a href="<?php echo ISVIPI_URL .'members/' ?>">browsing </a> through our member list to meet new people.	                	
                        </div>
            	</section>
            <?php } else if (is_array($m_info) && !empty($m_info)){?>
            <!-- user profile -->
        	<section class="col-lg-9">
				<div class="box box-solid members">
                	<div class="row">
                    
                    <!-- cover photo goes here -->
                    <div class="col-md-12 cover-photo">
                    
                    <?php if($m_info['m_status'] === 2){?>
                        <div class="prof_sus_notice">
                            This user was suspended. You will not be able to exchange messages.
                        </div>
                    <?php } else if($m_info['m_status'] === 9){?>
                    	<div class="prof_sus_notice">
                            This user's account is scheduled for deletion. You will not be able to exchange messages.
                        </div>
                    <?php } ?>
                    
                    	<img class="" src="<?php echo user_cover_pic($m_info['m_cover_photo']) ?>" alt="cover photo" style="width: 100%;max-height: 100%">
                    <?php if($_SESSION['isv_user_id'] === $m_info['m_user_id']){?>
                        <div class="change-cover-photo">
                            <a href="#" data-toggle="modal" data-target="#cover">Change Cover Photo</a>
                        </div>
                    <?php } ?>
                    </div>
                    
                    <!-- end::cover photo -->
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                    	<!-- Profile Image -->
                          <div class="box profile-pic-box">
                            <div class="box-body box-profile">
                              <img class="profile-user-img img-responsive square-circle" src="<?php echo user_pic($m_info['m_profile_pic']) ?>" alt="User profile picture">
                              <h3 class="profile-username text-center"><?php echo $m_info['m_fullname']; ?></h3>
                              
                              <?php if($_SESSION['isv_user_id'] === $m_info['m_user_id']){?>
                              <a href="#" class="btn btn-warning btn-sm btn-block" data-toggle="modal" data-target="#profilePic"><b>Change Profile Pic</b></a>
                              <a href="<?php echo ISVIPI_URL. 'profile/' .$m_info['m_username'] . '/edit'?>" class="btn btn-primary btn-sm btn-block"><b>Edit Profile</b></a>
                              <?php } ?>
            
                              <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                  <b>Friends</b> <a class="pull-right"><?php echo $m->friendsTotal(number_format($m_info['m_user_id'])) ?></a>
                                </li>
                                <li class="list-group-item">
                                  <b>Member Level</b> <a class="pull-right"><?php echo $m_info['m_level']; ?></a>
                                </li>
                              </ul>
                              
            				  <?php if($_SESSION['isv_user_id'] !== $m_info['m_user_id'] && 
							  !$friends->blocked_users($_SESSION['isv_user_id'],$m_info['m_user_id']) && !$admin->admin_logged_in()){?>
                             
                             <!--check if they are already friends -->
                              	<?php if($friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id'])){?>
                                  <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#unfriend">Unfriend</a>
                              <!-- if not friends, request exists and profile viewer is the sender -->
								<?php } else if(!$friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id']) && $friends->fr_request_exists($_SESSION['isv_user_id'],$m_info['m_user_id']) && $from_id === $_SESSION['isv_user_id']){?>
                                <div class="row prof-fr-opt">
                                  <a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_delete').'/'.$converter->encode($fr_rq_id).'/' ?>" class="btn btn-danger btn-xs btn-flat">Delete Friend Request</a>
                                </div>
                              
                              <!-- if not friends, request exists and profile viewer is the recepient and not ignored -->
								<?php } else if (!$friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id']) && $friends->fr_request_exists($_SESSION['isv_user_id'],$m_info['m_user_id']) && $to_id === $_SESSION['isv_user_id'] && $req_status === 1){?>
                                <div class="row prof-fr-opt">
                                <span class="label label-default">Request Pending</span> 
                                <a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_accept').'/'.$converter->encode($fr_rq_id).'/'.$converter->encode($from_id) ?>" class="btn btn-success btn-xs btn-flat">Accept</a>
                                  <a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_ignore').'/'.$converter->encode($fr_rq_id) ?>" class="btn btn-warning btn-xs btn-flat">Ignore</a> &nbsp;
								</div>
                                
                             <!-- if not friends, request exists and profile viewer is the recepient and ignored -->
								<?php } else if (!$friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id']) && $friends->fr_request_exists($_SESSION['isv_user_id'],$m_info['m_user_id']) && $to_id === $_SESSION['isv_user_id'] && $req_status === 0){?>
                                <div class="row prof-fr-opt">
                                <span class="label label-default">You ignored this request</span> 
                                <a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_accept').'/'.$converter->encode($fr_rq_id).'/'.$converter->encode($from_id) ?>" class="btn btn-success btn-xs btn-flat">Accept</a>
								</div>
							
                            <!-- not friends and no friend request exists -->
								<?php } else if(!$friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id']) && !$friends->fr_request_exists($_SESSION['isv_user_id'],$m_info['m_user_id'])){?>
                                <a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_req').'/'.$converter->encode($m_info['m_user_id']) ?>" class="btn btn-warning btn-sm">Add Friend</a>
                                <?php } ?>
                                <?php if($m_info['m_status'] === 2 || $m_info['m_status'] === 9){?> 
                                	<span class="label label-info">Messaging Disabled</span>
                                <?php } else { ?>
                                  <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#pm"><b>Message</b></a>
                                  <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#block"><b>Block</b></a>
                                <?php } ?>
                              <?php } ?>
                              
                              <!-- show a message if either of the users has blocked the other -->
                              <?php if($friends->blocked_users($_SESSION['isv_user_id'],$m_info['m_user_id']) 
							  && $block_user1 === $m_info['m_user_id']){?>
                                    <li class="list-group-item bg-red">You were blocked by this user</li>
                              <?php } else if($friends->blocked_users($_SESSION['isv_user_id'],$m_info['m_user_id']) 
							  && $block_user1 === $_SESSION['isv_user_id']){?>
                                    <li class="list-group-item">You blocked this user
                                    <hr style="margin:5px 0" />
                                    	<a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_unblock').'/'.$converter->encode($m_info['m_user_id']) ?>" class="btn btn-success btn-xs btn-flat btn-block"><b>Unblock</b></a>
                                    </li>
                              <?php } ?>
                              
                            </div><!-- /.box-body -->
                          </div><!-- /.box -->
                          <!-- end::Profile Image -->
                          
                    </div>
                    <!-- end::col-md-4-->
                    
                    <!-- if you have blocked this user then the profile menu will be hidden from them -->
                    <?php if(!$friends->blocked_users($_SESSION['isv_user_id'],$m_info['m_user_id'])){?>
                    <!-- col-md-8 -->
                    <div class="col-md-8 prof-nav" id="profile-menu">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li <?php if (isset($PAGE[2]) && $PAGE[2] == 'feeds'){?>class="active"<?php } ?>>
                          	<a href="<?php echo ISVIPI_URL. 'profile/' .$m_info['m_username'] . '/feeds'?>">Timeline</a>
                          </li>
                          <li <?php if (isset($PAGE[2]) && $PAGE[2] == 'about'){?>class="active"<?php } ?>>
                          	<a href="<?php echo ISVIPI_URL. 'profile/' .$m_info['m_username'] . '/about'?>">About</a>
                          </li>
                          <li <?php if (isset($PAGE[2]) && $PAGE[2] == 'friends'){?>class="active"<?php } ?>>
                          	<a href="<?php echo ISVIPI_URL. 'profile/' .$m_info['m_username'] . '/friends'?>">Friends</a>
                          </li>
                          <?php if($_SESSION['isv_user_id'] == $m_info['m_user_id']){?>
                          <li <?php if (isset($PAGE[2]) && $PAGE[2] == 'settings'){?>class="active"<?php } ?>>
                          	<a href="<?php echo ISVIPI_URL. 'profile/' .$m_info['m_username'] . '/settings'?>">Settings</a>
                          </li>
                          <?php } ?>
                        </ul>
                    </div>
                    <div class="right-content" id="tWall">
                    <!-- load the user timeline -->
                    <?php if (!isset($PAGE[2]) || (isset($PAGE[2]) && ($PAGE[2] === 'feeds'))){
                    	require_once(ISVIPI_ACT_THEME .'ovr/profile_scripts.php') 
					?>
					<script>
                    	loadWall('<?php echo $m_info['m_user_id'] ?>','<?php echo ISV_FEEDS_TO_LOAD ?>');
                    </script>
                    <!-- function to load more feeds -->
                    <script>
                            $(window).bind('scroll', function() {
                                if($(window).scrollTop() >= $('#tWall').offset().top + $('#tWall').outerHeight() - window.innerHeight) {
                                    
                                    //if we have reached the bottom of the div we show the loading more animation
                                    if(end_reached == "no"){
                                        document.getElementById("load_more").style.display = "block";
                                        
                                        setTimeout(function(){
                                        
                                            //calculate our next number of feeds to load
                                            var newload = feed_limit + feeds_to_load;
                    
                                                loadWall('<?php echo $m_info['m_user_id'] ?>',newload);
                                                document.getElementById("load_more").style.display = "none";
                                        }, 2500);
                                    } else {
                                        document.getElementById("no_more_feeds").style.display = "block";
                                        document.getElementById("load_more").style.display = "none";
                                    }
                                    
                                }
                            });
                          </script>

					<?php } else if (isset($PAGE[2]) && $PAGE[2] === 'edit' && ($m_info['m_user_id'] === $_SESSION['isv_user_id'])) {
						require_once(ISVIPI_ACT_THEME .'pages/edit.php');
					} else if(isset($PAGE[2]) && $PAGE[2] === 'about'){
						require_once(ISVIPI_ACT_THEME .'pages/about.php');
						
					} else if (isset($PAGE[2]) && $PAGE[2] === 'friends'){
						require_once(ISVIPI_ACT_THEME .'pages/friends.php');
					} else if (isset($PAGE[2]) && $PAGE[2] === 'settings' && ($m_info['m_user_id'] === $_SESSION['isv_user_id'])){
						require_once(ISVIPI_ACT_THEME .'pages/settings.php');
					} else { 
						require_once(ISVIPI_ACT_THEME .'ovr/profile_scripts.php');
					?>
                    <div id="tFeeds">
						<script>
                            loadWall('<?php echo $m_info['m_user_id'] ?>','<?php echo ISV_FEEDS_TO_LOAD ?>');
                        </script>
                    </div>
                    <?php } ?>
                    
                    
                    </div>
                    </div>
                    <!-- end::col-md-8 -->
                    <?php } else {?>
                    <div class="col-md-8" style="padding:20px;">
                    	<li class="list-group-item">You cannot view this page.</li>
                    </div>
					<?php } ?>
                    </div>
                </div>
            <div class="clear"></div> 
			</section>
            <!--end::user profile -->
            
            <!-- load our profile page related modals -->
      		<?php require_once(ISVIPI_ACT_THEME .'pages/modals.php') ?>
            <?php } ?>
            
            <!-- online friends -->
            <section class="col-lg-3 friends-sidebar">
            	<div class="box box-solid">
                    <div class="box-header">
                    	<?php require_once(ISVIPI_ACT_THEME .'pages/friends_sidebar.php') ?>
                    </div>
                </div>
            </section>
			
            
            <div class="clear"></div>
            </section>
        
        </section>
        <!-- /.content -->
        
      </div>
      <!-- /.content-wrapper -->
      
      <!-- scripts section -->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>
