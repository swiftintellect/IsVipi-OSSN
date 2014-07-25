<?php get_header()?>
<?php get_sidebar()?>
                       <div class="dash_content">
                        <div class="panel panel-primary">
                          <div class="panel-heading"><?php echo MY_PROFILE ?></div>
                               <div class="panel-body">
                              <?php getMemberDet($user)?>
                               <ul class="nav nav-tabs" id="myTab" >
                                  <li class="active"><a href="#details" data-toggle="tab"><?php echo PERSONAL_DET ?></a></li>
                                  <li><a href="#password" data-toggle="tab"><?php echo CHANGE_PASS ?></a></li>
                                  <li class="disabled"><a href="#settings"><?php echo ACC_SETTINGS ?></a></li>
                               </ul>
                                <div id='content' class="tab-content">
                                  <div class="tab-pane active" id="details">
                                   <div class="edit_profile_i">
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

                                  </div>
                                  <div class="tab-pane" id="password">
                                   <div class="edit_profile_i">
                                    <ul>
                                        <form class="c_pass" id="userPassword"action="<?php echo ISVIPI_USER_PROCESS; ?>" method="POST">
                                        <input type="hidden" name="op" value="change">
                                        <input type="hidden" name="user" value="<?php echo $username?>">
                                             <div class="form-group">
                                             <input type="password" class="form-control" name="newpass" placeholder="<?php echo NEW_PASS ?>">
                                             </div>
                                             <div class="form-group">
                                             <input type="password" class="form-control" name="newpass2" placeholder="<?php echo REP_NEW_PASS ?>">
                                             </div>
                                       		 <button type="submit" class="btn btn-primary"><?php echo CHANGE_PASS ?></button>
                           <div id="workingGen2" style="float:right; margin-right:350px; margin-top:5px; display:none">
                            <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                            </div>
                            <span class="green" id="success2" style="font-size:16px; display:none"><i class="fa fa-check-circle"></i></span>
                            
                                       </form>
                                    </ul>
                                   </div>
                                  </div>
                                  <div class="tab-pane" id="settings">

                                  </div>
    							</div>    
							  </div>
                          </div><!--end of panel-->
                        </div><!--end of dash_content-->
<?php get_r_sidebar()?>
<?php get_footer()?>
<script>
        $(document).ready(function() { 
            $('#profileDetails').ajaxForm(function() { 
			$("#workingGen1").show();
			setTimeout(function(){
			$("#workingGen1").hide();
			$("#success").show();
			$("#success").fadeOut("slow");
			}, 2000);
			$("#success").fadeOut("slow");
            }); 
			
			$('#userPassword').ajaxForm(function() { 
			$("#workingGen2").show();
			setTimeout(function(){
			$("#workingGen2").hide();
			$("#success2").show();
			$("#success2").fadeOut("slow");
			$("#userPassword").resetForm();
			}, 2000);
            }); 
        }); 
	</script>
