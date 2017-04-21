<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Admin Profile
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Admin Profile</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
            	<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Profile</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/admins' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="email">Email (used during login)</label>
                      <input type="email" name="email" class="form-control" value="<?php echo $admin['email'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $admin['name'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="date of registration">Date of Registration</label>
                      <input type="text" class="form-control" value="<?php echo $admin['reg_date'] ?>" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="level">Level</label>
                      <input type="text" class="form-control" value="<?php echo $admin['level'] ?>" disabled="disabled">
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('edit') ?>" />
                    <button type="submit" class="btn btn-primary">Edit</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            
            <div class="col-md-6">
            	<div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Change Password</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                     <div class="alert alert-warning" style="padding:10px;">
                        Once the password is changed, you will be automatically logged out.
                    </div>
                        <!-- form start -->
                        <form role="form" action="<?php echo ISVIPI_URL .'aa/admins' ?>" method="POST">
                          <div class="box-body">
                            <div class="form-group">
                              <label for="current password">Current Password</label>
                              <input type="password" name="c_pwd" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                              <label for="new password">New Password</label>
                              <input type="password" name="pwd" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                              <label for="repeat new password">Repeat new Password</label>
                              <input type="password" class="form-control" name="pwd2" required="required">
                            </div>
                          </div><!-- /.box-body -->
        
                          <div class="box-footer">
                            <input type="hidden" name="aop" value="<?php echo $converter->encode('change_pwd') ?>" />
                            <button type="submit" class="btn btn-primary">Edit</button>
                          </div>
                        </form>

                    </div><!-- /.box-body -->
               </div><!-- /.box -->
            
            </div>
            <div class="clearfix"></div>


        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>