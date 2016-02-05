<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            General Settings
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">General Settings</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">General Settings</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="site url">Site URL</label>
                      <input type="url" name="url" class="form-control" value="<?php echo $isv_siteDetails['s_url'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="site title">Site Title</label>
                      <input type="text" name="title" class="form-control" value="<?php echo $isv_siteDetails['s_title'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="site email">Site Email</label>
                      <input type="email" name="email" class="form-control" value="<?php echo $isv_siteDetails['s_email'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="site email">Site Timezone</label>
                      <input type="text" name="timezone" class="form-control" value="<?php echo $isv_siteDetails['s_time_zone'] ?>">
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('gen') ?>" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            
            <div class="col-md-6">
            	<div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-question-circle"></i></h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    	<dl>
                        	<dt>Site URL</dt>
                        	<dd>Site URL must be in the format http://yoursite.com without www.</dd>
                            <hr style="margin:5px 0" />
                            <dt>Use Default Timezone</dt>
                        	<dd>Check this if correct time (feeds, alerts, chats) is not being displayed on the site.</dd>
                        </dl>
                      
                    </div><!-- /.box-body -->
               </div><!-- /.box -->
              
              <!-- general form elements -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Site Status Settings</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                  <div class="box-body">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="status" <?php if($isv_siteDetails['s_status'] === 1) {?> checked <?php } ?>> Maintenance Mode (your site will switch to Maintenance Mode)
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="errors" <?php if($isv_siteSettings['hide_errors'] === 1) {?> checked <?php } ?>> Hide PHP errors <span class="text-green">(Recommended)</span>
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="timezone" <?php if($isv_siteSettings['defaultTzone'] === 1) {?> checked <?php } ?>> Use default site timezone, <?php echo ISV_DEFAULT_TZ ?>. <span class="text-green">(Recommended)</span>
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="cronjob" <?php if($isv_siteSettings['sys_cron'] === 1) {?> checked <?php } ?>> Run system cronjob (<a href="http://isvipi.org/docs/#cronjobs" target="_blank"><span class="blue">learn more</span></a>)
                      </label>
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('s_settings') ?>" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>

		<div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>