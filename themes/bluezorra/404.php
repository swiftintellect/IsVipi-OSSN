<?php get_header(); ?>
        <div class="ovrl-container">
        
        <!-- we include the sidebar-menu -->
        <?php get_sidebar();?>

            
            <!-- Right side column. Contains the content of the page -->
            <aside class="right-side">
            	<!-------------------------------
                --------- FEEDS CONTAINER -------
                -------------------------------->
                 <div class="after-menu-2"><!-- after-menu -->
                 <section class="content">
                    <div class="error-page">
                    <h2 class="headline text-info"> <?php echo E_404 ?></h2>
                    <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> <?php echo E_PAGE_NOT_FOUND ?></h3>
                        <p>
                            <?php echo E_PAGE_NOT_FOUND_MSG ?>
                            
                        </p>
                 	</div>
                    </div>
                    </section>
                 </div><!-- ./ after-menu -->
                 
                 
                 <!-- include friend statuses -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/friend_statuses.php');?>




            </aside><!-- /.right-side -->
        </div><!-- ./ovrl-container -->
        <div class="clear"></div>
<?php get_footer(); ?>