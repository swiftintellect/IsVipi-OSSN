<?php get_header()?>
<link href="<?php echo ISVIPI_STYLE_URL; ?>css/isvipi-timeline.css" rel="stylesheet" type="text/css" />
<?php get_sidebar()?>
                  
                       <div class="dash_content">
                        <div class="panel panel-primary full-length">
                          <div id="nobgcolor">
                          <div class="panel-heading">
						  <ul class="nav nav-tabs" id="myTab" >
                                  <li class="active"><a href="#feed" data-toggle="tab"><i class="fa fa-pencil-square"></i> <?php echo UPDATE_STATUS ?></a></li>
                                  <li><a href="#imageUpload" data-toggle="tab"><i class="fa fa-picture-o"></i> <?php echo ADD_PHOTOS ?></a></li>
                               </ul>
                          </div>
                          </div>
                          <div id='content' class="tab-content">
                                  <div class="tab-pane active" id="feed">
                                    <div id="isvipi-timeline">
                         <form id="textUpdate" action="<?php echo ISVIPI_URL. 'users/processUsers/'?>" method="post" >
                         <input type="hidden" value="<?php echo $username; ?>" name="user" />
                         <input type="hidden" value="feed" name="op" />
                         <div class="form-group">
                         <textarea name="myfeed" class="form-control" id="inputField" placeholder="<?php echo WHAT_U_DOING ?>"></textarea>
                         
                         </div>
                         <div id="workingGenPost" style="float:left; margin-left:400px; margin-top:20px; display:none">
                            <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                            </div>
                         <input type="submit" id="submitted" class="btn btn-primary pull-right" value="<?php echo UPDATE ?>"/>
                                 <div class="clear"></div>
                                 </form>
                                  
                                  </div>

                                  </div>
                                  <div class="tab-pane" id="imageUpload">
                                   <div class="upload_timeline_image_holder">
                       	<form id="photoUpdate" method="post" action="<?php echo ISVIPI_URL. 'users/processFeed/'?>" enctype="multipart/form-data">
                       	<input type="hidden" name="action" value="9">
                      	<input type="hidden" name="userid" value="<?php echo $user?>">
                        <input type="hidden" name="username" value="<?php echo $username?>">
       <textarea name="myfeed" class="form-control picUpstyled" placeholder="<?php echo TYPE_SMTH ?>"></textarea>
                      	<input type="file" id="fileinput" style="display:none" name="file" onchange="subMitForm()">
                        <span id="uploadPhoto" class="button"><?php echo UPLOAD_PHOTO ?></span>
 						<span id="filename"></span>
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
							<div style="clear:both"></div>	
                            <div class="progress">
        <div class="bar"></div >
        <div class="percent">0%</div >
    </div>
                           </div>
                           </div>
                           </div>
                           
                           <div class="emoticon">
                           </div>
                                <!--------------------------->
                                <div class="refresh_timeline">
                                <!--------------------------->
                                <center>
                                <div id="loadingFeeds" style="font-size:18px">
                                <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="20" />
                                </div>
                                </center>
                                   <!----->
                                   </div>
                                   <!---->
                                   
                                   </div>
                                   </div>
                                  
<script>
$(document).ready(function() {
    $('.refresh_timeline').timer({
		delay: 3000,
		repeat: true,
		url: fullURL+"/remote/t_feed/"
	});
}); 
</script> 
<?php get_r_sidebar()?>
<?php get_footer()?>