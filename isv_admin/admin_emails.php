<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php');
	$members = new get_members();
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Emailing
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Emailing</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Mass Mailing</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/emailing' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label>To</label>
                      <select class="form-control" name="type">
                        <option value="all">All Members(<?php echo $members->total('all') ?>)</option>
                        <option value="active">Active Members(<?php echo $members->total('active') ?>)</option>
                        <option value="inactive">Inactive Members(<?php echo $members->total('inactive') ?>)</option>
                        <option value="suspended">Suspended Members(<?php echo $members->total('suspended') ?>)</option>
                        <option value="pending_deletion">Members Scheduled for Deletion (<?php echo $members->total('pending_deletion') ?>)</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="subject">Subject</label>
                      <input type="text" name="subject" class="form-control" placeholder="Enter subject">
                    </div>
                    <div class="form-group">
                      <label for="message">Message</label>
                      <textarea name="msg" rows="10" class="form-control" id="editor"></textarea>
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('m_email') ?>" />
                    <button type="submit" class="btn btn-primary">Send Mass Email</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Individual Email</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/emailing' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="user email">Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Enter user email">
                    </div>
                    <div class="form-group">
                      <label for="subject">Subject</label>
                      <input type="text" name="subject" class="form-control" placeholder="Enter subject">
                    </div>
                    <div class="form-group">
                      <label for="message">Message</label>
                      <textarea name="msg" rows="10" class="form-control" id="editor2"></textarea>
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('s_email') ?>" />
                    <button type="submit" class="btn btn-primary">Send Individual Email</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>


        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>