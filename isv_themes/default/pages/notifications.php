              <!-- Friend requests-->
              <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-user-plus notify-md"></i>
                  <?php if(user_friend_requests_count($_SESSION['isv_user_id']) > 0 ){?>
                      <span class="label label-danger notify-md-label">
                        <?php echo user_friend_requests_count($_SESSION['isv_user_id']) ?>
                      </span>
                  <?php } ?>
                </a>
                <ul class="dropdown-menu">
                	<?php $f_notices = array_filter(user_friend_req_notices($_SESSION['isv_user_id'],'active',5));
						if(is_array($f_notices) && !empty($f_notices)) foreach ($f_notices as $key => $fn) {
					?>
                  <li style="border-bottom:dotted thin #CCC; padding:5px;">
                    <!-- inner menu: contains the messages -->
                    <ul class="menu" style="background:#F4F4F4">
                      <li><!-- start message -->
                        <div class="notice-holder">
                          <div class="pull-left">
                            <!-- User Image -->
                           <a href="<?php echo ISVIPI_URL .'profile/'.$fn['username'] ?>" data-toggle="tooltip" title="<?php echo $fn['fullname'] ?>">
                            <img src="<?php echo user_pic($fn['profile_pic']) ?>" class="img-square" alt="User Image">
                           </a>
                          </div>
                          <!-- Message title and timestamp -->
							<div class="accept-reject">
                            	<strong><?php echo $lang->translate('friend_request') ?></strong> &nbsp;
                            	<a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_accept').'/'.$converter->encode($fn['id']).'/'.$converter->encode($fn['from_id']) ?>" class="btn bg-green btn-xs btn-flat"><?php echo ucwords($lang->translate('accept')) ?></a>
                                <a href="<?php echo ISVIPI_URL.'p/friends/'.$converter->encode('f_ignore').'/'.$converter->encode($fn['id']) ?>" class="btn bg-red btn-xs btn-flat"><?php echo ucwords($lang->translate('ignore')) ?></a>
                            </div>
                        </div>
                      </li><!-- end message -->
                    </ul><!-- /.menu -->
                  </li>
                  <?php } else {?>
                  <li style="border-bottom:dotted thin #CCC; padding:5px;">
                    <!-- inner menu: contains the messages -->
                    <ul class="menu" style="padding:5px 10px">
                    	<li><?php echo ucfirst($lang->translate('no_friend_request')) ?></li>
                    </ul>
                  </li>
                  <?php } ?>
                  <li class="footer"><a href="<?php echo ISVIPI_URL .'friend_requests' ?>"><?php echo ucwords($lang->translate('view_all')) ?></a></li>
                </ul>
              </li><!-- /.messages-menu -->

              <!-- Messages Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-comments notify-md"></i>
                  <?php if(user_unread_message_count($_SESSION['isv_user_id']) > 0 ){?>
                  	<span class="label label-danger notify-md-label">
						<?php echo user_unread_message_count($_SESSION['isv_user_id']) ?>
                    </span>
                  <?php } ?>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <li><!-- start notification -->
                      <?php if(user_unread_message_count($_SESSION['isv_user_id']) > 0 ){?>
                      <?php $n_msg = array_filter(user_unread_messages($_SESSION['isv_user_id'],5));
							if(is_array($n_msg) && !empty($n_msg)) foreach ($n_msg as $key => $msg) {
					  ?>
                        <a href="<?php echo ISVIPI_URL .'messages/'.$msg['username'] ?>">
                          <i class="fa fa-envelope text-aqua"></i> <?php echo $msg['fullname'] ?> <?php echo ucwords($lang->translate('sent_new_msg')) ?>
                        </a>
                      <?php } ?>
                      <?php } else {?>
                      	<ul class="menu" style="padding:10px; border-bottom:dotted thin #CCC">
                            <li><?php echo ucfirst($lang->translate('no_new_msgs')) ?></li>
                        </ul>
                      <?php } ?> 
                      </li><!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="<?php echo ISVIPI_URL .'messages/' ?>"><?php echo ucwords($lang->translate('view_all')) ?></a></li>
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
                	<?php $feed_notices = array_filter(user_feed_notices($_SESSION['isv_user_id'],'active',5));
						if(is_array($feed_notices) && !empty($feed_notices)) foreach ($feed_notices as $key => $feed_n) {
					?>
                  <li style="border-bottom:dotted thin #CCC; padding:5px;">
                    <!-- inner menu: contains the messages -->
                    <ul class="menu" style="background:#F4F4F4">
                      <li><!-- start message -->
                        <div class="notice-holder">
                          <div class="pull-left">
                            <!-- User Image -->
                           <a href="<?php echo ISVIPI_URL .'profile/'.$feed_n['username'] ?>" data-toggle="tooltip" title="<?php echo $feed_n['fullname'] ?>">
                            <img src="<?php echo user_pic($feed_n['profile_pic']) ?>" class="img-square" alt="User Image">
                           </a>
                          </div>
							<div class="accept-reject">
                            	<strong><?php echo $feed_n['notice'] ?></strong> &nbsp;
                            	<a href="<?php echo ISVIPI_URL .'post/'.$converter->encode($feed_n['feed_id']) ?>"><?php echo ucwords($lang->translate('post')) ?></a>
                            </div>
                        </div>
                      </li><!-- end message -->
                    </ul><!-- /.menu -->
                  </li>
                  <?php } else {?>
                  	<li style="border-bottom:dotted thin #CCC; padding:5px;">
                    <!-- inner menu: contains the messages -->
                    <ul class="menu" style="padding:5px 10px">
                    	<li><?php echo ucfirst($lang->translate('no_new_notifs')) ?></li>
                    </ul>
                  </li>
                  <?php } ?>
                  <li class="footer"><a href="<?php echo ISVIPI_URL .'feed_notifications' ?>"><?php echo ucwords($lang->translate('view_all')) ?></a></li>
                </ul>
              </li>
