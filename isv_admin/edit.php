<?php  require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	
	if(!isset($_SERVER['HTTP_REFERER'])){
		$from_url = ISVIPI_ACT_ADMIN_URL.'members/';
	} else {
		$from_url = $_SERVER['HTTP_REFERER'];
	}
	
	$username = cleanGET($PAGE[2]);
	$username = $converter->decode($username);
	
	//check if user exists and get user id
	global $user_id;
	if(!id_from_username($username)){
		 $_SESSION['isv_error'] = 'No such user found. Please try again';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	//instantiate our get member class
	require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php'); 
	$member = new get_single_member();
	$minfo = $member->member($user_id);
	
	//get user's full name
	$fullname = full_name_from_id($user_id);
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') 
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>Edit <?php echo $fullname ?></h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h">
          	<h3 class="edit_prof_h3">Username</h3>
            <form class="edt-prf" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="post">
            	<div class="form-group">
                   	<div class="col-md-8 col-sm-9 col-xs-12">
                    	<input type="text" name="username" class="form-control pull-left" value="<?php echo $minfo['username'] ?>" required="required">
                   	</div>
                    <input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                    <input type="hidden" name="aop" value="c_username" />
                    <button type="submit" class="btn btn-success">Change Username</button>
                </div>
			</form>
            
            <h3 class="edit_prof_h3">Email</h3>
            <form class="edt-prf" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="POST">
            	<div class="form-group">
                   	<div class="col-md-8 col-sm-9 col-xs-12">
                    	<input type="email" name="email" class="form-control pull-left" value="<?php echo $minfo['email'] ?> " required="required">
                   	</div>
                    <input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                    <input type="hidden" name="aop" value="c_email" />
                    <button type="submit" class="btn btn-success">Change Email</button>
                </div>
			</form>
			</div>
		</div><!-- end::col-md-6 -->
        
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h">
          	<h3 class="edit_prof_h3">Other Details</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="POST">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Hobbies</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="hobbies" class="form-control" value="<?php echo $minfo['hobbies'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Rel. Status</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="heard" class="form-control" name="rel">
                        	<?php relOptions($minfo['rel_status']) ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                <input type="hidden" name="aop" value="c_other" />
                <button type="submit" class="btn btn-success">Save Details</button>
                </div>
            </form>
            
            </div>
        </div><!-- end::col-md-6 -->
        
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h">
          	<h3 class="edit_prof_h3">Profile Details</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="post">
            	<div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">Full Name</label>
                   	<div class="col-md-9 col-sm-9 col-xs-12">
                    	<input type="text" name="name" class="form-control" value="<?php echo $minfo['fullname'] ?>">
                 	</div>
              	</div><br /><br />
                <div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                   	<div class="col-md-9 col-sm-9 col-xs-12">
                    	<input type="radio" class="flat" name="gender" value="male" <?php if($minfo['gender'] === 'male') { ?>checked="checked" <?php } ?>/> Male
                        <input type="radio" class="flat" name="gender" value="female" <?php if($minfo['gender'] === 'female') {?>checked="checked" <?php } ?>/> Female
                        
                 	</div>
              	</div><br /><br />
                <?php $dob = explode_date($minfo['dob'], '-'); ?>
                <div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Birth</label>
                    
                   	<div class="col-md-3 col-sm-9 col-xs-12">
                    	
                        <div class="input-group">
                          <span class="input-group-addon">Day</span>
                          <input type="number" name="dd" class="form-control dob-inp" value="<?php echo $dob['dd'] ?>" placeholder="dd">
                        </div>
                 	</div>
                    <div class="col-md-3 col-sm-9 col-xs-12">
                    	<div class="input-group">
                          <span class="input-group-addon">Month</span>
                          <input type="number" name="mm" class="form-control dob-inp" value="<?php echo $dob['mm'] ?>" placeholder="mm">
                        </div>
                 	</div>
                    <div class="col-md-3 col-sm-9 col-xs-12">
                    	<div class="input-group">
                          <span class="input-group-addon">Year</span>
                          <input type="number" name="yyyy" class="form-control dob-inp" value="<?php echo $dob['yyyy'] ?>" placeholder="yyyy">
                        </div>
                 	</div>
              	</div>
                
                <div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                   	<div class="col-md-9 col-sm-9 col-xs-12">
                    	<select id="heard" class="form-control" name="country" required>
                        	<?php memberCountry($minfo['country']) ?>
                        </select>
                 	</div>
              	</div>
                
                <div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                   	<div class="col-md-9 col-sm-9 col-xs-12">
                    	<input type="text" name="city" class="form-control" value="<?php echo $minfo['city'] ?>">
                 	</div>
              	</div>
                
                <div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                   	<div class="col-md-9 col-sm-9 col-xs-12">
                    	<input type="text" name="phone" class="form-control" value="<?php echo $minfo['phone'] ?>">
                 	</div>
              	</div>
                
                <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                <input type="hidden" name="aop" value="profile" />
                <button type="submit" class="btn btn-success">Save Details</button>
                </div>
			</form>
			</div>
		</div><!-- end::col-md-6 -->
        
        
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>