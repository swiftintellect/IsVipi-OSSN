<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_CLASSES_BASE .'staticpages/class.staticpages.php');
	$sp = new staticpage();
	$content = $sp->get_static_page('terms');
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Terms & Conditions
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Terms & Conditions</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-12">
            	<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Terms & Conditions</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/staticpages' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <textarea name="content" rows="10" class="form-control" id="editor"><?php echo $content ?></textarea>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('terms') ?>" />
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            
		<div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>