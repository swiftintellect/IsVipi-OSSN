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
                                    <?php if (!isset($ACTION[1])){ 
										include_once (ISVIPI_THEMES_BASE.'remote/all.php');
									} else if (isset($ACTION[1]) && $ACTION[1] == 'online'){
										include_once (ISVIPI_THEMES_BASE.'remote/online.php');
									} else if (isset($ACTION[1]) && $ACTION[1] == 'new'){
											include_once (ISVIPI_THEMES_BASE.'remote/new.php');
									} else {
										die404();
									}?>
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