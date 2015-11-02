<?php  require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 

	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') 
?>
<script src="<?php echo ISVIPI_STYLE_URL.'plugins/formsubmit/form.submit.min.js'?>"></script>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>Add new Member</h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h">
          	<h3 class="edit_prof_h3">New Member Details</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/members' ?>" method="POST" id="add_new">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="email" name="email" class="form-control" placeholder="Email" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Full Name</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="fullname" class="form-control" placeholder="Full Name" required="required">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="heard" class="form-control" name="country">
							<?php regCountrySelectOptions() ?>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Birth</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="input-group">
                          <span class="input-group-addon">Day</span>
                          <input type="number" name="dd" class="form-control dob-inp" value="" placeholder="dd" required="required">
                        </div>
                 	</div>
                    <div class="col-md-4 col-sm-9 col-xs-12">
                    	<div class="input-group">
                          <span class="input-group-addon">Month</span>
                          <input type="number" name="mm" class="form-control dob-inp" value="" placeholder="mm" required="required">
                        </div>
                 	</div>
                    <div class="col-md-4 col-sm-9 col-xs-12">
                    	<div class="input-group">
                          <span class="input-group-addon">Year</span>
                          <input type="number" name="yyyy" class="form-control dob-inp" value="" placeholder="yyyy" required="required">
                        </div>
                 	</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    	<input type="radio" class="flat" name="gender" value="male" checked="checked"/> Male &nbsp;&nbsp;
                        <input type="radio" class="flat" name="gender" value="female"/> Female
                        
                 	</div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    	<input type="radio" class="flat" name="status" value="activated" checked="checked"/> Activated &nbsp;&nbsp;
                        <input type="radio" class="flat" name="status" value="send_email"/> Send activation Email
                        
                 	</div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Auto-generate Password</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="auto_pwd"> (Will send email with the new generated password)
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="password" name="pwd" class="form-control" placeholder="Password">
                    </div>
                </div>
                
                
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                <input type="hidden" name="user_id" value="" />
                <input type="hidden" name="aop" value="new" />
                
                <div class="sucess-n" id="success-n" style="display:none">Success</div>
                <div class="error-n" id="error-n" style="display:none">Error</div>
                <button type="submit" class="btn btn-success pull-left" id="submit">Add new Member</button>
                <div class="adding pull-left" id="adding" style="display:none"><i class="fa fa-spinner fa-pulse"></i></div>
                </div>
            </form>
            
            </div>
        </div><!-- end::col-md-6 -->
        
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h">
          	<h3 class="edit_prof_h3">Quick Help</h3>
            <p><strong>Status</strong> - Select "Activated" if you want the new member's status active upon registration. Select "Send activation Email" to require the new member to click on a confirmation link that will be sent to his/her email.</p>
            <p><strong>Auto-generate Password</strong> - Check this is you want the system to automatically generate a password for the new member. The password will be sent by mail to the new member.</p>
            <p><strong>Password field</strong> - If you do not want the system to automatically generate a new password, enter the password in the password field. Make sure you DO NOT check "Auto-generate Password". An email will be sent to the new member with the new password.</p>
            <p>In the event that you check "Auto-generate Password" and fill in the "Password field", the password you enter in the "Password field" will be ignored.</p>
			</div>
		</div><!-- end::col-md-6 -->
        
	</div><!-- end::row -->
<!-- scripts -->
<script>
	$( "#submit" ).click(function() {
		$('#success-n').css('display','none');
		$('#error-n').css('display','none');
	});
</script>
<!-- prevent the form from submitting twice -->
<script>
	var $myForm = $("#add_new");
	$myForm.submit(function(){
		$myForm.submit(function(){
			return false;
		});
	});
</script>
<script>
	$('#add_new').ajaxForm({ 
		dataType: 'json', 
		success: function(json) { 
			$('#submit').prop('disabled', true);
			$("#adding").show();						
			setTimeout(function(){
				if(json.err == true) {
					$('#success-n').css('display','none');
					$('#error-n').css('display','block');
					$('#error-n').html(json.message);
				} else if (json.err == false){
					$('#error-n').css('display','none');
					$('#success-n').css('display','block');
					$('#add_new').clearForm();
					$('#success-n').html(json.message);
				}
				$("#adding").hide();
				$('#submit').prop('disabled', false);
			}, 3000);
		} 
	});
</script>

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>