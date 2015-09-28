<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        <!-- timeline feed-->
        	<section class="col-lg-6 timeline-feed">
				<div class="box box-solid">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#update-timeline" data-toggle="tab"><i class="fa fa-pencil"></i> Update Status</a></li>
                          <li><a href="#upload-photo" data-toggle="tab"><i class="fa fa-image"></i> Upload Photo</a></li>
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
                <div class="" id="">
					<?php require_once(ISVIPI_ACT_THEME .'pages/feeds.php') ?>
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
      
      <!-- TEXT FEED -->
      <script>
		$('#text-update').ajaxForm({ 
			dataType: 'json', 
			success: function(json) { 
			$("#processing").show();
			$('#errorLog').css('display','none');
			$('input[type="submit"]').prop('disabled', true);
				setTimeout(function(){
					if(json.err == true) {
						$('#errorLog').css('display','block');
						$('#errorLog').html(json.message);
					} else if (json.err == false){
						$('#errorLog').css('display','none');
						$('#text-update').clearForm();
					}
					$('input[type="submit"]').prop('disabled', false);
					$("#processing").hide();
				}, 3000);
			 } 
			});
		</script>
      <!-- IMAGE FEED -->
      <script>
		$('#imgFeed').ajaxForm({ 
			dataType: 'json', 
			success: function(json) { 
			$("#processing2").show();
			$('#errorLog').css('display','none');
			$('input[type="submit"]').prop('disabled', true);
				setTimeout(function(){
					if(json.err == true) {
						$('#errorLog').css('display','block');
						$('#errorLog').html(json.message);
					} else if (json.err == false){
						$('#errorLog').css('display','none');
						$('#imgFeed').clearForm();
					}
					$('input[type="submit"]').prop('disabled', false);
					$("#processing2").hide();
				}, 3000);
			 } 
			});
		</script>
        <script>
			function readURL(input) {
			var url = input.value;
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
				var reader = new FileReader();
		
				reader.onload = function (e) {
					$('#preview').css('display','block');
					$('#preview').attr('src', e.target.result);
				}
		
				reader.readAsDataURL(input.files[0]);
			}else{
				 $('#preview').attr('src', 'http://localhost/isvipi/isv_inc/isv_style.lib/default/images/logo.png');
			}
		}
		$("#imgInp").change(function(){
			readURL(this);
		});
		</script>
        

<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>
