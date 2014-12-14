<?php get_header(); ?>
<?php getUserDetails($id); ?>
        <div class="ovrl-container">
        
        <!-- we include the sidebar-menu -->
        <?php get_sidebar();?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
            	<!-------------------------------
                --------- FEEDS CONTAINER -------
                -------------------------------->
                 <div class="after-menu-2"><!-- after-menu -->
                 <?php myPersonalSettings($id);
						global $FriendsOnlyViewProfile;
						if ($FriendsOnlyViewProfile == 1 && $_SESSION['user_id'] != $id){
							if (!checkFriendship($id,$_SESSION['user_id'])){
								echo '<div class="cannot_see_profile">';
								echo FRIENDS_ONLY_PROFILE;
								echo '</div>';
								exit();
							}
						}
				 ?>
                 	<!-- user cover photo -->
                    <div class="user-cover-photo">
                    <?php if ($id == $_SESSION['user_id']){?>
                        <a class="change-cover-photo" id="coverPhoto" href="javascript:void(0)">Change Cover Photo</a>
                    <?php } ?>
                    <?php if (!isset($coverPhoto)){$coverPhoto = "default.png";} ?>
                    <img src="<?php echo ISVIPI_PROFILE_PIC_URL."coverphotos/".$coverPhoto;?>" />
                    </div>
                    <!-- ./user-cover-photo -->
                    <!-- user-profile-pic -->
                    <?php if(empty($m_thumbnail)&& $m_gender == "Male"){
						$m_thumbnail="m_.png";
						}else if(empty($m_thumbnail)&& $m_gender == "Female"){
						$m_thumbnail="f_.png";	
					}?>
                    <div class="user-profile-pic">
                    	<img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.htmlspecialchars($m_thumbnail, ENT_QUOTES, 'utf-8');?>"/>
                        <?php if ($id == $_SESSION['user_id']){?>
                        <a class="change-profile-pic" id="profilePic" href="javascript:void(0)">Change Profile Pic</a>
                      <?php } ?>
                    </div>
                    <!-- ./user-profile-pic -->
                    <!-- profile-menu-bar -->
                    <div class="profile-menu-bar">
                    
                   		<ul class="nav nav-tabs">
                        <!-- about user -->
                         	<li <?php if(!isset($ACTION[2])){echo 'class="active"';}?>>
                           	<a href="<?php echo ISVIPI_URL.'profile/'.$username ?>">
                           	<i class="fa fa-user"></i> <?php echo ABOUT ?>
                           	</a>
                          	</li>
                       	<!-- friends -->
                          	<li <?php if(isset($ACTION[2]) && $ACTION[2] == 'friends'){echo 'class="active"';}?>>
                           	<a href="<?php echo ISVIPI_URL.'profile/'.$username.'/friends' ?>">
                           	<i class="fa fa-users"></i> <?php echo FRIENDS ?>
                           	</a>
                        	</li>
                            <!-- only show settings if a user is viewing his/her own profile -->
                            <?php if ($user == $id){?>
                       	<!-- settings -->
                          	<li <?php if(isset($ACTION[2]) && $ACTION[2] == 'settings'){echo 'class="active"';}?>>
                           	<a href="<?php echo ISVIPI_URL.'profile/'.$username.'/settings' ?>">
                           	<i class="fa fa-cogs"></i> <?php echo SETTINGS ?>
                           	</a>
                        	</li>
                            <?php } ?>
                      	</ul>
                    </div>
                 	<!-- ./profile-menu-bar -->
                    <div class="clear"></div>
                    <hr class="no-margin" />
                     <div class="row"><!--row -->
                     	<!-- PROFILE -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                <div id='content' class="tab-content">
                                <?php if (!isset($ACTION[2])){ 
									include_once (ISVIPI_THEMES_BASE.'remote/profile.php');
								} else if (isset($ACTION[2]) && $ACTION[2] == 'friends'){
									include_once (ISVIPI_THEMES_BASE.'remote/friends.php');
								} else if (isset($ACTION[2]) && $ACTION[2] == 'settings'){
									if ($user == $id){
										include_once (ISVIPI_THEMES_BASE.'remote/settings.php');
									} else {
										die404();
									}
								} else if ($ACTION[0] != 'profile'){
									die404();
								}?>

                                </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- ./col -->
                        <!-- ./PROFILE -->
                      </div><!-- ./row -->
                      
                 </div><!-- ./ after-menu -->
                <!-- include friend statuses -->
                <?php include_once (ISVIPI_THEMES_BASE.'remote/friend_statuses.php');?>
							        <!------ change profile pic -->
                      <div style="display: none" id="uploadProfilePic">
                        <form id="changePic" action="<?php echo ISVIPI_URL. 'users/processPIC'?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="op" value="newpic">
                        <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']?>">
                        <label for="file"><?php echo NAME_OF_FILE ?>:</label>
                        <input type="file" class="form-control" name="file"><br>
                        <button type="submit" class="btn btn-primary" name="submit" onclick="showLoad();"/><?php echo UPLOAD ?></button>
                        <div id="changePicStatus" style="float:left; margin-right:20px; font-size:18px; color:#06F;">
                        <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        </form>
                        
                        </div>

			<!------ change cover photo -->
                 <div style="display: none" id="changeUserCover">
                 	<div class="alert alert-info no-margin" style="font-size:11px;padding:3px">
                    <?php echo COVER_PIC_INFO ?>
                    </div>
                 	<form id="changePic" action="<?php echo ISVIPI_URL. 'users/processPIC'?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="op" value="changecover">
                        <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']?>">
                        <label for="file"><?php echo NAME_OF_FILE ?>:</label>
                        <input type="file" class="form-control" name="cover"><br>
                        <button type="submit" class="btn btn-primary" name="submit" onclick="showLoad();"/><?php echo UPLOAD ?></button>
                        <div id="changePicStatus" style="float:left; margin-right:20px; font-size:18px; color:#06F;">
                        <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        </form>
                 </div>
	
               			<script>
							$('#profilePic').jBox('Modal', {
								title: 'Change Profile Pic',
								animation: 'flip',
								content: $('#uploadProfilePic')
							});
							$('#coverPhoto').jBox('Modal', {
								title: 'Change Cover Photo',
								animation: 'flip',
								content: $('#changeUserCover')
							});
							
							function showLoad(){
								$('#changePicStatus').show();
							}
						</script>  



            <div style="clear:both"></div>
            </aside><!-- /.right-side -->
        </div><!-- ./ovrl-container -->
        <div class="clear"></div>
<?php get_footer(); ?>