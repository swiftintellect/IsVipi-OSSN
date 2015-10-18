<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        	<!-- members -->
        	<section class="col-lg-6">
				<div class="box box-solid members">
                    <div class="box-header with-border">
                      <h3 class="box-title">Feed/Post Notifications</h3>
                    </div>
                	<div class="row">
                    
                   <div class="col-md-12">
                    <div class="box box-widget">
                       <ul class="list-group" style="margin:5px">
                       <?php if(is_array($feed_notices) && !empty($feed_notices)) foreach ($feed_notices as $key => $feed_n) {?>
                          <li class="list-group-item">
                          	<div class="notice-holder">
                                   <a href="<?php echo ISVIPI_URL .'profile/'.$feed_n['username'] ?>" data-toggle="tooltip" title="<?php echo $feed_n['fullname'] ?>">
                                    <?php echo $feed_n['fullname'] ?>
                                   </a>
                                    <strong><?php echo $feed_n['notice'] ?></strong>
                                    <a href="<?php echo ISVIPI_URL .'post/'.$converter->encode($feed_n['feed_id']) ?>" class="text-blue">post</a>
                                	<div class="notification-time"><?php echo elapsedTime($feed_n['time']) ?></div>
                            </div>
                          </li>
                        <?php } else { ?>
                        	<li class="list-group-item">You do not have any notifications.</li>
                        <?php } ?>
                        </ul>
                    
                    </div>
                    </div>
                    </div>
                </div>
            <div class="clear"></div> 
			</section>
            <!--end::members -->
			
            
            
            <!-- announcements -->
            <section class="col-lg-3 announcements">
            	<div class="box box-solid">
                    <div class="box-header">
                    
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
