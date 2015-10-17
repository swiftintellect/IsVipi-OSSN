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
                      <h3 class="box-title">404 Page Not Found.</h3>
                    </div>
                    <div class="error-page" style="margin-top:0">
            			<h2 class="headline text-yellow"> 404</h2>
                        <div class="error-content" style="padding-top:10px; width:50%">
                          <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                          <p>The page you are looking for could not be found. Here are some useful links to help you:</p>
                          <ul>
                          	<li><a href="<?php echo ISVIPI_URL .'home'?>">My Dashboard</a></li>
                            <li><a href="<?php echo ISVIPI_URL .'members'?>">Browse Members</a></li>
                          </ul>
                        </div>
                    </div>
                    
                    <div class="clear"></div>
                    
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
