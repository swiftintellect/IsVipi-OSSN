<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Help/Support
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Help/Support</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Customizations & Custom Project</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <p>At IsVipi OSSN, we have a team of experienced fullstack web-developers with years of experience in software development. We have the skills, knowledge and equipment to oversee your project from conception, planning, design, development, testing and debugging to its launch. No matter the size of the project (simple static websites to large dynamic systems), we can guarantee you satisfaction. We rely on the latest technologies and our development approach allows for extensibility, versatility and portability of your software. Did I mention that we are discreet? Bound with a Non-Disclosure Agreement (NDA), or without, your project is safe with us.  </p>
<p>Also, if you have your own preferences with regard to IsVipi OSSN, we can tweak, modify and update it with your desired features and design. Having built the system, we better understand its nooks and cranny and therefore confident that we can deliver what you envision.</p>
<p>If interested, you can reach us using the form provided, or by email or on our Skype handle. We look forward to hearing from you.</p>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Talk to Us</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <p>Skype: IsVipiOfficial</p> 
                  <p>Email: support@isvipi.org</p>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            
            <div class="col-md-6">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Send Inquiry to our Team at IsVipi OSSN</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/inquiry' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="Reply to email">Reply To Email:</label>
                      <input type="email" name="replyTo" class="form-control" placeholder="Reply to email" required="required">
                      <small>Please provide an email we will use to reply to your inquiry.</small>
                    </div>
                    <div class="form-group">
                      <label for="subject">Subject:</label>
                      <input type="text" name="subject" class="form-control" placeholder="Please enter the subject of your inquiry" required="required">
                    </div>
                    <div class="form-group">
                      <label for="inquiry">Inquiry</label>
                      <textarea name="msg" rows="10" class="form-control" required></textarea>
                      <small>Please be as detailed as possible so that we can better respond to your inquiry.</small>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('inquiry') ?>" />
                    <button type="submit" class="btn btn-primary">Submit Inquiry</button>
                  </div>
                </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->

		<div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>