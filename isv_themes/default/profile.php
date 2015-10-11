<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        	<!-- user profile -->
        	<section class="col-lg-10">
				<div class="box box-solid members">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?php echo $m_info['m_fullname']; ?>'s Profile</h3>
                    </div>
                	<div class="row">
                    <!-- col-md-3 -->
                    <div class="col-md-4">
                    	<!-- Profile Image -->
                          <div class="box box-primary">
                            <div class="box-body box-profile">
                              <img class="profile-user-img img-responsive square-circle" src="<?php echo ISVIPI_STYLE_URL . 'site/user.jpg' ?>" alt="User profile picture">
                              <h3 class="profile-username text-center"><?php echo $m_info['m_fullname']; ?></h3>
                              
                              <?php if($_SESSION['isv_user_id'] === $m_info['m_user_id']){?>
                              <a href="#" class="btn btn-warning btn-block"><b>Change Profile Pic</b></a>
                              <a href="#" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                              <?php } ?>
            
                              <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                  <b>Friends</b> <a class="pull-right"><?php echo $m->friendsTotal(number_format($m_info['m_user_id'])) ?></a>
                                </li>
                                <li class="list-group-item">
                                  <b>User Level</b> <a class="pull-right"><?php echo $m_info['m_level']; ?></a>
                                </li>
                              </ul>
            
                              <a href="#" class="btn btn-primary"><b>Add Friend</b></a>
                              <a href="#" class="btn btn-success"><b>Message</b></a>
                              <a href="#" class="btn btn-danger"><b>Block</b></a>
                            </div><!-- /.box-body -->
                          </div><!-- /.box -->
                          <!-- end::Profile Image -->
                          
                          <!-- About Me Box -->
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">About Me</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                            	<?php if(empty($m_info['m_rel_status'])){
									$relStatus = '';
								} else {
									$relStatus = ' - ' .$m_info['m_rel_status'];
								}?>
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> Personal Info</strong><br />
                            	<?php echo ucfirst($m_info['m_gender']) ?> (<?php echo age($m_info['m_dob']).$relStatus ?>)
                            <hr style="margin:5px 0">
                              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                              <?php 
							  	if(empty($m_info['m_city'])){
									$city = '';
								} else {
									$city = $m_info['m_city']. ', ';
								}
							  ?>
                              <span class="text-muted"><?php echo $city.$m_info['m_country'] ?></span>
            
                              <hr style="margin:5px 0">
            
                              <strong><i class="fa fa-file-text-o margin-r-5"></i> Hobbies</strong>
                              <span class="text-muted"><?php echo $m_info['m_hobbies'] ?></span>
                            </div><!-- /.box-body -->
                          </div><!-- /.box -->
                          <!-- end::About Me Box -->
                    </div>
                    <!-- end::col-md-3-->
                    
                    
                    
                    
                    </div>
                </div>
            <div class="clear"></div> 
			</section>
            <!--end::user profile -->
            
            <!-- online friends -->
            <section class="col-lg-2 friends-sidebar">
            	<div class="box box-solid">
                    <div class="box-header">
                    
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
