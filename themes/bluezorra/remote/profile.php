<!-- about me -->
<h2 class="profile-header"><?php echo ABOUT ?>
	<div class="profile-options">
		<?php isBlocked($_SESSION['user_id'],$id) ?>
		<?php if ($blockCount < 1){?>
		<?php if($id==$user) {?>
			<a href="#" class="btn btn-info" id="editProfile" ><?php echo EDIT_MY_PROFILE ?></a>
		<?php } else{?>
        <a href="#" class="btn btn-info" id="sendPM" ><?php echo SEND_MSG ?></a>
		<?php if(checkExistingReq($id,$user)){
		//Check if a friend request exists
			echo '<div class="label label-primary">';
			echo REQ_PENDING;
			echo '</div>';
		}
		//Check if the user is him/herself then hide add friend button
		else if($id ===$user){
		}
		//Check if the request was rejected
		else if(checkIfRejected($id,$user)){
			echo '<div class="label label-danger">';
			echo REQ_REJECTED;
			echo '</div>';
		}
		//Check if they are already friends
		else if(checkFriendship($id,$user)){
													
		}
		else
		{?>
			<a href="<?php echo ISVIPI_URL. 'users/fRequests'?>?action=3&id=<?php echo htmlspecialchars($id, ENT_QUOTES, 'utf-8');?>"><button type="submit" class="btn btn-success"><?php echo ADD_FRIEND ?></button></a>
		<?php }?>
		<?php if(checkFriendship($id,$user)){?>
			<a href="#" id="unFriend" class="btn btn-warning"><?php echo REM_FRIEND ?></a>
		<?php }?>
		<?php }?>
		<?php if ($id != $_SESSION['user_id'] ){?>
			<a href="#" id="block" class="btn btn-danger"><?php echo N_BLOCK ?></a>
		<?php } ?>
		<?php } else if ($usr1 == $_SESSION['user_id']){?>
			<a href="<?php echo ISVIPI_URL. 'users/fRequests'?>?action=6&id=<?php echo htmlspecialchars($id, ENT_QUOTES, 'utf-8');?>" >
			<button type="submit" class="btn btn-danger"><?php echo N_UNBLOCK ?></button>
			</a>
		<?php } ?>
	</div>

</h2>
<hr/>
	<div class="col-md-5 well pull-left" style="margin:5px">
    <div class="list-group">
      <li class="list-group-item friend_thumb"><?php echo USERNAME ?>: <?php echo $username ?></li>
      <li class="list-group-item"><?php echo OFFICIAL_NAME ?>: <?php echo $m_name ?></li>
      <li class="list-group-item"><?php echo GENDER ?>: <?php echo $m_gender ?></li>
      <li class="list-group-item"><?php echo AGE ?>: <?php echo $m_age ?></li>
      <li class="list-group-item"><?php echo LOCATION ?>: <?php echo $m_city ?>, <?php echo $m_country ?></li>
    </div>
	</div>
    						<script>
									$(document).ready(function() {
										$('.profile_timeline').load(fullURL+"/remote/profile_feed/<?php echo $username ?>");
										$('.profile_timeline').timer({
											delay: 3000,
											repeat: true,
											url: fullURL+"/remote/profile_feed/<?php echo $username ?>"
										});
									}); 
								</script>
    <div class="profile_timeline pull-left col-md-6">
    
    
    
    </div>

