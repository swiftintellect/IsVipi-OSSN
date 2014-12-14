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
                                <h2 class="profile-header"><?php echo FRIEND_REQUESTS ?></h2>
                                    <div class="col-md-12 well" style="margin:5px">
                                    <div class="list-group">
                                    	<?php DisplayFReq($_SESSION['user_id']);
											while ($getusrst->fetch())
											{
										?>
                                      <li class="list-group-item">
                                      <?php echo FRIEND_REQUEST.' '.fROM ?> 
									  <a href="<?php echo ISVIPI_URL. 'profile/'?><?php getUserDetails($from_id); echo $username;?>" title="View Profile"><?php  echo $username;?></a> <?php echo $timestamp ?>
                                      <div class="" style="margin-left:100px; display:inline-block">
                                      <a href="<?php echo ISVIPI_URL. 'users/fRequests'?>?action=1&id=<?php echo htmlspecialchars($from_id, ENT_QUOTES, 'utf-8');?>"><span class="label bg-green"><?php echo ACCEPT ?></span></a>
                                      <a href="<?php echo ISVIPI_URL. 'users/fRequests'?>?action=0&id=<?php echo htmlspecialchars($from_id, ENT_QUOTES, 'utf-8');?>"><span class="label label-danger"><?php echo REJECT ?></span></a>
                                      </div>
                                      </li>
                                      	<?php } ?>
                                        <?php if ($getusrst->num_rows()<1){?>
                                		<li class="list-group-item"><?php echo NO_F_REQUEST ?></li>
                                		<?php }?>
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