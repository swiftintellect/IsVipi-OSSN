<?php $user = $_SESSION['user_id']; 
	//get pending friend requests
	pendingFReq($user);
	//get new (unread) messages
	newMsgs($user);
	//get unseen site notifications
	getUnseenNotices($user);
?>
                    <ul class="nav navbar-nav">
                        <!-- Friend Requests-->
                        <li class="dropdown messages-menu" id="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-users"></i>
                                <!-- show if there are any unconfirmed friend requests -->
                                <?php if ($pendreq > 0){?>
                                <span class="label label-success"><?php echo $pendreq ?></span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu">
                            	<?php if ($pendreq > 0){?>
                                <li class="header"><?php echo YOU_HAVE ?> <?php echo $pendreq ?> <?php echo F_REQUESTS ?></li>
                                <?php } else {?>
                                <li class="header"><?php echo NO_F_REQUESTS ?></li>
                                <?php } ?>
                                <?php if ($pendreq > 0){
									while ($chkusr->fetch()){
										getUserDetails($pen_from);
										getMemberDet($pen_from);
									?>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu" style="max-height:250px; overflow-y:scroll;overflow-x: hidden;">
                                        <li><!-- start message -->
                                            <a href="<?php echo ISVIPI_URL.'friend_requests/' ?>">
                                            <?php if(empty($m_thumbnail)&& $m_gender == "Male"){
												$m_thumbnail="m_.png";
											}else if(empty($m_thumbnail)&& $m_gender == "Female"){
												$m_thumbnail="f_.png";	
											}?>
                                                <div class="pull-left">
                                                
                                                    <img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.htmlspecialchars($m_thumbnail, ENT_QUOTES, 'utf-8');?>" alt=""/>
                                                </div>
                                                <h4>
                                                    <?php echo $username ?>
                                                </h4>
                                                <p><?php echo relativeTime($pen_time) ?></p>
                                            </a>
                                        </li><!-- end message -->
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php } ?>
                                <?php if ($pendreq > 3){?>
                                <li class="footer"><a href="<?php echo ISVIPI_URL.'friend_requests/' ?>"><?php echo VIEW_ALL ?></a></li>
                                <?php } else {?>
                                <li class="footer"><a href="<?php echo ISVIPI_URL.'friend_requests/' ?>"><?php echo VIEW_F_REQUESTS ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <!-- Messages -->
                        <li class="dropdown notifications-menu" id="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <?php if ($newmsg >0){?>
                                <span class="label label-warning"><?php echo $newmsg ?></span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu">
                            	<?php if ($newmsg >0){?>
                                
                                <li class="header"><?php echo YOU_HAVE ?> <?php echo $newmsg ?> <?php echo UNREAD_MSGS ?></li>
                                
								<?php } else {?>
                                
                                <li class="header"><?php echo NO_UNREAD_MSGS ?></li>
                                <?php } ?>
                                <?php if ($newmsg > 0){?>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu" style="max-height:250px; overflow-y:scroll;overflow-x: hidden;">
                                    	<?php if ($newmsg >0){
											while ($chkunR->fetch()){
												getUserDetails($unUser1);
										?>
                                        <li style="margin-bottom:10px;">
                                            <a href="<?php echo ISVIPI_URL.'messages/'.$username ?>" style="font-size:14px; color:#000; padding:10px 5px;">
                                                <i class="ion ion-ios7-people info"></i> 
                                                <span class="label label-success"><i class="fa fa-envelope" style="font-size:12px"></i></span> 
                                                <?php echo MSG_FROM ?> <strong><?php echo $username ?></strong>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php } ?>
                                        

                                    </ul>
                                </li>
                                <li class="footer"><a href="<?php echo ISVIPI_URL.'messages/' ?>"><?php echo VIEW_ALL ?></a></li>
                                <?php } else {?>
                                <li class="footer"><a href="<?php echo ISVIPI_URL.'messages/' ?>"><?php echo GO_TO_INBOX ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <!-- Notifications -->
                        <li class="dropdown tasks-menu" id="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-globe"></i>
                                <?php if ($noticesno >0){?>
                                <span class="label label-danger"><?php echo $noticesno ?></span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu">
                            	<?php if ($noticesno >0){?>
                                <li class="header"><?php echo YOU_HAVE ?> <?php echo $noticesno ?> <?php echo NOTIFICATIONS ?></li>
                                <?php } else {?>
                                <li class="header"><?php echo NO_NOTIFICATIONS ?></li>
                                <?php } ?>
                                <?php if ($noticesno >0){
									while ($getnotice->fetch()){
								?>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu" style="max-height:250px; overflow-y:scroll;overflow-x: hidden;">
                                        <li><!-- Task item -->
                                            <a href="<?php echo ISVIPI_URL.'notifications/' ?>">
                                                <h3>
                                                    <?php echo strip_tags($notice) ?>
                                                </h3>
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php } ?>

                                <?php if ($noticesno >0){?>
                                <li class="footer">
                                    <a href="<?php echo ISVIPI_URL.'notifications/' ?>"><?php echo VIEW_ALL ?></a>
                                </li>
                                <?php } else { ?>
                                <li class="footer">
                                	<a href="<?php echo ISVIPI_URL.'notifications/' ?>"><?php echo VIEW_ALL_NOTIFICATIONS ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                      </ul>

