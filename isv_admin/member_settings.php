<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Member Settings
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Member Settings</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Member Settings</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                  <div class="box-body">
                  	<div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="reg" <?php if(ALLOW_USER_REG) {?> checked <?php } ?>> Allow new member registration (this will enable new users to create accounts)
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="validate" <?php if(MUST_VALIDATE) {?> checked <?php } ?>> New members MUST validate their accounts
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="notify_admin" <?php if(NOTIFY_ADMIN_NEW_USER) {?> checked <?php } ?>> Receive an email when a new member registers
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="notify_acc_del" <?php if(ISV_EMAIL_NOTIFY_ACCOUNT_DELETION) {?> checked <?php } ?>> Email user when account is scheduled for deletion.
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="notify_acc_undel" <?php if(ISV_EMAIL_NOTIFY_ACCOUNT_UNDELETION) {?> checked <?php } ?>> Email user when account is removed from scheduled deletion
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="notify_acc_sus" <?php if(ISV_EMAIL_NOTIFY_ACCOUNT_SUSPENDED) {?> checked <?php } ?>> Email user when account is suspended
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="notify_acc_unsus" <?php if(ISV_EMAIL_NOTIFY_ACCOUNT_UNSUSPENDED) {?> checked <?php } ?>> Email user when account is unsuspended
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="notify_acc_act" <?php if(ISV_EMAIL_NOTIFY_ACCOUNT_ACTIVATION) {?> checked <?php } ?>> Email user when an admin activates his/her account
                      </label>
                    </div>
                    <hr style="margin:7px 0" />
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('m_settings') ?>" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            <div class="col-md-6">
            	<div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Photo Album Settings</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    	<form role="form" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                        	<div class="form-group">
                              <label for="maximum photo albums">Maximum Photo Albums</label>
                              <input type="number" name="max_photo_albms" class="form-control" value="<?php echo MAX_PHOTO_ALBMS ?>">
                              <div class="text-blue">maximum number of photo albums each member can have (0-99)</div>
                            </div>
                            <div class="form-group">
                              <label for="maximum photos in album">Maximum Photos in Album</label>
                              <input type="number" name="max_photos_inalbm" class="form-control" value="<?php echo MAX_PHOTOS_IN_ALBM ?>">
                              <div class="text-blue">maximum number of photos in each album (0-99)</div>
                            </div>
                          	<div class="box-footer">
                                <input type="hidden" name="aop" value="<?php echo $converter->encode('s_photo_albms') ?>" />
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                      	</form>
                    </div><!-- /.box-body -->
               </div><!-- /.box -->
           </div>



        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>