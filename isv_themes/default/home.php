<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>
	<?php require_once(ISVIPI_ACT_THEME .'ovr/feed-post-scripts.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

        <!-- timeline feed-->
        	<section class="col-lg-6 timeline-feed">
				<div class="box box-solid" style="margin:0; padding:0">
                    <div class="nav-tabs-custom" style="margin:0; padding:0">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#update-timeline" data-toggle="tab"><i class="fa fa-pencil"></i> 
                          <span class="updt-status">Update Status</span></a></li>
                          <li><a href="#upload-photo" data-toggle="tab"><i class="fa fa-image"></i> <span class="updt-status">Upload Photo</span></a></li>
                        </ul>
                     	<div class="tab-content">
                  			<div class="tab-pane active" id="update-timeline">
                            <form action="<?php echo ISVIPI_URL .'p/feeds' ?>" method="POST" id="text-update">
                            	<textarea name="feed" class="form-control no-bottom-border" rows="2" placeholder="Shout to the world!" ></textarea>
                            	<input type="hidden" name="isv_op" value="<?php echo $converter->encode('new-feed') ?>" />
                                <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary pull-right">Post</button>
                                </div>
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
                                <img id="preview2" src="<?php echo ISVIPI_STYLE_URL.'/default/images/success.png' ?>"/>
                                <input type="hidden" name="isv_op" value="<?php echo $converter->encode('img-feed') ?>" />
                                <div class="clear"></div>
                                <hr />
                                <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary pull-right" value="Post" id="uplPic">Post</button>
                                </div>
                                <input type="button" class="btn btn-sm btn-primary pull-right" value="Post" id="uplPic2" disabled="disabled" style="display:none"/>
                                <div class="feed-spinner" id="processing2" style="display:none"><i class="fa fa-spinner fa-pulse"></i></div>
                                <div class="clear"></div>
                                </form>
                            </div>
                          <div class="alert alert-danger alert-dismissable errorLog" id="errorLog" style="display:none;"></div> 
                        </div>
                    </div>
                    
                    <!-- link preview -->
                    <div class="liveurl-loader" style="margin:20px !important;"></div>
                    <div style="clear:both; height:10px;"></div>
                    <div class="liveurl">
                    	<div class="close" title="Close"></div>
                        <div class="inner">
                            <div class="image"> </div>
                            <div class="details">
                                <div class="info">
                                    <div class="title"> </div>
                                    <div class="description"> </div> 
                                    <div class="url"> </div>
                                </div>
                                
                                <div class="thumbnail">
                                    <div class="pictures">
                                        <div class="controls">
                                            <div class="prev button inactive"></div>
                                            <div class="next button inactive"></div>
                                            <div class="count">
                                                <span class="current">0</span><span> of </span><span class="max">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                        </div>
                    </div>
                <!-- end::link preview -->

                    
                </div>
                
                <div id="tFeeds">
                	<?php require_once(ISVIPI_PAGES_BASE .'feeds.php') ?>
					
				</div>
					
             <div class="clear"></div> 
			</section>
			
            
            
            <!-- announcements -->
            <section class="announcements col-lg-3">
            	<div class="box box-solid">
                    <div class="box-header">
                    	<?php require_once(ISVIPI_ACT_THEME .'pages/news.php') ?>
                    </div>
                </div>
            </section>
            
            <!-- online friends -->
            <section class="friends-sidebar col-lg-3" id="friends-sidebar">
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
      <!-- FEED IMAGE PREVIEW -->
        <script>
			function readURL(input) {
			var url = input.value;
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
				var reader = new FileReader();
		
				reader.onload = function (e) {
					$('#preview2').css('display','none');
					$('#preview').css('display','block');
					$('#preview').attr('src', e.target.result);
				}
		
				reader.readAsDataURL(input.files[0]);
			}else{
				 //$('#preview').attr('src', 'http://localhost/isvipi/isv_inc/isv_style.lib/default/images/logo.png');
			}
		}
		$("#imgInp").change(function(){
			readURL(this);
		});
		</script>
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>
