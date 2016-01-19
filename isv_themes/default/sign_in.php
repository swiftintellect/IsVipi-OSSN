<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
    <section id="forgotPwd">
    	<div class="container">
            <div class="well col-md-6" style="padding:30px;">
            <legend><i class="fa fa-user-plus"></i> Sign In!</legend>
            <form action="<?php echo ISVIPI_URL .'p/users' ?>" method="post" class="form" role="form" id="regForm">
            	<div class="row">
                    <input type="text" class="form-control" name="user" placeholder="Email or Username">
                </div>
                <br />
                <div class="row">
                    <input type="password" class="form-control" name="pwd" placeholder="Password">
                </div>
                    <input type="hidden" name="isv_op" value="<?php echo $converter->encode('signin') ?>" />
                <hr />
                <div class="row">
                    <button class="btn btn-lg btn-success btn-block" type="submit">Sign In</button>
            	</div>
            </form>
          </div>
          
          <div class="well col-sm-5 white-gradient" style="padding:5px; margin:0 10px">
          	<h2>Don't have an account?</h2>
            <a href="<?php echo ISVIPI_URL ?>" class="btn btn-lg btn-primary">Register</a>
          </div>
        </div>
    </section><!--/#error-->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>