<div class="clear"></div>
<!--./about me -->
  			<!------ edit profile modal -->
                 <div style="display: none" id="editMyProfile">
                 	<form class="c_prof" id="profileDetails" action="<?php echo ISVIPI_USER_PROCESS; ?>" method="POST">
                  		<input type="hidden" name="op" value="p_details">
                     	<input type="hidden" name="user" value="<?php echo $username?>">
                      	<input type="hidden" name="userid" value="<?php echo $user?>">
                      	<div class="form-group">
                      	<input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'utf-8');?>" disabled>
                       	</div>
                      	<div class="form-group">
                       	<input type="text" class="form-control" value="<?php echo htmlspecialchars($m_name, ENT_QUOTES, 'utf-8');?>" name="display_name" placeholder="<?php echo DISPLAY_NAME ?>">
                       	</div>
                       	<div class="form-group">
                     	<select name="user_gender" class="form-control">
                     	<option <?php if(htmlspecialchars($m_gender, ENT_QUOTES, 'utf-8') == "Male"){echo("selected");}?>><?php echo MALE ?></option>
                       	<option <?php if(htmlspecialchars($m_gender, ENT_QUOTES, 'utf-8') == "Female"){echo("selected");}?>><?php echo FEMALE ?></option>
                       	</select>
                       	</div>
                      	<div class="form-group">
                       	<input type="text" name="dob" class="form-control" id="datepicker" value="<?php echo htmlspecialchars($m_dob, ENT_QUOTES, 'utf-8');?>" />
                      	</div>
                       	<div class="form-group">
                      	<input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($m_phone, ENT_QUOTES, 'utf-8');?>" placeholder="<?php echo PHONE_NO ?>"/>
                      	</div>
                      	<div class="form-group">
                       	<input type="text" class="form-control" name="city" placeholder="<?php echo CITY ?>" value="<?php echo htmlspecialchars($m_city, ENT_QUOTES, 'utf-8');?>">
                     	</div>
                      	<div class="form-group">
                      	<?php cSelect();?>
                       	</div>
                     	<button type="submit" class="btn btn-primary"><?php echo UPDATE_PROFILE ?></button>
                    	<div id="workingGen1" style="float:right; margin-right:400px; margin-top:5px; display:none">
                 		<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                      	</div>
                      	<span class="green" id="success" style="font-size:16px; display:none"><i class="fa fa-check-circle"></i></span>
                 	</form>
                 </div>


  			<!------ send pm modal -->
                 <div style="display: none" id="sendUserPM">
                 	<form class="c_prof" action="<?php echo ISVIPI_URL.'users/processPM'?>" method="POST">
                  		<input type="hidden" name="msg" value="0">
                        <input class="form-control" type="hidden" name="recip" value="<?php echo $id;?>" placeholder="Recipient">
                        <div class="form-group">
                       	<textarea id="message" style="width:300px" rows="10" name="message" required></textarea>
                        </div>
                     	<button type="submit" class="btn btn-primary"><?php echo SEND_MSG ?></button>
                 	</form>
                 </div>
              
              	<!------ Unfriend User -->
                 <div style="display: none;width:250px; height:100px" id="unFriendUser">
                 <p>
                 	<?php echo UNFRIEND_PROMPT ?>
                 </p>
                 <div style="text-align:center">
                 	<a href="<?php echo ISVIPI_URL. 'users/fRequests'?>?action=4&id=<?php echo htmlspecialchars($id, ENT_QUOTES, 'utf-8');?>" class="btn btn-danger"><?php echo REM_FRIEND ?></a>
                    <a href="" class="btn btn-primary"><?php echo CANCEL ?></a>
                  </div>
                 </div>
                 
                 <!------ Block User -->
                 <div style="display: none; width:250px; min-height:100px" id="blockUser">
                 <p>
                 	<?php echo N_BLOCK_USER_NOTICE ?>
                 </p>
                 <div style="text-align:center">
                 	<a href="<?php echo ISVIPI_URL. 'users/fRequests'?>?action=5&id=<?php echo htmlspecialchars($id, ENT_QUOTES, 'utf-8');?>" class="btn btn-danger"><?php echo N_BLOCK ?></a>
                    <a href="" class="btn btn-primary"><?php echo CANCEL ?></a>
                  </div>
                 </div>
                 <script>
				 	$('#editProfile').jBox('Modal', {
					title: 'Edit Profile',
					animation: 'flip',
					content: $('#editMyProfile')
					});
					$('#sendPM').jBox('Modal', {
					title: 'Send Message',
					animation: 'flip',
					content: $('#sendUserPM')
					});
					$('#unFriend').jBox('Modal', {
						title: 'Unfriend Prompt',
						animation: 'flip',
						content: $('#unFriendUser')
					});
					$('#block').jBox('Modal', {
						title: 'Block User',
						animation: 'flip',
						content: $('#blockUser')
					});
				</script>