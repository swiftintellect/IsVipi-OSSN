<?php  
	require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ;
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>Edit Profile</h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    
    	<div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Admin Details</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/admins' ?>" method="POST">
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Email</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="email" name="email" class="form-control" value="<?php echo $admin['email'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Name</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="text" name="name" class="form-control" value="<?php echo $admin['name'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Date of Registration</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" value="<?php echo $admin['reg_date'] ?>" disabled="disabled">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Level</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" value="<?php echo $admin['level'] ?>" disabled="disabled">
                    </div>
                </div>
               
                <div class="form-group">
                <input type="hidden" name="aop" value="edit" />
                <button type="submit" class="btn btn-success">Save Details</button>
                </div>
            </form>
            
            </div>
            
        </div><!-- end::col-md-6 -->

    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
            <h3 class="edit_prof_h3">Admin Password</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/admins' ?>" method="POST">
            <div class="alert alert-danger" style="padding:10px;">
            	Once the password is changed, you will be automatically logged out.
            </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Current Password</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="password" name="c_pwd" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">New Password</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="password" name="pwd" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Repeat new Password</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="password" class="form-control" name="pwd2" required="required">
                    </div>
                </div>
                <div class="form-group">
                <input type="hidden" name="aop" value="change_pwd" />
                <button type="submit" class="btn btn-success">Change Password</button>
                </div>
            </form>
            </div>
		</div><!-- end::col-md-6 -->
        
        
        
        
        
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>