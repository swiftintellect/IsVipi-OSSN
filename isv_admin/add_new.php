<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new Member
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Add new Member</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">New Member Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/members' ?>" method="POST" id="add_new">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Email" required="required">
                    </div>
                    <div class="form-group">
                      <label for="full name">Full Name</label>
                      <input type="text" name="fullname" class="form-control" placeholder="Full Name" required="required">
                    </div>
                    <div class="form-group">
                      <label for="country">Country</label>
                      <select class="form-control" name="country">
						<?php regCountrySelectOptions() ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="date of birth">Date of Birth</label>
                      <div class="row">
                        <div class="col-xs-4">
                          <input type="number" name="dd" class="form-control" placeholder="Day (e.g. 25)" required="required">
                        </div>
                        <div class="col-xs-4">
                          <input type="number" name="mm" class="form-control" placeholder="Month (e.g. 07)" required="required">
                        </div>
                        <div class="col-xs-4">
                          <input type="number" name="yyyy" class="form-control" placeholder="Year (e.g. 1988)" required="required">
                        </div>
                      </div>
                    </div>
                    <hr />
                      <div class="radio">
                        <label>
                          <input type="radio" name="gender" value="male" checked="checked">
                          Male
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="gender" value="female">
                          Female
                        </label>
                      </div>
                    <hr />
                      <div class="radio">
                        <label>
                          <input type="radio" name="status" value="activated" checked="checked">
                          Activated
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="status" value="send_email">
                          Require Validation
                        </label>
                      </div>
                    <hr />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="auto_pwd"> Auto-generate Password (an email will be sent with the new password)
                      </label>
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" name="pwd" class="form-control" placeholder="Password">
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<div class="sucess-n" id="success-n" style="display:none"></div>
                	<div class="error-n" id="error-n" style="display:none"></div>
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('new') ?>" />
                    <button type="submit" class="btn btn-primary">Add new Member</button>
                    <div class="adding pull-right text-blue" id="adding" style="margin-right:60%; margin-top:10px; display:none"><i class="fa fa-spinner fa-pulse"></i></div>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            <div class="col-md-6">
            	<div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Quick Guide</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    	<dl>
                        	<dd>Select "<span class="text-blue">Activated</span>" if you want the new member's status active upon registration. Select "<span class="text-blue">Send activation Email</span>" to require the new member to click on a confirmation link that will be sent to his/her email.</dd>
                            <hr style="margin:10px 0" />
                        	<dd><strong>Auto-generate Password</strong> - Check this is you want the system to automatically generate a password for the new member. The password will be sent by mail to the new member.</dd>
                            <hr style="margin:10px 0" />
                        	<dd><strong>Password</strong> - If you DO NOT want the system to automatically generate a new password, enter the password in the password field. Make sure you DO NOT check "<span class="text-blue">Auto-generate Password</span>". An email will be sent to the new member with the new password.</dd>
                            <hr style="margin:10px 0" />
                        	<dd>In the event that you check "<span class="text-blue">Auto-generate Password</span>" and fill in the "Password field", the password you enter in the "<span class="text-blue">Password field</span>" will be ignored.</dd>
                        </dl>
                      
                    </div><!-- /.box-body -->
               </div><!-- /.box -->
             </div>
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


        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>