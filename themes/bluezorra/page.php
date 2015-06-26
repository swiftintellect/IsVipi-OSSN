<?php get_header(); ?>
<?php if (isset($_SESSION['user_id'])){
	getUserDetails($_SESSION['user_id']);
}?>
        <div class="ovrl-container">
        
        <!-- we include the sidebar-menu if the user is logged in-->
        <?php if (isset($_SESSION['user_id'])){get_sidebar();}?>
        
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
            	<!-------------------------------
                --------- FEEDS CONTAINER -------
                -------------------------------->
                 <div class="after-menu"><!-- after-menu -->
                    <hr class="no-margin" />
                     <div class="row"><!--row -->
                     	<!-- PROFILE -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                <div id='content' class="tab-content">
                                <h2><?php echo $titleSplit ?></h2>
								</div>
						<hr/>
                        <div class="friend_list">
                            <div class="list-group">
                                <?php
								$content = ParText($content);
								?>
                                <p><?php echo makeLinks($content) ?></p>
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
             <?php if (isset($_SESSION['user_id'])){?>   
            <!-- include Announcements -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/ann.php');
            		//include friend statuses if logged in-->
            		include_once (ISVIPI_THEMES_BASE.'remote/friend_statuses.php');?>
			<?php } ?>
            <div style="clear:both"></div>
            </aside><!-- /.right-side -->
        </div><!-- ./ovrl-container -->
        <div class="clear"></div>
<?php get_footer(); ?>