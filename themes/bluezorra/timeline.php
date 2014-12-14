<?php get_header(); ?>
        <div class="ovrl-container">
        
        <!-- we include the sidebar-menu -->
        <?php get_sidebar();?>

            
            <!-- Right side column. Contains the content of the page -->
            <aside class="right-side">
            	<!-------------------------------
                --------- FEEDS CONTAINER -------
                -------------------------------->
                 <div class="after-menu"><!-- after-menu -->
                 
                     <div class="row"><!--row -->
                     	<!-- POST FEED CONTAINER -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                            	<div class="box-header">
                                    <ul class="nav nav-tabs">
                                    <!-- Post text status update -->
                                    <li class="active">
                                    	<a href="#textFeed" data-toggle="tab">
                                        <i class="fa fa-pencil-square"></i> <?php echo UPDATE_STATUS ?>
                                        </a>
                                    </li>
                                    <!-- upload image/photo status update -->
                                    <li>
                                        <a href="#photoFeed" data-toggle="tab">
                                        <i class="fa fa-picture-o"></i> <?php echo ADD_PHOTOS ?>
                                        </a>
                                    </li>
                                </ul>
                                </div>
                                <div class="box-body">
                                <hr class="no-margin"/>
                         <div id='content' class="tab-content">
                         <div class="tab-pane active" id="textFeed">
                         <form id="textUpdate" action="<?php echo ISVIPI_URL. 'users/processUsers/'?>" method="post" >
                         <input type="hidden" value="<?php echo $username; ?>" name="user" />
                         <input type="hidden" value="feed" name="op" />
                         <div class="form-group">
                         <textarea name="myfeed" class="form-control" id="text" placeholder="<?php echo WHAT_U_DOING ?>" required></textarea>
                         </div>
                         <hr class="five-margin-bottom"/>
                         <div class="texUpdateStatus" id="texUpdateStatus">
                         	<i class="fa fa-spinner fa-spin"></i>
                         </div>
                         <input type="submit" id="submitted" class="btn btn-primary pull-right" value="<?php echo UPDATE ?>"/>
                         <div class="clear"></div>
                         </form>
                         <!-- The javascript that will handle jax form submit for textFeed-->
                         <script>
						 $(document).ready(function() {
							$('#textUpdate').ajaxForm({ 
							success: function() {
								$("#texUpdateStatus").show();
								setTimeout(function(){
								$('#textUpdate').resetForm();
								$("#texUpdateStatus").hide();
								}, 1000);
								} 
							});
						}); 
						</script>
                       </div>
                       <div class="tab-pane" id="photoFeed">
                       <form id="photoUpdate" method="post" action="<?php echo ISVIPI_URL. 'users/processFeed/'?>" enctype="multipart/form-data">
                       	<input type="hidden" name="action" value="9">
                      	<input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']?>">
                        <input type="hidden" name="username" value="<?php echo $username?>">
       <textarea name="myfeed" class="form-control picUpstyled" placeholder="<?php echo TYPE_SMTH ?>"></textarea>
                       <div class="fileUpload btn btn-default">
                            <span><h3><?php echo UPLOAD_PHOTO ?> <?php echo MAX_5_MB ?></h3></span>
                            <input type="file" class="upload" name="file" onchange="subMitForm()"/>
                        </div>
                        <input type="submit" value="submit" id="submitPic" style="display:none"/>
                       	</form>
                        <script>
                        $( function() {
							$('#uploadPhoto').click(function(){
							$("#fileinput").click();
							});
							$("#fileinput").change(function(){          
							$("#filenameC").html(
							$("#fileinput").val().substring(
							$("#fileinput").val().lastIndexOf('\\')+1));
							});
							});
							function subMitForm(){
                         	document.querySelector('#submitPic').click();
                         };
                        </script>
                    	</div>
                 	</div>
                    <script>
						$(document).ready(function() {
						$('.timeline_div').load(fullURL+"/remote/feeds/");
						$('.timeline_div').timer({
						delay: 3000,
						repeat: true,
						url: fullURL+"/remote/feeds/"
						});
						}); 
					</script>
                  	<div class="timeline_div">
                   		<!-- timeline is loaded here -->
                   	</div>
                 </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div><!-- ./col -->
         <!-- ./POST FEED CONTAINER -->
      </div><!-- ./row -->
    </div><!-- ./ after-menu -->
                 
                 <!-- include Announcements -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/ann.php');?>
                 
                 <!-- include friend statuses -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/friend_statuses.php');?>

            </aside><!-- /.right-side -->
        </div><!-- ./ovrl-container -->
        <div class="clear"></div>
<?php get_footer(); ?>