<?php  
	require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ;
	global $isv_siteDetails,$isv_siteSettings;
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>General Settings</h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    
    	<div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Site Details</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">URL</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="url" name="url" class="form-control" value="<?php echo $isv_siteDetails['s_url'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="title" class="form-control" value="<?php echo $isv_siteDetails['s_title'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="email" name="email" class="form-control" value="<?php echo $isv_siteDetails['s_email'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Timezone</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="timezone" class="form-control" value="<?php echo $isv_siteDetails['s_time_zone'] ?>">
                    </div>
                </div>
               
                <div class="form-group">
                <input type="hidden" name="aop" value="gen" />
                <button type="submit" class="btn btn-success">Save Details</button>
                </div>
            </form>
            
            </div>
            
            <div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Theme Settings</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
            	<div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Current Theme Name</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" value="<?php echo $isv_siteDetails['s_theme'] ?>" disabled="disabled">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">New Theme Name</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="enter theme name" name="theme" required="required">
                    </div>
                </div>
                <div class="form-group">
                <input type="hidden" name="aop" value="c_theme" />
                <button type="submit" class="btn btn-success">Save Theme</button>
                </div>
            </form>
            </div>
        </div><!-- end::col-md-6 -->

    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Security Settings</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
            	<div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Admin url name</label>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" value="<?php echo $isv_siteSettings['adminEnd'] ?>" name="admin" required="required">
                        <div class="adm-uri"><?php echo $isv_siteDetails['s_url'].'/' ?><span><?php echo $isv_siteSettings['adminEnd'] ?></span></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-1 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="ssl" <?php if($isv_siteDetails['s_enable_ssl'] === 1) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-11 col-sm-3 col-xs-12">
                    	<label class="control-label">Enable SSL (only if you have an SSL certificate installed)</label>
                    </div>
                </div>
                
                <div class="form-group col-md-12">
                <input type="hidden" name="aop" value="security" />
                <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
			</div>
            
            <div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Site Status Settings</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
            	<div class="form-group">
                    <div class="col-md-2 col-sm-9 col-xs-12">
                        <input type="checkbox" value="0" name="status" <?php if($isv_siteDetails['s_status'] === 0) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-10 col-sm-3 col-xs-12">
                    	<label class="control-label">Maintenance Mode</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="errors" <?php if($isv_siteSettings['hide_errors'] === 1) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-10 col-sm-3 col-xs-12">
                    	<label class="control-label">Hide PHP errors</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="reg" <?php if($isv_siteSettings['user_reg'] === 1) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-10 col-sm-3 col-xs-12">
                    	<label class="control-label">Allow new member registrations</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="validate" <?php if($isv_siteSettings['user_validate'] === 1) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-10 col-sm-3 col-xs-12">
                    	<label class="control-label">New members MUST validate their accounts</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="timezone" <?php if($isv_siteSettings['defaultTzone'] === 1) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-10 col-sm-3 col-xs-12">
                    	<label class="control-label">Use server timezone</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="cronjob" <?php if($isv_siteSettings['sys_cron'] === 1) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-10 col-sm-3 col-xs-12">
                    	<label class="control-label">Run system cronjob</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group">
                    <div class="col-md-2 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="notify_admin" <?php if($isv_siteSettings['notifyAdmin_newUser'] === 1) {?> checked <?php } ?>>
                    </div>
                    <div class="col-md-10 col-sm-3 col-xs-12">
                    	<label class="control-label">Receive an email when a new member registers.</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group col-md-12">
                <input type="hidden" name="aop" value="s_settings" />
                <button type="submit" class="btn btn-success">Save Status</button>
                </div>
                </form>
			</div>
		</div><!-- end::col-md-6 -->
        
        
        
        
        
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>