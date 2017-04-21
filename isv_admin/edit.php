<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php');
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
?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit <?php echo $fullname ?>
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Edit <?php echo $fullname ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Member Username</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" class="form-control" value="<?php echo $minfo['username'] ?>" required="required">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                    <input type="hidden" name="aop" value="<?php echo $converter->encode('c_username') ?>" />
                    <button type="submit" class="btn btn-primary">Change Username</button>
                  </div>
                </form>
                
                <hr />
                
              </div><!-- /.box -->
              
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Member Email</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" class="form-control" value="<?php echo $minfo['email'] ?>" required="required">
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                    <input type="hidden" name="aop" value="<?php echo $converter->encode('c_email') ?>" />
                    <button type="submit" class="btn btn-primary">Change Email</button>
                  </div>
                </form>
                
                <hr />
                
              </div><!-- /.box -->
              
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Profile Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="full name">Full Name</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $minfo['fullname'] ?>">
                    </div>
                    <hr style="margin:5px 0" />
                    <div class="radio">
                        <label>
                          <input type="radio" name="gender" value="male" <?php if($minfo['gender'] === 'male') { ?>checked="checked" <?php } ?>>
                          Male
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="gender" value="female" <?php if($minfo['gender'] === 'female') {?>checked="checked" <?php } ?>>
                          Female
                        </label>
                      </div>
                      <hr style="margin:5px 0" />
                     <div class="form-group">
						 <?php $dob = explode_date($minfo['dob'], '-'); ?>
                          <label for="date of birth">Date of Birth</label>
                          <div class="row">
                            <div class="col-xs-4">
                              <input type="number" name="dd" class="form-control" value="<?php echo $dob['dd'] ?>" placeholder="Day (e.g. 25)" required="required">
                            </div>
                            <div class="col-xs-4">
                              <input type="number" name="mm" class="form-control" value="<?php echo $dob['mm'] ?>" placeholder="Month (e.g. 07)" required="required">
                            </div>
                            <div class="col-xs-4">
                              <input type="number" name="yyyy" class="form-control" value="<?php echo $dob['yyyy'] ?>" placeholder="Year (e.g. 1988)" required="required">
                            </div>
                       </div>
                       <div class="form-group">
                          <label for="country">Country</label>
                          <select class="form-control" name="country">
                            <?php memberCountry($minfo['country']) ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="city">City</label>
                          <input type="text" name="city" class="form-control" value="<?php echo $minfo['city'] ?>">
                        </div>
                        <div class="form-group">
                          <label for="phone number">Phone Number</label>
                          <input type="text" name="phone" class="form-control" value="<?php echo $minfo['phone'] ?>">
                        </div>
                      
                      
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                    <input type="hidden" name="aop" value="<?php echo $converter->encode('profile') ?>" />
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                  </div>
                </form>
                
                <hr />
              </div><!-- /.box -->
              
            </div>
            
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Other Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/edit' ?>" method="POST">
                  <div class="box-body">
                  	<div class="form-group">
                      <label for="hobbies">Hobbies</label>
                      <input type="text" name="hobbies" class="form-control" value="<?php echo $minfo['hobbies'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="relationship status">Relationship Status</label>
                      <select class="form-control" name="rel">
                      	<?php relOptions($minfo['rel_status']) ?>
                      </select>
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="user_id" value="<?php echo $converter->encode($minfo['id']) ?>" />
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('c_other') ?>" />
                    <button type="submit" class="btn btn-primary">Save Details</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>


        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>