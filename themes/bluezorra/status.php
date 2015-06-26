<?php get_header(); ?>
        <div class="ovrl-container">
        
        <!-- we include the sidebar-menu -->
        <?php get_sidebar();?>

            
            <!-- Right side column. Contains the content of the page -->
            <aside class="right-side">
            	<!-------------------------------
                --------- FEEDS CONTAINER -------
                -------------------------------->
                 <div class="after-menu"><!-- after-menu -->
                 
                     <div class="row"><!--row -->
                     	<!-- POST FEED CONTAINER -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                <hr class="no-margin"/>

                  			<div class="timeline_div">
							<!-- load single status -->
                   			</div>
                            <script>
								$(document).ready(function() {
								$('.timeline_div').load(fullURL+"/remote/status/<?php echo $statusID ?>");
								$('.timeline_div').timer({
								delay: 3000,
								repeat: true,
								url: fullURL+"/remote/status/<?php echo $statusID ?>"
								});
								}); 
							</script>
                 </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div><!-- ./col -->
         <!-- ./POST FEED CONTAINER -->
      </div><!-- ./row -->
    </div><!-- ./ after-menu -->
                 
                 <!-- include Announcements -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/ann.php');?>
                 
                 <!-- include friend statuses -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/friend_statuses.php');?>

            </aside><!-- /.right-side -->
        </div><!-- ./ovrl-container -->
        <div class="clear"></div>
<?php get_footer(); ?>