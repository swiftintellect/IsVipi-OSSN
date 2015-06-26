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
                                <?php 
								   if ($results == 1){$ResNumber = RESULT;} else {$ResNumber = RESULTS;}
									echo $results."&nbsp;".$ResNumber."&nbsp;".FOUND_FOR ?> "<?php echo $term 
								?>
								</div>
						<hr/>
                        <div class="friend_list">
                            <div class="list-group">
                                <?php while ($search->fetch()){
                                    getMemberDet($id);
                                    getUserDetails($id)
                                ?> 
                                <li class="list-group-item">
                                <!-- friend image -->
                                <?php if(empty($m_thumbnail)&& $m_gender == "Male"){
                                    $m_thumbnail="m_.png";
                                 } else if(empty($m_thumbnail)&& $m_gender == "Female"){
                                    $m_thumbnail="f_.png";	
                                }?>
                                <a href="<?php echo ISVIPI_URL.'profile/'.$username ?>" title="<?php echo $m_name ?>" class="thumbnail">
                                    <img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.$m_thumbnail ?>"/>
                                </a>
                                <div class="friend_list_name">
                                    <a href="<?php echo ISVIPI_URL.'profile/' ?><?php echo $username ?>" title="<?php echo $m_name ?>">
                                        <?php echo $username ?>
                                    </a>
                                </div>
                                <?php } ?>
                                </li>
                            </div>
                         </div>
                      <div class="clear"></div>
                      <!--./members -->
                     </div>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
              </div><!-- ./col -->
            <!-- ./PROFILE -->
          </div><!-- ./row -->
                
            <!-- include friend statuses -->
            <?php include_once (ISVIPI_THEMES_BASE.'remote/friend_statuses.php');?>

            <div style="clear:both"></div>
            </aside><!-- /.right-side -->
        </div><!-- ./ovrl-container -->
        <div class="clear"></div>
<?php get_footer(); ?>