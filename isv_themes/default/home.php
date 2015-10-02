<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        <!-- timeline feed-->
        	<section class="col-lg-6 timeline-feed">
				<div class="box box-solid" style="margin:0; padding:0">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#update-timeline" data-toggle="tab"><i class="fa fa-pencil"></i> 
                          <span class="updt-status">Update Status</span></a></li>
                          <li><a href="#upload-photo" data-toggle="tab"><i class="fa fa-image"></i> <span class="updt-status">Upload Photo</span></a></li>
                        </ul>
                     	<div class="tab-content">
                  			<div class="tab-pane active" id="update-timeline">
                            <form action="<?php echo ISVIPI_URL .'p/feeds' ?>" method="POST" id="text-update">
                            	<textarea name="feed" class="form-control no-bottom-border" rows="2" placeholder="What's on your mind?"  required="required"></textarea>
                            	<input type="hidden" name="isv_op" value="new-feed" />
                                
                                <input type="submit" class="btn btn-sm btn-primary pull-right" value="Post" />
                                <div class="feed-spinner" id="processing" style="display:none"><i class="fa fa-spinner fa-pulse"></i></div>
                                <div class="clear"></div>
                            </form>
                            </div>
                            	
                            <div class="tab-pane" id="upload-photo">
                            	<form action="<?php echo ISVIPI_URL .'p/feeds' ?>" method="post" enctype="multipart/form-data" id="imgFeed" runat="server">
                                <textarea name="feed" class="form-control no-bottom-border" rows="2" placeholder="Say something..."></textarea>
                            	<div class="fileUpload btn btn-upload">
                                    <span>Click to Choose Image</span>
                                    <input type="file" class="upload" name="feedImg" id="imgInp"/>
                                </div>
                                <img id="preview" src="<?php echo ISVIPI_STYLE_URL.'/default/images/preview.png' ?>"/>
                                <img id="preview2" src="<?php echo ISVIPI_STYLE_URL.'/default/images/success.png' ?>" style="display:none"/>
                                <input type="hidden" name="isv_op" value="img-feed" />
                                <div class="clear"></div>
                                <hr />
                                <input type="submit" class="btn btn-sm btn-primary pull-right" value="Post" />
                                <div class="feed-spinner" id="processing2" style="display:none"><i class="fa fa-spinner fa-pulse"></i></div>
                                <div class="clear"></div>
                                </form>
                            </div>
                          <div class="alert alert-danger alert-dismissable errorLog" id="errorLog" style="display:none;"></div> 
                        </div>
                    </div>
                    
                </div>
                <?php require_once(ISVIPI_ACT_THEME .'ovr/scripts.php') ?>
                <div class="" id="tFeeds">
					<script>
						loadTimeline();
					</script>
				</div>
					
             <div class="clear"></div> 
			</section>
			
            
            
            <!-- announcements -->
            <section class="col-lg-4 announcements">
            	<div class="box box-solid">
                    <div class="box-header">
                    
                    </div>
                    
                    
                </div>
            </section>
            
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
