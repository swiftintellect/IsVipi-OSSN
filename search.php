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
                      <h3 class="box-title">Search for "<strong><?php echo $term ?></strong>" returned <strong><?php echo $search->count_results($term) ?></strong> result(s)</h3>
                    </div>
                	<div class="row" style="margin-top:10px">
                    	<?php if($search->count_results($term) > 0 ){?>
                    	<?php if(is_array($results) && !isset($error)) foreach ($results as $key => $res) {?>
                        <div class="col-md-12">
                        	<div class="box box-widget widget-user-2">
                            	<div class="widget-user-header bg-white">
                                  <a href="<?php echo ISVIPI_URL.'profile/'.$res['username'] ?>">
                                      <div class="widget-user-image">
                                        <img class="img-square" src="<?php echo user_pic($res['profile_pic']) ?>">
                                      </div><!-- /.widget-user-image -->
                                  </a>
                                  <h3 class="widget-user-username" style="color:#000; font-weight:500">
                                      <a href="<?php echo ISVIPI_URL.'profile/'.$res['username'] ?>">
                                        <?php echo $res['fullname']; ?>
                                      </a>
                                  </h3>
                                  <h5 class="widget-user-desc" style="color:#000">
								  	<?php echo ucfirst($res['gender']); ?> (<?php echo age($res['dob']) ?>)
                              	  </h5>
                                  <div class="widget-user-username" style="margin-top:-5px;">
                                  	<a href="<?php echo ISVIPI_URL.'profile/'.$res['username'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-eye"></i> View Profile</a>
                                  </div>
                                <div class="clear"></div>
                        		</div>
                        	</div>
                        </div>
                        <?php } ?>
                        <?php } else { ?>
                    	<div class="col-md-12" style="margin:5px;">
                        	<li class="list-group-item">No users matched <strong><?php echo $term ?></strong></li>
                        </div>
						<?php } ?>
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
