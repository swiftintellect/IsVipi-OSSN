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
                      <h3 class="box-title">Global Notifications</h3>
                    </div>
                	<div class="row">
                    
                   	<div class="col-md-12">
                    <div class="box box-widget">
                       <ul class="list-group" style="margin:5px">
                       <?php if(is_array($gnotices) && !empty($gnotices)) foreach ($gnotices as $key => $gn) {?>
                          <li class="list-group-item">
                          	<div class="notice-holder">
                               <?php echo html_entity_decode($gn['notice']) ?> ~ <?php echo  elapsedTime($gn['noticetime']) ?>
                            </div>
                          </li>
                          <div class="clear"></div>
                        <?php } else { ?>
                        	<li class="list-group-item">You do not have any notification.</li>
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
