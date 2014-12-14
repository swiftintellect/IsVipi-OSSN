                 <!-------------------------
                 --- FRIENDS STATUSES ------
                 -------------------------->
                 <div class="after-ads"><!-- after-ads -->
                 	<div class="row"><!-- row -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                            <?php getMyFriendsSidebar($_SESSION['user_id']);?>
                            	<div class="box-header">
                                    <h4 class="box-title"><?php echo MY_FRIENDS ?></h4>
                                </div>
                                <hr class="no-margin"/>
                                <div class="box-body">
                                <?php while ($getfriends->fetch())
									{
										getMemberDet($id);
										getUserDetails($id);
								?> 
                                <div class="home_sidebar_friendlist_links">
                                <a href="<?php echo ISVIPI_URL.'profile/'.$username ?>">
                                <li class="home_sidebar_friendlist">
                                <?php if(empty($m_thumbnail)&& $m_gender == "Male"){
										$m_thumbnail="m_.png";
									}else if(empty($m_thumbnail)&& $m_gender == "Female"){
										$m_thumbnail="f_.png";	
									}?>
                                <img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.$m_thumbnail;?>" />
                                <div class="home_sidebar_friendlist_cont pull-right">
                                <?php echo $username ?> &nbsp;
                                <?php if (isOnlineNOW($id)){?>
                                	<i class="fa fa-circle online"></i>
                                <?php } else { ?>
                                	<i class="fa fa-circle offline"></i>
                                <?php } ?>
                                
                                </div>
                                <div style="clear:both"></div>
                                </li>
                                </a>
                                </div>


                                <?php } ?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- ./col -->
                     </div><!-- ./row -->
                 </div><!--./ after-ads -->
