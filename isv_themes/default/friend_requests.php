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
                      <h3 class="box-title">Friend Requests</h3>
                    </div>
                	<div class="row">
                    
                   	<div class="col-md-12">
                    <div class="box box-widget">
                       <ul class="list-group" style="margin:5px">
                       <?php if(is_array($f_notices) && !empty($f_notices)) foreach ($f_notices as $key => $fn) {?>
                          <li class="list-group-item">
                          	<div class="notice-holder">
                            	<div class="pull-left">
                                   <a href="<?php echo ISVIPI_URL .'profile/'.$fn['username'] ?>" data-toggle="tooltip" title="<?php echo $fn['fullname'] ?>">
                                    <img src="<?php echo user_pic($fn['profile_pic']) ?>" class="img-square" alt="User Image">
                                   </a>
                                </div>
                                <div class="accept-reject">
                            	<strong>friend request</strong> &nbsp;
                                    <a href="<?php echo ISVIPI_URL.'p/friends/f_accept/'.$fn['id'].'/'.$fn['from_id'] ?>" class="btn bg-green btn-xs btn-flat">Accept</a>
                                    <?php if($fn['status'] === 1){?>
                                    <a href="<?php echo ISVIPI_URL.'p/friends/f_ignore/'.$fn['id'] ?>" class="btn bg-red btn-xs btn-flat">Ignore</a>
                                    <?php } ?>
                                </div>
                                
                            <div class="clear"></div>
                            </div>
                          </li>
                        <?php } else { ?>
                        	<li class="list-group-item">You do not have any friend request.</li>
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
