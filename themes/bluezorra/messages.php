<?php get_header(); ?>
<?php getUserDetails($id); ?>
        <div class="ovrl-container">
        
        <!-- we include the sidebar-menu -->
        <?php get_sidebar();?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                 <div class="after-menu-2"><!-- after-menu -->
                    <hr class="no-margin" />
                     <div class="row"><!--row -->
                     	<!-- PROFILE -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                <div id='content' class="tab-content">
                                <?php include_once (ISVIPI_THEMES_BASE.'remote/pm.php');?>

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