<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
    <section id="forgotPwd">
    	<div class="container">
            <div class="well col-md-6" style="padding:30px;">
            <legend><i class="fa fa-user-plus"></i> Reset Password!</legend>
            <form action="<?php echo ISVIPI_URL .'p/users' ?>" method="post" class="form" role="form" id="regForm">
            	<div class="row">
                	<input class="form-control" name="user" placeholder="Email or username registered with us*" type="text" autofocus required/>
                </div>
                <hr />
                <div class="row">
                	<input type="hidden" name="isv_op" value="<?php echo $converter->encode('reset') ?>" />
                    <button class="btn btn-lg btn-success btn-block" type="submit">Reset Password</button>
            	</div>
            </form>
          </div>
          
          <div class="well col-sm-5 white-gradient" style="padding:10px; color:#000000; margin:0 10px">
          	<p>We will send you an email with a password reset link. Follow instructions contained in that email to reset your password.</p>
          </div>
        </div>
    </section><!--/#error-->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>