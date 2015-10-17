              <!-- Friend requests-->
              <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-user-plus notify-md"></i>
                  <?php if(user_friend_requests_count($_SESSION['isv_user_id']) > 0 ){?>
                      <span class="label label-success notify-md-label">
                        <?php echo user_friend_requests_count($_SESSION['isv_user_id']) ?>
                      </span>
                  <?php } ?>
                </a>
                <ul class="dropdown-menu">
                	<?php $f_notices = array_filter(user_friend_req_notices($_SESSION['isv_user_id']));
						if(is_array($f_notices) && !empty($f_notices)) foreach ($f_notices as $key => $fn) {
					?>
                  <li style="border-bottom:dotted thin #CCC; padding:5px;">
                    <!-- inner menu: contains the messages -->
                    <ul class="menu" style="background:#F4F4F4">
                      <li><!-- start message -->
                        <div class="notice-holder">
                          <div class="pull-left">
                            <!-- User Image -->
                            <img src="<?php echo user_pic($fn['profile_pic']) ?>" class="img-square" alt="User Image">
                          </div>
                          <!-- Message title and timestamp -->
							<div class="accept-reject">
                            	<strong>friend request</strong> &nbsp;
                            	<a href="" class="btn bg-green btn-xs btn-flat">Accept</a>
                                <a href="" class="btn bg-red btn-xs btn-flat">Ignore</a>
                            </div>
                        </div>
                      </li><!-- end message -->
                    </ul><!-- /.menu -->
                  </li>
                  <?php } ?>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li><!-- /.messages-menu -->

              <!-- Messages Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-comments notify-md"></i>
                  <span class="label label-warning notify-md-label">2</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <li><!-- start notification -->
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li><!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks Menu -->
              <li class="dropdown tasks-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-globe notify-md"></i>
                  <?php if(user_feed_notices_count($_SESSION['isv_user_id']) > 0){?>
                  	<span class="label label-danger notify-md-label">
						<?php echo user_feed_notices_count($_SESSION['isv_user_id']) ?>
                    </span>
                  <?php } ?>
                </a>
<ul class="dropdown-menu">
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                    
                    <?php $f_notices = array_filter(user_friend_req_notices($_SESSION['isv_user_id']));
						if(is_array($f_notices) && !empty($f_notices)) foreach ($f_notices as $key => $fn) {
					?>
                      <li><!-- start notification -->
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> <?php echo $fn['fullname'].' sent you a friend request' ?>
                        </a>
                      </li><!-- end notification -->
                      <?php } else {?>
                      <ul>
                      	<p style="padding:5px 10px;">No friend requests found</p>
                      </ul>
					  <?php } ?>
                      
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
