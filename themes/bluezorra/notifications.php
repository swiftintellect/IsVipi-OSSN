<?php get_header(); ?>
<?php getUserDetails($id); ?>
        <div class="ovrl-container">
        
        <!-- we include the sidebar-menu -->
        <?php get_sidebar();?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
            	<!-------------------------------
                --------- FEEDS CONTAINER -------
                -------------------------------->
                 <div class="after-menu-2"><!-- after-menu -->
                    <hr class="no-margin" />
                     <div class="row"><!--row -->
                     	<!-- PROFILE -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                <div id='content' class="tab-content">
                                <!-- about me -->
                                <h2 class="profile-header"><?php echo NOTIFICATIONS ?></h2>
                                    <div class="col-md-12 well" style="margin:5px">
                                    <div class="list-group">
                                    	<?php getNotices($_SESSION['user_id']);{
											while ($getnotice->fetch())
												{
									   	?>
                                      <li class="list-group-item">
                                      <?php echo date('d M Y \a\t g:ia', strtotime($time));?>: <?php echo $notice;?>
                                      </li>
                                      	<?php } ?>
                                        <?php } ?>
                                        <?php noticeSeen($_SESSION['user_id']);?>
                                        <?php if ($getnotice->num_rows()<1){?>
                                        <li class="list-group-item"><?php echo NO_NOTIFICATIONS ?></li>
                                        <?php } ?>
                                    </div>
                                    </div>
                                
                                <div class="clear"></div>
                                <!--./about me -->
                                </div>
                              </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- ./col -->
                        <!-- ./PROFILE -->
                      </div><!-- ./row -->
                      
                 </div><!-- ./ after-menu -->
                
                <!-- include friend statuses -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/friend_statuses.php');?>
            <div style="clear:both"></div>
            </aside><!-- /.right-side -->
        </div><!-- ./ovrl-container -->
        <div class="clear"></div>
<?php get_footer(); ?>