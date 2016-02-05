<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Security Settings
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Security Settings</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Admin URL</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="site url">Admin URL</label>
                      <input type="text" class="form-control" value="<?php echo $isv_siteSettings['adminEnd'] ?>" name="admin" required="required">
                      <p style="background:#EBEBEB; padding:5px;"><?php echo $isv_siteDetails['s_url'].'/' ?><span class="text-green"><?php echo $isv_siteSettings['adminEnd'] ?></span></p>
                    </div>
                    <hr />
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="ssl" <?php if($isv_siteDetails['s_enable_ssl'] === 1) {?> checked <?php } ?>> Enable SSL (only if you have an SSL certificate installed)
                      </label>
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('security') ?>" />
                    <button type="submit" class="btn btn-primary">Change Admin URL</button>
                  </div>
                </form>
              </div><!-- /.box -->
              
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Encryption Key</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="site url">Encryption Key</label>
                      <input type="text" class="form-control" value="<?php echo ISV_ENCR_KEY ?>" name="key" required="required">
                      <p style="background:#EBEBEB; padding:5px;"><a href="https://www.random.org/strings/?num=1&len=16&digits=on&upperalpha=on&loweralpha=on&unique=on&format=html&rnd=new" target="_blank" title="Generate new Key">Click here</a> to generate new key</p>
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('enc_key') ?>" />
                    <button type="submit" class="btn btn-primary">Change Admin URL</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div><!-- end: col-md-6 -->
            
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
                        	<dt>Admin URL</dt>
                        	<dd>This is the link to access our admin panel. Please make sure that you use a word that you can easily remember but will be hard to guess for someone else. By default, the word is <span class="text-green">admin</span> but it is strongly recommended that you change this. Also, <span class="text-red">isv_admin</span> is a reserved word so don't use it. It will result in errors.</dd>
                            <hr style="margin:8px 0" />
                            <dt>Encryption Key</dt>
                        	<dd>It is recommended that once you generate the encryption key (preferably just after installation), you do not change it again, unless it is absolutely necessary. This is because when account validation emails, for example, are sent out, they may contain an earlier key and if you change this often, many accounts will not be validated.</dd>
                        </dl>
                      
                    </div><!-- /.box-body -->
               </div><!-- /.box -->
            </div>


        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>