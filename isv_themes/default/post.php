<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        <!-- timeline feed-->
        	<section class="col-lg-6 timeline-feed">
                <?php require_once(ISVIPI_ACT_THEME .'ovr/feed-post-scripts-s.php') ?>
                <div id="tFeeds" style="margin-top:-20px !important">
					<script>
						loadFeed('<?php echo $feed_id ?>')
					</script>
				</div>
					
             <div class="clear"></div> 
			</section>
			
            
            
            <!-- announcements -->
            <section class="col-lg-3 announcements">
            	<div class="box box-solid">
                    <div class="box-header">
                    	<?php require_once(ISVIPI_ACT_THEME .'pages/news.php') ?>
                    </div>
                </div>
            </section>
            
            <!-- online friends -->
            <section class="col-lg-3 friends-sidebar">
            	<div class="box box-solid">
                    <div class="box-header">
                    	<?php require_once(ISVIPI_ACT_THEME .'pages/friends_sidebar.php') ?>
                    </div>
                </div>
            </section>
            
            <div class="clear"></div>
            </section>
        </section>
        <!-- /.content -->
        
      </div>
      <!-- /.content-wrapper -->
      
      <!-- scripts section -->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>
